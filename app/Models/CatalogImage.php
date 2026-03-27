<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CatalogImage extends Model
{
    /** @use HasFactory<\Database\Factories\CatalogImageFactory> */
    use HasFactory;

    protected $fillable = [
        'exhibition_id',
        'title',
        'slug',
        'description',
        'alt_text',
        'palette',
        'source_asset_path',
        'storage_disk',
        'storage_path',
        'public_url',
        'source_name',
        'source_url',
        'creator_name',
        'creator_url',
        'license_name',
        'license_url',
        'attribution_text',
        'size_hint',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function getDisplayUrlAttribute(): ?string
    {
        $sourcePath = $this->source_asset_path ? base_path($this->source_asset_path) : null;

        if ($sourcePath && is_file($sourcePath)) {
            try {
                return route('catalog-images.show', $this);
            } catch (\Throwable) {
                // Fall through to storage/public URL resolution.
            }
        }

        if ($this->public_url) {
            return $this->public_url;
        }

        if (! $this->storage_disk || ! $this->storage_path) {
            return $this->public_url;
        }

        try {
            return Storage::disk($this->storage_disk)->url($this->storage_path);
        } catch (\Throwable) {
            return $this->public_url;
        }
    }
}
