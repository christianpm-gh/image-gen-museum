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

        $uploaded = false;

        try {
            $uploaded = (bool) Storage::disk($disk)->put($destination, file_get_contents($sourcePath), ['visibility' => 'public']);
        } catch (\Throwable) {
            $uploaded = false;
        }

        return tap($catalogImage)->update([
            'storage_disk' => $disk,
            'storage_path' => $uploaded ? $destination : $catalogImage->storage_path,
            'public_url' => $uploaded ? $this->publicUrl($disk, $destination) : $catalogImage->public_url,
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

        if ($supabaseUrl = $this->supabasePublicUrl($disk, $path)) {
            return $supabaseUrl;
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
        $sourcePath = $catalogImage->source_asset_path ? base_path($catalogImage->source_asset_path) : null;

        if ($sourcePath && is_file($sourcePath)) {
            return [
                'contents' => file_get_contents($sourcePath),
                'filename' => basename($sourcePath) ?: ($catalogImage->slug ?: 'reference').'.png',
            ];
        }

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

    private function supabasePublicUrl(string $disk, string $path): ?string
    {
        $endpoint = (string) config("filesystems.disks.{$disk}.endpoint", '');
        $bucket = (string) config("filesystems.disks.{$disk}.bucket", '');

        if ($endpoint === '' || $bucket === '') {
            return null;
        }

        $host = parse_url($endpoint, PHP_URL_HOST);

        if (! is_string($host) || ! str_contains($host, 'supabase.co')) {
            return null;
        }

        $projectRef = Str::before($host, '.');

        if ($projectRef === '') {
            return null;
        }

        return sprintf(
            'https://%s.supabase.co/storage/v1/object/public/%s/%s',
            $projectRef,
            $bucket,
            ltrim($path, '/')
        );
    }
}
