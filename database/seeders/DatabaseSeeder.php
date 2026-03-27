<?php

namespace Database\Seeders;

use App\Models\CatalogImage;
use App\Models\MuseumRoom;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Museo Demo',
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
                            ['title' => 'Arco Sumergido', 'slug' => 'arco-sumergido', 'palette' => 'azules, plata', 'source_asset_path' => 'database/seeders/assets/arco-sumergido.svg', 'sort_order' => 1],
                            ['title' => 'Catedral de Niebla', 'slug' => 'catedral-de-niebla', 'palette' => 'gris azulado, blanco', 'source_asset_path' => 'database/seeders/assets/catedral-de-niebla.svg', 'sort_order' => 2],
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
                            ['title' => 'Mineral Nocturno', 'slug' => 'mineral-nocturno', 'palette' => 'gris grafito, azul', 'source_asset_path' => 'database/seeders/assets/mineral-nocturno.svg', 'sort_order' => 1],
                            ['title' => 'Órbita Helada', 'slug' => 'orbita-helada', 'palette' => 'blanco, acero', 'source_asset_path' => 'database/seeders/assets/orbita-helada.svg', 'sort_order' => 2],
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
                            ['title' => 'Vitrales del Norte', 'slug' => 'vitrales-del-norte', 'palette' => 'azul eléctrico, blanco', 'source_asset_path' => 'database/seeders/assets/vitrales-del-norte.svg', 'sort_order' => 1],
                            ['title' => 'Aurora Cinética', 'slug' => 'aurora-cinetica', 'palette' => 'cian, plata', 'source_asset_path' => 'database/seeders/assets/aurora-cinetica.svg', 'sort_order' => 2],
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
                        'alt_text' => $imageData['title'].' - referencia curada del museo',
                        'description' => 'Imagen base curada para combinaciones con IA.',
                    ]);
                }
            }
        }
    }
}
