<?php

namespace Tests\Feature;

use App\Models\CatalogImage;
use App\Services\MuseumAssetStorage;
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

        $this->assertCount(8, CatalogImage::query()->where('is_active', true)->get());
        $this->assertDatabaseMissing('catalog_images', ['source_name' => null]);
        $this->assertDatabaseMissing('catalog_images', ['license_name' => null]);
        $this->assertDatabaseMissing('catalog_images', ['attribution_text' => null]);
    }

    public function test_each_room_keeps_at_least_four_active_images(): void
    {
        $this->seed(DatabaseSeeder::class);

        $rooms = \App\Models\MuseumRoom::query()
            ->with('exhibitions.catalogImages')
            ->get();

        $this->assertCount(2, $rooms);

        foreach ($rooms as $room) {
            $activeImages = $room->exhibitions
                ->flatMap->catalogImages
                ->where('is_active', true);

            $this->assertGreaterThanOrEqual(4, $activeImages->count(), $room->title);
        }
    }

    public function test_bootstrap_command_syncs_all_real_catalog_assets(): void
    {
        Storage::fake('museum_catalog');
        config()->set('museum.catalog_disk', 'museum_catalog');

        $this->seed(DatabaseSeeder::class);

        $this->artisan('museum:bootstrap-assets')
            ->assertSuccessful();

        $images = CatalogImage::query()->get();

        $this->assertCount(8, $images);

        foreach ($images as $image) {
            $freshImage = $image->fresh();

            $this->assertNotNull($freshImage->storage_path);
            Storage::disk('museum_catalog')->assertExists($freshImage->storage_path);
        }
    }

    public function test_catalog_asset_route_serves_versioned_local_images(): void
    {
        $this->seed(DatabaseSeeder::class);

        $image = CatalogImage::query()->firstOrFail();

        $response = $this->get(route('catalog-images.show', $image))
            ->assertOk();

        $this->assertStringContainsString(
            'max-age=86400',
            (string) $response->headers->get('cache-control')
        );
    }

    public function test_reference_image_payload_prefers_local_versioned_asset(): void
    {
        $this->seed(DatabaseSeeder::class);

        $image = CatalogImage::query()->firstOrFail();

        $payload = app(MuseumAssetStorage::class)->referenceImagePayload($image);

        $this->assertNotEmpty($payload['contents']);
        $this->assertSame(basename($image->source_asset_path), $payload['filename']);
    }

    public function test_supabase_public_url_is_built_for_catalog_assets(): void
    {
        config()->set('filesystems.disks.museum_catalog.endpoint', 'https://demo-project.storage.supabase.co/storage/v1/s3');
        config()->set('filesystems.disks.museum_catalog.bucket', 'museum-catalog');

        $url = app(MuseumAssetStorage::class)->publicUrl('museum_catalog', 'catalog/demo/obra.jpg');

        $this->assertSame(
            'https://demo-project.supabase.co/storage/v1/object/public/museum-catalog/catalog/demo/obra.jpg',
            $url
        );
    }
}
