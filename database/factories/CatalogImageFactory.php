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
            'source_name' => 'Archivo curado',
            'source_url' => 'https://commons.wikimedia.org',
            'creator_name' => $this->faker->name(),
            'creator_url' => $this->faker->optional()->url(),
            'license_name' => 'CC0 1.0',
            'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
            'attribution_text' => $this->faker->sentence(),
            'sort_order' => 1,
            'is_active' => true,
        ];
    }
}
