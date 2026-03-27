<?php

namespace App\Console\Commands;

use App\Models\CatalogImage;
use App\Services\MuseumAssetStorage;
use Illuminate\Console\Command;

class BootstrapMuseumAssets extends Command
{
    protected $signature = 'museum:bootstrap-assets';

    protected $description = 'Sube los assets curados del museo al disk configurado y actualiza sus URLs.';

    public function handle(MuseumAssetStorage $assetStorage): int
    {
        $images = CatalogImage::query()
            ->with('exhibition')
            ->whereNotNull('source_asset_path')
            ->get();

        foreach ($images as $image) {
            $publishedImage = $assetStorage->publishCatalogAsset($image);

            if ($publishedImage->storage_path) {
                $this->components->info("Asset sincronizado: {$image->title}");

                continue;
            }

            $this->components->warn("Asset disponible solo en local: {$image->title}");
        }

        $this->components->info('Assets del museo preparados correctamente.');

        return self::SUCCESS;
    }
}
