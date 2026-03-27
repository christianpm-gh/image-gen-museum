<?php

namespace Database\Factories;

use App\Models\MuseumRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MuseumRoom>
 */
class MuseumRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->words(2, true),
            'slug' => $this->faker->unique()->slug(2),
            'hero_eyebrow' => $this->faker->words(2, true),
            'summary' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'accent_color' => '#60a5fa',
            'sort_order' => 1,
        ];
    }
}
