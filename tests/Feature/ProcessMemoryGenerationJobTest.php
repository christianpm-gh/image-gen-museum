<?php

namespace Tests\Feature;

use App\Enums\MemoryGenerationStatus;
use App\Enums\OrderStatus;
use App\Enums\TicketStatus;
use App\Enums\TicketType;
use App\Jobs\ProcessMemoryGenerationJob;
use App\Models\CatalogImage;
use App\Models\Exhibition;
use App\Models\MemoryGeneration;
use App\Models\MuseumRoom;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProcessMemoryGenerationJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_completes_generation_and_consumes_ticket(): void
    {
        Storage::fake('generated_memories');

        [$memory] = $this->makeQueuedGeneration();

        Http::fake([
            'https://api.openai.com/v1/images/generations' => Http::response([
                'data' => [[
                    'b64_json' => base64_encode('generated-image'),
                    'revised_prompt' => 'prompt revisado',
                ]],
            ], 200),
        ]);

        config()->set('services.openai.api_key', 'test-key');

        (new ProcessMemoryGenerationJob($memory->id))->handle(
            app(\App\Services\OpenAiImageGenerator::class),
            app(\App\Services\MuseumAssetStorage::class),
            app(\App\Services\MemoryPromptBuilder::class),
        );

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.openai.com/v1/images/generations'
                && $request['prompt'] !== null
                && ! str_contains($request->body(), 'image[]');
        });

        $memory->refresh();

        $this->assertSame(MemoryGenerationStatus::Completed, $memory->status);
        $this->assertNotNull($memory->generated_path);
        $this->assertSame(TicketStatus::Consumed, $memory->ticket->fresh()->status);
        $this->assertSame('text_prompt', $memory->metadata['generation_mode']);
    }

    public function test_job_failure_releases_ticket_again(): void
    {
        [$memory] = $this->makeQueuedGeneration();

        Http::fake([
            'https://api.openai.com/v1/images/generations' => Http::response([
                'error' => [
                    'message' => 'insufficient credits',
                ],
            ], 429),
        ]);

        config()->set('services.openai.api_key', 'test-key');

        try {
            (new ProcessMemoryGenerationJob($memory->id))->handle(
                app(\App\Services\OpenAiImageGenerator::class),
                app(\App\Services\MuseumAssetStorage::class),
                app(\App\Services\MemoryPromptBuilder::class),
            );
        } catch (\Throwable) {
        }

        $memory->refresh();

        $this->assertSame(MemoryGenerationStatus::Failed, $memory->status);
        $this->assertSame(TicketStatus::Issued, $memory->ticket->fresh()->status);
        $this->assertSame('text_prompt', $memory->metadata['generation_mode']);
        $this->assertSame(config('services.openai.image_fallback_model'), $memory->metadata['attempted_model']);
        $this->assertStringContainsString('HTTP 429', $memory->error_message);
    }

    /**
     * @return array{0: MemoryGeneration, 1: CatalogImage}
     */
    protected function makeQueuedGeneration(): array
    {
        $user = User::factory()->create();
        $room = MuseumRoom::factory()->create();
        $exhibition = Exhibition::factory()->for($room)->create();
        $catalogImage = CatalogImage::factory()->for($exhibition)->create([
            'public_url' => 'https://images.example.test/reference.png',
        ]);

        $order = Order::factory()->for($user)->create([
            'ticket_type' => TicketType::Standard,
            'status' => OrderStatus::Completed,
        ]);

        $ticket = Ticket::factory()->for($order)->for($user)->create([
            'ticket_type' => TicketType::Standard,
            'status' => TicketStatus::Reserved,
        ]);

        $memory = MemoryGeneration::factory()->for($user)->for($ticket)->create([
            'status' => MemoryGenerationStatus::Queued,
            'selected_catalog_image_ids' => [$catalogImage->id],
            'emotion_text' => 'Sentí una calma azul, fría y muy contemplativa.',
        ]);

        return [$memory, $catalogImage];
    }
}
