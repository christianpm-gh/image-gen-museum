<?php

namespace Database\Factories;

use App\Enums\MemoryGenerationStatus;
use App\Models\MemoryGeneration;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemoryGeneration>
 */
class MemoryGenerationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ticket_id' => Ticket::factory(),
            'status' => MemoryGenerationStatus::Queued,
            'emotion_text' => $this->faker->sentence(12),
            'selected_catalog_image_ids' => [1],
            'queued_at' => now(),
        ];
    }
}
