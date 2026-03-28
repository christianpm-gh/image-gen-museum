<?php

namespace App\Jobs;

use App\Enums\MemoryGenerationStatus;
use App\Enums\TicketStatus;
use App\Models\CatalogImage;
use App\Models\MemoryGeneration;
use App\Services\MemoryPromptBuilder;
use App\Services\MuseumAssetStorage;
use App\Services\OpenAiImageGenerator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessMemoryGenerationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    public function __construct(
        public int $memoryGenerationId,
    ) {
    }

    public function handle(
        OpenAiImageGenerator $imageGenerator,
        MuseumAssetStorage $assetStorage,
        MemoryPromptBuilder $promptBuilder,
    ): void
    {
        /** @var \App\Models\MemoryGeneration $memoryGeneration */
        $memoryGeneration = MemoryGeneration::query()->with('ticket.user')->findOrFail($this->memoryGenerationId);

        $catalogImages = CatalogImage::query()
            ->with('exhibition.museumRoom')
            ->whereIn('id', $memoryGeneration->selectedCatalogImageIds())
            ->get();

        $memoryGeneration->update([
            'status' => MemoryGenerationStatus::Processing,
            'started_at' => now(),
        ]);

        try {
            $prompt = $promptBuilder->build($memoryGeneration, $catalogImages);
            $result = $imageGenerator->generate($prompt);

            $stored = $assetStorage->storeGeneratedImage($memoryGeneration->load('ticket'), $result['binary']);

            DB::transaction(function () use ($memoryGeneration, $prompt, $result, $stored) {
                $memoryGeneration->update([
                    'status' => MemoryGenerationStatus::Completed,
                    'prompt_snapshot' => $prompt,
                    'generated_disk' => $stored['disk'],
                    'generated_path' => $stored['path'],
                    'generated_url' => $stored['url'],
                    'provider_model' => $result['model'],
                    'metadata' => array_filter([
                        'generation_mode' => 'text_prompt',
                        'revised_prompt' => $result['revised_prompt'],
                    ]),
                    'completed_at' => now(),
                    'error_message' => null,
                ]);

                $memoryGeneration->ticket->update([
                    'status' => TicketStatus::Consumed,
                    'consumed_at' => now(),
                ]);

                $memoryGeneration->ticket->accessToken()?->update([
                    'last_used_at' => now(),
                ]);
            });
        } catch (\Throwable $exception) {
            DB::transaction(function () use ($memoryGeneration, $exception, $imageGenerator) {
                $memoryGeneration->update([
                    'status' => MemoryGenerationStatus::Failed,
                    'provider_model' => $imageGenerator->lastAttemptedModel(),
                    'error_message' => $exception->getMessage(),
                    'metadata' => array_filter([
                        'generation_mode' => 'text_prompt',
                        'attempted_model' => $imageGenerator->lastAttemptedModel(),
                        'image_size' => config('services.openai.image_size'),
                        'image_quality' => config('services.openai.image_quality'),
                    ]),
                    'completed_at' => now(),
                ]);

                $memoryGeneration->ticket->update([
                    'status' => TicketStatus::Issued,
                    'reserved_at' => null,
                ]);
            });

            throw $exception;
        }
    }
}
