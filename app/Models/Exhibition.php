<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exhibition extends Model
{
    /** @use HasFactory<\Database\Factories\ExhibitionFactory> */
    use HasFactory;

    protected $fillable = [
        'museum_room_id',
        'title',
        'slug',
        'summary',
        'description',
        'emotional_prompt',
        'curator_note',
        'sort_order',
    ];

    public function museumRoom(): BelongsTo
    {
        return $this->belongsTo(MuseumRoom::class);
    }

    public function catalogImages(): HasMany
    {
        return $this->hasMany(CatalogImage::class)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
