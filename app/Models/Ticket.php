<?php

namespace App\Models;

use App\Enums\TicketStatus;
use App\Enums\TicketType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'uuid',
        'ticket_type',
        'status',
        'issued_at',
        'reserved_at',
        'consumed_at',
    ];

    protected function casts(): array
    {
        return [
            'ticket_type' => TicketType::class,
            'status' => TicketStatus::class,
            'issued_at' => 'datetime',
            'reserved_at' => 'datetime',
            'consumed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accessToken(): HasOne
    {
        return $this->hasOne(TicketAccessToken::class);
    }

    public function memoryGenerations(): HasMany
    {
        return $this->hasMany(MemoryGeneration::class)->latest();
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function requiredCatalogImages(): int
    {
        return $this->ticket_type->requiredCatalogImages();
    }
}
