<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MuseumRoom extends Model
{
    /** @use HasFactory<\Database\Factories\MuseumRoomFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'hero_eyebrow',
        'summary',
        'description',
        'accent_color',
        'cover_image_url',
        'sort_order',
    ];

    public function exhibitions(): HasMany
    {
        return $this->hasMany(Exhibition::class)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
