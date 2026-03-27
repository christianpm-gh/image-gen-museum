<?php

namespace Tests\Feature;

use App\Models\CatalogImage;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CatalogAssetsTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_populates_catalog_images_with_attribution_metadata(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertCount(6, CatalogImage::query()->where('is_active', true)->get());
        $this->assertDatabaseMissing('catalog_images', ['source_name' => null]);
        $this->assertDatabaseMissing('catalog_images', ['license_name' => null]);
        $this->assertDatabaseMissing('catalog_images', ['attribution_text' => null]);
    }

    public function test_bootstrap_command_syncs_all_real_catalog_assets(): void
    {
        Storage::fake('museum_catalog');
        config()->set('museum.catalog_disk', 'museum_catalog');

        $this->seed(DatabaseSeeder::class);

        $this->artisan('museum:bootstrap-assets')
            ->assertSuccessful();

        $images = CatalogImage::query()->get();

        $this->assertCount(6, $images);

        foreach ($images as $image) {
            $freshImage = $image->fresh();

            $this->assertNotNull($freshImage->storage_path);
            Storage::disk('museum_catalog')->assertExists($freshImage->storage_path);
        }
    }
}
