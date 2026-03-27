<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catalog_images', function (Blueprint $table) {
            $table->string('source_name')->nullable()->after('public_url');
            $table->string('source_url')->nullable()->after('source_name');
            $table->string('creator_name')->nullable()->after('source_url');
            $table->string('creator_url')->nullable()->after('creator_name');
            $table->string('license_name')->nullable()->after('creator_url');
            $table->string('license_url')->nullable()->after('license_name');
            $table->text('attribution_text')->nullable()->after('license_url');
        });

        $catalogManifest = [
            'arco-sumergido' => [
                'description' => 'Oleaje azul atravesando un arco rocoso, como una puerta abierta hacia una memoria oceánica.',
                'alt_text' => 'Arco rocoso frente al mar con espuma azul y cielo despejado.',
                'palette' => 'azules, espuma, piedra',
                'source_asset_path' => 'database/seeders/assets/arco-sumergido.jpg',
                'source_name' => 'Flickr',
                'source_url' => 'https://www.flickr.com/photos/71401718@N00/4074801347',
                'creator_name' => 'Wonderlane',
                'creator_url' => 'https://www.flickr.com/photos/71401718@N00',
                'license_name' => 'CC0 1.0',
                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                'attribution_text' => '"Water under the bridge, little rock arch, splash of the Pacific Ocean, South Mazatlan, Sinaloa, Mexico" by Wonderlane (CC0 1.0), descubierto via Openverse.',
            ],
            'catedral-de-niebla' => [
                'description' => 'Una silueta gótica envuelta por neblina suave que transforma la piedra en recuerdo y atmósfera.',
                'alt_text' => 'Catedral entre neblina blanca con tonos fríos y cielo nublado.',
                'palette' => 'gris perla, azul tenue, blanco',
                'source_asset_path' => 'database/seeders/assets/catedral-de-niebla.jpg',
                'source_name' => 'Wikimedia Commons',
                'source_url' => 'https://commons.wikimedia.org/w/index.php?curid=178875322',
                'creator_name' => 'Digihum',
                'creator_url' => 'https://commons.wikimedia.org/wiki/User:Digihum',
                'license_name' => 'CC0 1.0',
                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/deed.en/',
                'attribution_text' => '"Canterbury Cathedral in the Mist" by Digihum (CC0 1.0), descubierto via Openverse.',
            ],
            'mineral-nocturno' => [
                'description' => 'Un macro de cristales brillando en la oscuridad, como si la materia recordara la luz ultravioleta.',
                'alt_text' => 'Cristales iluminados en tonos oscuros con destellos violetas.',
                'palette' => 'violeta profundo, grafito, reflejos fríos',
                'source_asset_path' => 'database/seeders/assets/mineral-nocturno.jpg',
                'source_name' => 'Flickr',
                'source_url' => 'https://www.flickr.com/photos/35693660@N03/52609958477',
                'creator_name' => 'Don Komarechka',
                'creator_url' => 'https://www.flickr.com/photos/35693660@N03',
                'license_name' => 'CC0 1.0',
                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                'attribution_text' => '"Tough as Diamonds" by Don Komarechka (CC0 1.0), descubierto via Openverse.',
            ],
            'orbita-helada' => [
                'description' => 'La Tierra asoma desde el horizonte lunar con la distancia fría y silenciosa de una órbita detenida.',
                'alt_text' => 'La Tierra vista sobre el horizonte de la Luna en tonos oscuros y azules.',
                'palette' => 'negro espacial, blanco helado, azul terrestre',
                'source_asset_path' => 'database/seeders/assets/orbita-helada.jpg',
                'source_name' => 'Flickr',
                'source_url' => 'https://www.flickr.com/photos/187631144@N02/49742299207',
                'creator_name' => 'razielabulafia',
                'creator_url' => 'https://www.flickr.com/photos/187631144@N02',
                'license_name' => 'CC0 1.0',
                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                'attribution_text' => '"Earth seen beyond the Moon\'s horizon by the Apollo 17 Astronauts in lunar orbit" by razielabulafia (CC0 1.0), descubierto via Openverse.',
            ],
            'vitrales-del-norte' => [
                'description' => 'Fragmentos de vidrio azul vibrando como un vitral boreal suspendido dentro del museo.',
                'alt_text' => 'Detalle de vitral azul con formas abstractas y luz fría.',
                'palette' => 'azul eléctrico, índigo, destellos de vidrio',
                'source_asset_path' => 'database/seeders/assets/vitrales-del-norte.jpg',
                'source_name' => 'Flickr',
                'source_url' => 'https://www.flickr.com/photos/40632439@N00/6039515956',
                'creator_name' => 'Thad Zajdowicz',
                'creator_url' => 'https://www.flickr.com/photos/40632439@N00',
                'license_name' => 'CC0 1.0',
                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                'attribution_text' => '"Chagall Window Detail" by Thad Zajdowicz (CC0 1.0), descubierto via Openverse.',
            ],
            'aurora-cinetica' => [
                'description' => 'Una aurora intensa y móvil, casi eléctrica, recortada sobre el cielo frío y profundo.',
                'alt_text' => 'Aurora boreal verde y violeta sobre un cielo nocturno oscuro.',
                'palette' => 'verde aurora, violeta, azul noche',
                'source_asset_path' => 'database/seeders/assets/aurora-cinetica.jpg',
                'source_name' => 'Flickr',
                'source_url' => 'https://www.flickr.com/photos/24662369@N07/26938621338',
                'creator_name' => 'NASA Goddard Photo and Video',
                'creator_url' => 'https://www.flickr.com/photos/24662369@N07',
                'license_name' => 'CC0 1.0',
                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                'attribution_text' => '"The Aurora Named STEVE" by NASA Goddard Photo and Video (CC0 1.0), descubierto via Openverse.',
            ],
        ];

        foreach ($catalogManifest as $slug => $attributes) {
            DB::table('catalog_images')
                ->where('slug', $slug)
                ->update([
                    ...$attributes,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('catalog_images', function (Blueprint $table) {
            $table->dropColumn([
                'source_name',
                'source_url',
                'creator_name',
                'creator_url',
                'license_name',
                'license_url',
                'attribution_text',
            ]);
        });
    }
};
