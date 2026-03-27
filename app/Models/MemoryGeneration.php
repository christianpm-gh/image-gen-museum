<?php

namespace App\Models;

use App\Enums\MemoryGenerationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class MemoryGeneration extends Model
{
    /** @use HasFactory<\Database\Factories\MemoryGenerationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'status',
        'emotion_text',
        'prompt_snapshot',
        'selected_catalog_image_ids',
        'generated_disk',
        'generated_path',
        'generated_url',
        'provider_model',
        'error_message',
        'metadata',
        'queued_at',
        'started_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => MemoryGenerationStatus::class,
            'selected_catalog_image_ids' => 'array',
            'metadata' => 'array',
            'queued_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function selectedCatalogImageIds(): Collection
    {
        return collect($this->selected_catalog_image_ids ?? [])->map(fn ($id) => (int) $id);
    }

    public function getDisplayUrlAttribute(): ?string
    {
        if (! $this->generated_disk || ! $this->generated_path) {
            return $this->generated_url;
        }

        try {
            $visibility = (string) config("filesystems.disks.{$this->generated_disk}.visibility", 'public');

            if ($visibility !== 'public') {
                return Storage::disk($this->generated_disk)->temporaryUrl(
                    $this->generated_path,
                    now()->addMinutes(20)
                );
            }

            return Storage::disk($this->generated_disk)->url($this->generated_path);
        } catch (\Throwable) {
            return $this->generated_url;
        }
    }
}
