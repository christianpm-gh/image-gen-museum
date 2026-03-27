<?php

namespace Database\Seeders;

use App\Models\CatalogImage;
use App\Models\MuseumRoom;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'MusIAum Demo',
            'email' => 'demo@example.com',
        ]);

        $rooms = [
            [
                'title' => 'Sala Abisal',
                'slug' => 'sala-abisal',
                'hero_eyebrow' => 'Recorrido inmersivo',
                'summary' => 'Luz fría, ecos minerales y recuerdos que flotan como si estuvieran bajo agua.',
                'description' => 'Una sala dedicada a emociones densas, contemplativas y oceánicas. Aquí el visitante navega entre piezas conceptuales que mezclan neón, niebla y arquitectura sumergida.',
                'accent_color' => '#38bdf8',
                'sort_order' => 1,
                'exhibitions' => [
                    [
                        'title' => 'Mareas de Cobalto',
                        'slug' => 'mareas-de-cobalto',
                        'summary' => 'Texturas líquidas y memoria azul en expansión.',
                        'description' => 'Una exposición sobre la forma en que la memoria transforma superficies sólidas en paisajes líquidos.',
                        'emotional_prompt' => 'melancolía luminosa, contemplación, profundidad oceánica',
                        'curator_note' => 'Deja que la nostalgia se convierta en arquitectura líquida.',
                        'sort_order' => 1,
                        'images' => [
                            [
                                'title' => 'Arco Sumergido',
                                'slug' => 'arco-sumergido',
                                'palette' => 'azules, espuma, piedra',
                                'source_asset_path' => 'database/seeders/assets/arco-sumergido.jpg',
                                'sort_order' => 1,
                                'description' => 'Oleaje azul atravesando un arco rocoso, como una puerta abierta hacia una memoria oceánica.',
                                'alt_text' => 'Arco rocoso frente al mar con espuma azul y cielo despejado.',
                                'source_name' => 'Flickr',
                                'source_url' => 'https://www.flickr.com/photos/71401718@N00/4074801347',
                                'creator_name' => 'Wonderlane',
                                'creator_url' => 'https://www.flickr.com/photos/71401718@N00',
                                'license_name' => 'CC0 1.0',
                                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                                'attribution_text' => '"Water under the bridge, little rock arch, splash of the Pacific Ocean, South Mazatlan, Sinaloa, Mexico" by Wonderlane (CC0 1.0), descubierto via Openverse.',
                            ],
                            [
                                'title' => 'Catedral de Niebla',
                                'slug' => 'catedral-de-niebla',
                                'palette' => 'gris perla, azul tenue, blanco',
                                'source_asset_path' => 'database/seeders/assets/catedral-de-niebla.jpg',
                                'sort_order' => 2,
                                'description' => 'Una silueta gótica envuelta por neblina suave que transforma la piedra en recuerdo y atmósfera.',
                                'alt_text' => 'Catedral entre neblina blanca con tonos fríos y cielo nublado.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/w/index.php?curid=178875322',
                                'creator_name' => 'Digihum',
                                'creator_url' => 'https://commons.wikimedia.org/wiki/User:Digihum',
                                'license_name' => 'CC0 1.0',
                                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/deed.en/',
                                'attribution_text' => '"Canterbury Cathedral in the Mist" by Digihum (CC0 1.0), descubierto via Openverse.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Sedimentos de Luna',
                        'slug' => 'sedimentos-de-luna',
                        'summary' => 'Rocas brillantes y silencio orbital.',
                        'description' => 'Capas de mineral imaginario y gestos lunares que sugieren una arqueología emocional.',
                        'emotional_prompt' => 'asombro sereno, misterio, quietud cósmica',
                        'curator_note' => 'Piensa la tristeza como polvo estelar que aún refleja luz.',
                        'sort_order' => 2,
                        'images' => [
                            [
                                'title' => 'Mineral Nocturno',
                                'slug' => 'mineral-nocturno',
                                'palette' => 'violeta profundo, grafito, reflejos fríos',
                                'source_asset_path' => 'database/seeders/assets/mineral-nocturno.jpg',
                                'sort_order' => 1,
                                'description' => 'Un macro de cristales brillando en la oscuridad, como si la materia recordara la luz ultravioleta.',
                                'alt_text' => 'Cristales iluminados en tonos oscuros con destellos violetas.',
                                'source_name' => 'Flickr',
                                'source_url' => 'https://www.flickr.com/photos/35693660@N03/52609958477',
                                'creator_name' => 'Don Komarechka',
                                'creator_url' => 'https://www.flickr.com/photos/35693660@N03',
                                'license_name' => 'CC0 1.0',
                                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                                'attribution_text' => '"Tough as Diamonds" by Don Komarechka (CC0 1.0), descubierto via Openverse.',
                            ],
                            [
                                'title' => 'Órbita Helada',
                                'slug' => 'orbita-helada',
                                'palette' => 'negro espacial, blanco helado, azul terrestre',
                                'source_asset_path' => 'database/seeders/assets/orbita-helada.jpg',
                                'sort_order' => 2,
                                'description' => 'La Tierra asoma desde el horizonte lunar con la distancia fría y silenciosa de una órbita detenida.',
                                'alt_text' => 'La Tierra vista sobre el horizonte de la Luna en tonos oscuros y azules.',
                                'source_name' => 'Flickr',
                                'source_url' => 'https://www.flickr.com/photos/187631144@N02/49742299207',
                                'creator_name' => 'razielabulafia',
                                'creator_url' => 'https://www.flickr.com/photos/187631144@N02',
                                'license_name' => 'CC0 1.0',
                                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                                'attribution_text' => '"Earth seen beyond the Moon\'s horizon by the Apollo 17 Astronauts in lunar orbit" by razielabulafia (CC0 1.0), descubierto via Openverse.',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Sala Boreal',
                'slug' => 'sala-boreal',
                'hero_eyebrow' => 'Galería atmosférica',
                'summary' => 'Auroras, vidrio y geometrías frías que se sienten vivas.',
                'description' => 'La sala boreal explora emociones más expansivas, esperanzadoras y cinéticas mediante composiciones de cielo, metal y luz polar.',
                'accent_color' => '#93c5fd',
                'sort_order' => 2,
                'exhibitions' => [
                    [
                        'title' => 'Aurora Mecánica',
                        'slug' => 'aurora-mecanica',
                        'summary' => 'Energía eléctrica convertida en paisaje emocional.',
                        'description' => 'Una colección conceptual donde la aurora se mezcla con piezas industriales y vitrales contemporáneos.',
                        'emotional_prompt' => 'esperanza, vértigo amable, luz fría en movimiento',
                        'curator_note' => 'Usa la energía de la pieza para volver tangible lo que sentiste.',
                        'sort_order' => 1,
                        'images' => [
                            [
                                'title' => 'Vitrales del Norte',
                                'slug' => 'vitrales-del-norte',
                                'palette' => 'azul eléctrico, índigo, destellos de vidrio',
                                'source_asset_path' => 'database/seeders/assets/vitrales-del-norte.jpg',
                                'sort_order' => 1,
                                'description' => 'Fragmentos de vidrio azul vibrando como un vitral boreal suspendido dentro del museo.',
                                'alt_text' => 'Detalle de vitral azul con formas abstractas y luz fría.',
                                'source_name' => 'Flickr',
                                'source_url' => 'https://www.flickr.com/photos/40632439@N00/6039515956',
                                'creator_name' => 'Thad Zajdowicz',
                                'creator_url' => 'https://www.flickr.com/photos/40632439@N00',
                                'license_name' => 'CC0 1.0',
                                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                                'attribution_text' => '"Chagall Window Detail" by Thad Zajdowicz (CC0 1.0), descubierto via Openverse.',
                            ],
                            [
                                'title' => 'Aurora Cinética',
                                'slug' => 'aurora-cinetica',
                                'palette' => 'verde aurora, violeta, azul noche',
                                'source_asset_path' => 'database/seeders/assets/aurora-cinetica.jpg',
                                'sort_order' => 2,
                                'description' => 'Una aurora intensa y móvil, casi eléctrica, recortada sobre el cielo frío y profundo.',
                                'alt_text' => 'Aurora boreal verde y violeta sobre un cielo nocturno oscuro.',
                                'source_name' => 'Flickr',
                                'source_url' => 'https://www.flickr.com/photos/24662369@N07/26938621338',
                                'creator_name' => 'NASA Goddard Photo and Video',
                                'creator_url' => 'https://www.flickr.com/photos/24662369@N07',
                                'license_name' => 'CC0 1.0',
                                'license_url' => 'https://creativecommons.org/publicdomain/zero/1.0/',
                                'attribution_text' => '"The Aurora Named STEVE" by NASA Goddard Photo and Video (CC0 1.0), descubierto via Openverse.',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($rooms as $roomData) {
            $exhibitions = $roomData['exhibitions'];
            unset($roomData['exhibitions']);

            $room = MuseumRoom::create($roomData);

            foreach ($exhibitions as $exhibitionData) {
                $images = $exhibitionData['images'];
                unset($exhibitionData['images']);

                $exhibition = $room->exhibitions()->create($exhibitionData);

                foreach ($images as $imageData) {
                    CatalogImage::create([
                        ...$imageData,
                        'exhibition_id' => $exhibition->id,
                        'alt_text' => $imageData['alt_text'] ?? $imageData['title'].' - referencia curada del museo',
                        'description' => $imageData['description'] ?? 'Imagen base curada para combinaciones con IA.',
                    ]);
                }
            }
        }
    }
}
