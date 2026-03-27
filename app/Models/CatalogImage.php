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
