<?php

namespace App\Http\Controllers;

use App\Models\CatalogImage;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CatalogAssetController extends Controller
{
    public function show(CatalogImage $catalogImage): BinaryFileResponse
    {
        abort_unless($catalogImage->is_active, Response::HTTP_NOT_FOUND);

        $sourcePath = $catalogImage->source_asset_path
            ? base_path($catalogImage->source_asset_path)
            : null;

        abort_unless($sourcePath && is_file($sourcePath), Response::HTTP_NOT_FOUND);

        return response()->file($sourcePath, [
            'Cache-Control' => 'public, max-age=86400',
            'Content-Disposition' => 'inline; filename="'.basename($sourcePath).'"',
        ]);
    }
}
