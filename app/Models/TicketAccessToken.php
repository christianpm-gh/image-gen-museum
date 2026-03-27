<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAccessToken extends Model
{
    /** @use HasFactory<\Database\Factories\TicketAccessTokenFactory> */
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'token_hash',
        'expires_at',
        'last_used_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'last_used_at' => 'datetime',
        ];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function matches(string $plainToken): bool
    {
        return hash_equals($this->token_hash, hash('sha256', $plainToken));
    }
}
