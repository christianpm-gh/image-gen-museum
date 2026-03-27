<?php

namespace App\Services;

use App\Models\CatalogImage;
use App\Models\MemoryGeneration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MuseumAssetStorage
{
    public function publishCatalogAsset(CatalogImage $catalogImage): CatalogImage
    {
        $disk = config('museum.catalog_disk', 'museum_catalog');
        $sourcePath = base_path($catalogImage->source_asset_path);
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION) ?: 'svg';
        $destination = sprintf(
            'catalog/%s/%s.%s',
            $catalogImage->exhibition->slug,
            $catalogImage->slug ?: Str::slug($catalogImage->title),
            $extension
        );

        Storage::disk($disk)->put($destination, file_get_contents($sourcePath), ['visibility' => 'public']);

        return tap($catalogImage)->update([
            'storage_disk' => $disk,
            'storage_path' => $destination,
            'public_url' => $this->publicUrl($disk, $destination),
        ]);
    }

    /**
     * @return array{disk:string, path:string, url:string}
     */
    public function storeGeneratedImage(MemoryGeneration $memoryGeneration, string $binary, string $extension = 'png'): array
    {
        $disk = config('museum.generated_disk', 'generated_memories');
        $filename = sprintf(
            '%s/%s.%s',
            now()->format('Y/m/d'),
            $memoryGeneration->ticket->uuid.'-'.Str::uuid(),
            $extension
        );

        Storage::disk($disk)->put($filename, $binary);

        return [
            'disk' => $disk,
            'path' => $filename,
            'url' => $this->publicUrl($disk, $filename),
        ];
    }

    public function publicUrl(string $disk, string $path): ?string
    {
        if ($path === '') {
            return null;
        }

        try {
            return Storage::disk($disk)->url($path);
        } catch (\Throwable) {
            return null;
        }
    }

    public function temporaryUrl(string $disk, string $path, int $minutes = 20): ?string
    {
        if ($path === '') {
            return null;
        }

        try {
            return Storage::disk($disk)->temporaryUrl($path, now()->addMinutes($minutes));
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @return array{contents:string, filename:string}
     */
    public function referenceImagePayload(CatalogImage $catalogImage): array
    {
        if ($catalogImage->storage_disk && $catalogImage->storage_path) {
            return [
                'contents' => Storage::disk($catalogImage->storage_disk)->get($catalogImage->storage_path),
                'filename' => basename($catalogImage->storage_path) ?: ($catalogImage->slug ?: 'reference').'.png',
            ];
        }

        if ($catalogImage->public_url) {
            $download = Http::timeout(30)->get($catalogImage->public_url);
            $download->throw();

            return [
                'contents' => $download->body(),
                'filename' => basename(parse_url($catalogImage->public_url, PHP_URL_PATH) ?: '') ?: ($catalogImage->slug ?: 'reference').'.png',
            ];
        }

        throw new \RuntimeException("La imagen de catálogo [{$catalogImage->id}] no tiene fuente utilizable.");
    }
}
