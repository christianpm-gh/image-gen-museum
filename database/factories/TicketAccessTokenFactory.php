<?php

namespace Database\Factories;

use App\Models\TicketAccessToken;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketAccessToken>
 */
class TicketAccessTokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'token_hash' => hash('sha256', 'TOKEN-DEMO-1234'),
            'expires_at' => now()->addWeek(),
        ];
    }
}
