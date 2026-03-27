<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Enums\TicketType;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'user_id' => User::factory(),
            'uuid' => (string) fake()->uuid(),
            'ticket_type' => TicketType::Standard,
            'status' => TicketStatus::Issued,
            'issued_at' => now(),
        ];
    }
}
