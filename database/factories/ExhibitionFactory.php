<?php

namespace Database\Factories;

use App\Models\Exhibition;
use App\Models\MuseumRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Exhibition>
 */
class ExhibitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'museum_room_id' => MuseumRoom::factory(),
            'title' => $this->faker->unique()->words(3, true),
            'slug' => $this->faker->unique()->slug(3),
            'summary' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'emotional_prompt' => $this->faker->sentence(),
            'curator_note' => $this->faker->sentence(),
            'sort_order' => 1,
        ];
    }
}
