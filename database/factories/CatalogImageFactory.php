<?php

namespace Database\Factories;

use App\Models\CatalogImage;
use App\Models\Exhibition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CatalogImage>
 */
class CatalogImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exhibition_id' => Exhibition::factory(),
            'title' => $this->faker->unique()->words(2, true),
            'slug' => $this->faker->unique()->slug(2),
            'description' => $this->faker->sentence(),
            'alt_text' => $this->faker->sentence(),
            'palette' => 'azul, gris, blanco',
            'sort_order' => 1,
            'is_active' => true,
        ];
    }
}
