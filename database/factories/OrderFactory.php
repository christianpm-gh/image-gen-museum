<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\TicketType;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ticket_type' => TicketType::Standard,
            'status' => OrderStatus::Completed,
            'amount' => 199,
            'currency' => 'MXN',
            'metadata' => ['source' => 'factory'],
            'completed_at' => now(),
        ];
    }
}
