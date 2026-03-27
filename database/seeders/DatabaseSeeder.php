<?php

namespace Database\Seeders;

use App\Models\CatalogImage;
use App\Models\Exhibition;
use App\Models\MuseumRoom;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'demo@example.com',
        ], [
            'name' => 'MusIAum Demo',
            'password' => User::factory()->make()->password,
        ]);

        CatalogImage::query()->delete();
        Exhibition::query()->delete();
        MuseumRoom::query()->delete();

        $rooms = [
            [
                'title' => 'Sala Operadoras y Consolas',
                'slug' => 'sala-operadoras-y-consolas',
                'hero_eyebrow' => 'Historia de la interacción',
                'summary' => 'Cuerpos, tableros y terminales donde la computación todavía se trabajaba con la postura, la espera y la atención sostenida.',
                'description' => 'Esta sala reúne escenas en las que la interacción humano-computadora aún dependía de manos expertas, paneles físicos y lectura intensa. Aquí la interfaz no es una capa invisible: es un lugar de trabajo, coordinación y presencia.',
                'accent_color' => '#60a5fa',
                'sort_order' => 1,
                'exhibitions' => [
                    [
                        'title' => 'Cuerpos del Cálculo',
                        'slug' => 'cuerpos-del-calculo',
                        'summary' => 'Trabajo humano, cableado manual y precisión repetida antes de la interfaz amable.',
                        'description' => 'Una exposición sobre las personas que sostuvieron el cálculo con sus manos, su memoria y su capacidad de operar sistemas inmensos antes del paradigma contemporáneo de la pantalla personal.',
                        'emotional_prompt' => 'concentración, disciplina, memoria laboral, precisión manual',
                        'curator_note' => 'Aquí la interacción ocurre a la altura del cuerpo entero: mirar, cablear, perforar, repetir.',
                        'sort_order' => 1,
                        'images' => [
                            [
                                'title' => 'Tarjetas del Censo',
                                'slug' => 'tarjetas-del-censo',
                                'palette' => 'beige, grafito, marfil industrial',
                                'source_asset_path' => 'database/seeders/assets/tarjetas-del-censo.jpg',
                                'sort_order' => 1,
                                'description' => 'Una operadora perfora tarjetas para traducir población y territorio a una secuencia repetible de gestos mecánicos.',
                                'alt_text' => 'Operadora del censo usando una máquina perforadora IBM en una oficina histórica.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:Keypunch_operator_1950_census_IBM_016.jpg',
                                'creator_name' => 'U.S. Census Bureau employees',
                                'creator_url' => 'https://www.census.gov/history/',
                                'license_name' => 'Public Domain (US Census Bureau)',
                                'license_url' => 'https://commons.wikimedia.org/wiki/File:Keypunch_operator_1950_census_IBM_016.jpg',
                                'attribution_text' => '"Keypunch operator 1950 census IBM 016" por U.S. Census Bureau employees, vía Wikimedia Commons, dominio público.',
                            ],
                            [
                                'title' => 'Reprogramando ENIAC',
                                'slug' => 'reprogramando-eniac',
                                'palette' => 'gris acero, negro carbón, crema documental',
                                'source_asset_path' => 'database/seeders/assets/reprogramando-eniac.png',
                                'sort_order' => 2,
                                'description' => 'Dos programadoras rehacen la lógica del sistema directamente sobre el cuerpo cableado de ENIAC.',
                                'alt_text' => 'Dos mujeres cableando un panel del computador ENIAC en una fotografía histórica.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:Reprogramming_ENIAC.png',
                                'creator_name' => 'Unidentified U.S. Army photographer',
                                'creator_url' => 'https://commons.wikimedia.org/wiki/File:Reprogramming_ENIAC.png',
                                'license_name' => 'Public Domain Mark 1.0 / PD-USGov',
                                'license_url' => 'https://commons.wikimedia.org/wiki/File:Reprogramming_ENIAC.png',
                                'attribution_text' => '"Reprogramming ENIAC" por un fotógrafo no identificado del ejército de EE. UU., vía Wikimedia Commons, dominio público.',
                            ],
                            [
                                'title' => 'Operadoras ENIAC',
                                'slug' => 'operadoras-eniac',
                                'palette' => 'marfil histórico, negro técnico, gris archivo',
                                'source_asset_path' => 'database/seeders/assets/operadoras-eniac.jpg',
                                'sort_order' => 3,
                                'description' => 'Betty Jennings y Frances Bilas preparan ENIAC para una demostración, dejando ver la interfaz como una coreografía de perillas, paneles y memoria humana.',
                                'alt_text' => 'Dos operadoras trabajan frente al panel principal de ENIAC en una fotografía histórica de alta resolución.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:Two_women_operating_ENIAC_(full_resolution).jpg',
                                'creator_name' => 'United States Army',
                                'creator_url' => 'https://commons.wikimedia.org/wiki/File:Two_women_operating_ENIAC_(full_resolution).jpg',
                                'license_name' => 'Public Domain (US federal government)',
                                'license_url' => 'https://commons.wikimedia.org/wiki/File:Two_women_operating_ENIAC_(full_resolution).jpg',
                                'attribution_text' => '"Two women operating ENIAC (full resolution)" por United States Army, vía Wikimedia Commons, dominio público.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Terminales de Observación',
                        'slug' => 'terminales-de-observacion',
                        'summary' => 'Pantallas densas, lectura sostenida y puestos de control donde mirar ya es una forma de operar.',
                        'description' => 'Esta exposición reúne terminales y estaciones de trabajo en las que la interacción sucede a través de la vigilancia, la interpretación de datos y la atención a flujos de información especializados.',
                        'emotional_prompt' => 'alerta serena, comando, lectura técnica, vigilancia',
                        'curator_note' => 'La terminal aparece como un puesto de escucha: un lugar para sostener la atención más que para consumir una interfaz.',
                        'sort_order' => 2,
                        'images' => [
                            [
                                'title' => 'Terminal de Misión',
                                'slug' => 'terminal-de-mision',
                                'palette' => 'ámbar, gris instrumental, blanco técnico',
                                'source_asset_path' => 'database/seeders/assets/terminal-de-mision.jpg',
                                'sort_order' => 1,
                                'description' => 'Una estación de terminal con pantalla encendida y documentación física, pensada para sostener decisiones críticas en tiempo real.',
                                'alt_text' => 'Terminal de computadora antigua con teclado y documentación alrededor en un centro técnico.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:COMPUTER_TERMINAL_-_NARA_-_17500667.jpg',
                                'creator_name' => 'National Aeronautics and Space Administration',
                                'creator_url' => 'https://catalog.archives.gov/id/17500667',
                                'license_name' => 'Public Domain (NASA)',
                                'license_url' => 'https://commons.wikimedia.org/wiki/File:COMPUTER_TERMINAL_-_NARA_-_17500667.jpg',
                                'attribution_text' => '"COMPUTER TERMINAL - NARA - 17500667" por NASA, vía Wikimedia Commons, dominio público.',
                            ],
                            [
                                'title' => 'Consola de Laboratorio',
                                'slug' => 'consola-de-laboratorio',
                                'palette' => 'oliva desaturado, beige oficina, negro fósforo',
                                'source_asset_path' => 'database/seeders/assets/consola-de-laboratorio.jpg',
                                'sort_order' => 2,
                                'description' => 'Una terminal de los años setenta donde el laboratorio aparece como un espacio de interpretación lenta y procedimiento disciplinado.',
                                'alt_text' => 'Terminal antigua instalada en un laboratorio con mobiliario y equipo científico histórico.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:Early_NCTR_Computer_System_Terminal-_1973_(7421971396).jpg',
                                'creator_name' => 'The U.S. Food and Drug Administration',
                                'creator_url' => 'https://www.flickr.com/photos/fdaphotos/7421971396',
                                'license_name' => 'Public Domain (US FDA)',
                                'license_url' => 'https://commons.wikimedia.org/wiki/File:Early_NCTR_Computer_System_Terminal-_1973_(7421971396).jpg',
                                'attribution_text' => '"Early NCTR Computer System Terminal- 1973" por The U.S. Food and Drug Administration, vía Wikimedia Commons, dominio público.',
                            ],
                            [
                                'title' => 'Televideo 925',
                                'slug' => 'televideo-925',
                                'palette' => 'gris CRT, negro fósforo, beige gabinete',
                                'source_asset_path' => 'database/seeders/assets/televideo-925.jpg',
                                'sort_order' => 3,
                                'description' => 'Un terminal de texto autónomo en autoprueba muestra la densidad silenciosa de una interfaz pensada para leer, esperar y ejecutar con precisión.',
                                'alt_text' => 'Terminal TeleVideo 925 fotografiado de frente con la pantalla mostrando su autoprueba.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:Televideo925Terminal.jpg',
                                'creator_name' => 'Wtshymanski',
                                'creator_url' => 'https://en.wikipedia.org/wiki/User:Wtshymanski',
                                'license_name' => 'Public Domain',
                                'license_url' => 'https://commons.wikimedia.org/wiki/File:Televideo925Terminal.jpg',
                                'attribution_text' => '"Televideo925Terminal" por Wtshymanski, vía Wikimedia Commons, dominio público.',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Sala Gestos de Apunte',
                'slug' => 'sala-gestos-de-apunte',
                'hero_eyebrow' => 'Dispositivos de entrada',
                'summary' => 'Del lápiz de luz al ratón: la interfaz se volvió un gesto de selección, alcance y desplazamiento.',
                'description' => 'Aquí la historia cambia de escala. La interacción ya no depende solo del puesto de operación, sino de pequeños objetos que traducen la mano en intención: señalar, tocar, desplazar, escoger.',
                'accent_color' => '#22d3ee',
                'sort_order' => 2,
                'exhibitions' => [
                    [
                        'title' => 'Luz que Señala',
                        'slug' => 'luz-que-senala',
                        'summary' => 'Antes del tacto multitáctil, la pantalla ya podía ser alcanzada con instrumentos de precisión.',
                        'description' => 'Una exposición dedicada a los dispositivos que convirtieron la acción de señalar en una forma directa de interacción. El gesto no navega un escritorio: incide sobre la propia superficie de visualización.',
                        'emotional_prompt' => 'precisión, contacto, señalamiento, intuición técnica',
                        'curator_note' => 'La pantalla deja de ser solo lectura cuando el gesto puede tocarla y decidir sobre ella.',
                        'sort_order' => 1,
                        'images' => [
                            [
                                'title' => 'Selector Pen',
                                'slug' => 'selector-pen',
                                'palette' => 'gris fósforo, beige de oficina, azul tenue',
                                'source_asset_path' => 'database/seeders/assets/selector-pen.jpg',
                                'sort_order' => 1,
                                'description' => 'Una operadora sostiene el selector pen frente al monitor, como si la pantalla pudiera ser tocada por una línea de decisión.',
                                'alt_text' => 'Operadora utilizando un IBM 3270 con selector pen frente a la pantalla.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:IBM_3270_terminal_with_Selector_Pen.jpg',
                                'creator_name' => 'International Business Machines',
                                'creator_url' => 'https://archive.org/details/IBMAtGaithersburgCirca1980',
                                'license_name' => 'Public Domain (US no notice)',
                                'license_url' => 'https://commons.wikimedia.org/wiki/File:IBM_3270_terminal_with_Selector_Pen.jpg',
                                'attribution_text' => '"IBM 3270 terminal with Selector Pen" por International Business Machines, vía Wikimedia Commons, dominio público en EE. UU.',
                            ],
                            [
                                'title' => 'Lápiz PDP-1',
                                'slug' => 'lapiz-pdp-1',
                                'palette' => 'gris metálico, negro carbón, vidrio frío',
                                'source_asset_path' => 'database/seeders/assets/lapiz-pdp-1.jpg',
                                'sort_order' => 2,
                                'description' => 'El lápiz de luz aparece como una herramienta precisa y casi escultórica, suspendida entre instrumento y extensión del cuerpo.',
                                'alt_text' => 'Lápiz de luz PDP-1 fotografiado sobre fondo oscuro en el Computer History Museum.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:PDP-1_light_pen.agr.jpg',
                                'creator_name' => 'ArnoldReinhold',
                                'creator_url' => 'https://commons.wikimedia.org/wiki/User:ArnoldReinhold',
                                'license_name' => 'CC BY 4.0',
                                'license_url' => 'https://creativecommons.org/licenses/by/4.0/',
                                'attribution_text' => '"PDP-1 light pen.agr" por ArnoldReinhold (CC BY 4.0), vía Wikimedia Commons.',
                            ],
                            [
                                'title' => 'IBM 2250 HES',
                                'slug' => 'ibm-2250-hes',
                                'palette' => 'gris ceniza, blanco laboratorio, negro interfaz',
                                'source_asset_path' => 'database/seeders/assets/ibm-2250-hes.png',
                                'sort_order' => 3,
                                'description' => 'La pantalla del IBM 2250 y su light pen aparecen como un sistema de escritura directa, donde editar y señalar suceden sobre la misma superficie luminosa.',
                                'alt_text' => 'IBM 2250 mostrando texto del Hypertext Editing System junto a un light pen.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:HES_IBM_2250_light_pen_grlloyd_Oct1969.png',
                                'creator_name' => 'Gregory Lloyd',
                                'creator_url' => 'https://commons.wikimedia.org/wiki/User:Grlloyd',
                                'license_name' => 'CC BY-SA 4.0',
                                'license_url' => 'https://creativecommons.org/licenses/by-sa/4.0/',
                                'attribution_text' => '"HES IBM 2250 light pen grlloyd Oct1969" por Gregory Lloyd (CC BY-SA 4.0), vía Wikimedia Commons.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Ratones de Mesa',
                        'slug' => 'ratones-de-mesa',
                        'summary' => 'Pequeños objetos que transformaron el desplazamiento de la mano en navegación simbólica.',
                        'description' => 'Esta exposición aborda al ratón como artefacto cultural: una pieza mínima que volvió cotidiana la relación entre movimiento físico, selección y trayecto dentro del espacio digital.',
                        'emotional_prompt' => 'curiosidad, control fino, exploración, orientación',
                        'curator_note' => 'El ratón no solo mueve un cursor: convierte la mano en cartografía.',
                        'sort_order' => 2,
                        'images' => [
                            [
                                'title' => 'Ratón Mecánico',
                                'slug' => 'raton-mecanico',
                                'palette' => 'marfil técnico, negro rueda, gris plástico',
                                'source_asset_path' => 'database/seeders/assets/raton-mecanico.jpg',
                                'sort_order' => 1,
                                'description' => 'Un ratón abierto muestra su interior mecánico y deja ver la materialidad del gesto cotidiano.',
                                'alt_text' => 'Ratón mecánico desarmado sobre fondo neutro mostrando su mecanismo interno.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:Computer_mouse-2005.jpg',
                                'creator_name' => 'László Szalai (Beyond silence)',
                                'creator_url' => 'https://commons.wikimedia.org/wiki/User:Beyond_silence',
                                'license_name' => 'Public Domain',
                                'license_url' => 'https://commons.wikimedia.org/wiki/File:Computer_mouse-2005.jpg',
                                'attribution_text' => '"Computer mouse-2005" por László Szalai (Beyond silence), vía Wikimedia Commons, dominio público.',
                            ],
                            [
                                'title' => 'Prototipo Engelbart',
                                'slug' => 'prototipo-engelbart',
                                'palette' => 'madera clara, negro museo, gris vitrinas',
                                'source_asset_path' => 'database/seeders/assets/prototipo-engelbart.jpg',
                                'sort_order' => 2,
                                'description' => 'Una vista del primer prototipo célebre del ratón, todavía cercano a una herramienta de taller más que a un periférico doméstico.',
                                'alt_text' => 'Prototipo del ratón de Engelbart fotografiado en el Computer History Museum.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:Douglas_Engelbart%27s_prototype_mouse,_angled_-_Computer_History_Museum.jpg',
                                'creator_name' => 'Michael Hicks',
                                'creator_url' => 'https://www.flickr.com/photos/mulad/11401229143/',
                                'license_name' => 'CC BY 2.0',
                                'license_url' => 'https://creativecommons.org/licenses/by/2.0/',
                                'attribution_text' => '"Douglas Engelbart\'s prototype mouse, angled - Computer History Museum" por Michael Hicks (CC BY 2.0), vía Wikimedia Commons.',
                            ],
                            [
                                'title' => 'Ratón Xerox Alto',
                                'slug' => 'raton-xerox-alto',
                                'palette' => 'gris perla, negro mate, blanco vitrina',
                                'source_asset_path' => 'database/seeders/assets/xerox-alto-mouse.jpg',
                                'sort_order' => 3,
                                'description' => 'El ratón del Xerox Alto muestra la transición entre prototipo y herramienta cotidiana: una geometría sobria lista para convertir movimiento en navegación.',
                                'alt_text' => 'Ratón Xerox Alto fotografiado en vitrina con fondo claro.',
                                'source_name' => 'Wikimedia Commons',
                                'source_url' => 'https://commons.wikimedia.org/wiki/File:Xerox_Alto_mouse.jpg',
                                'creator_name' => 'Marcin Wichary',
                                'creator_url' => 'https://www.flickr.com/photos/mwichary/',
                                'license_name' => 'CC BY 2.0',
                                'license_url' => 'https://creativecommons.org/licenses/by/2.0/',
                                'attribution_text' => '"Xerox Alto mouse" por Marcin Wichary (CC BY 2.0), vía Wikimedia Commons.',
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
