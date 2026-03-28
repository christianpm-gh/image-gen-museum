<?php

namespace Tests\Feature;

use App\Models\CatalogImage;
use App\Models\Exhibition;
use App\Models\MemoryGeneration;
use App\Models\MuseumRoom;
use App\Models\Ticket;
use App\Models\User;
use App\Services\MemoryPromptBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoryPromptBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_prompt_includes_curatorial_description_palette_and_context(): void
    {
        $room = MuseumRoom::factory()->create([
            'title' => 'Sala Gestos de Apunte',
            'description' => 'Objetos que convierten la mano en intención y navegación.',
        ]);

        $exhibition = Exhibition::factory()->for($room)->create([
            'title' => 'Ratones de Mesa',
            'description' => 'Una exposición sobre trayecto, control fino y cultura material del cursor.',
            'emotional_prompt' => 'curiosidad, control fino, exploración',
            'curator_note' => 'El ratón convierte la mano en cartografía.',
        ]);

        $catalogImage = CatalogImage::factory()->for($exhibition)->create([
            'title' => 'Ratón Xerox Alto',
            'description' => 'Una geometría sobria lista para convertir movimiento en navegación.',
            'alt_text' => 'Ratón Xerox Alto fotografiado en vitrina con fondo claro.',
            'palette' => 'gris perla, negro mate, blanco vitrina',
        ]);

        $memory = MemoryGeneration::factory()
            ->for(User::factory())
            ->for(Ticket::factory())
            ->create([
                'emotion_text' => 'Sentí una mezcla de precisión, calma y curiosidad material.',
                'selected_catalog_image_ids' => [$catalogImage->id],
            ]);

        $prompt = app(MemoryPromptBuilder::class)->build($memory, collect([$catalogImage->load('exhibition.museumRoom')]));

        $this->assertStringContainsString('MusIAum is an abstract museum of human-computer interaction and emotional memory.', $prompt);
        $this->assertStringContainsString('Sala Gestos de Apunte', $prompt);
        $this->assertStringContainsString('Objetos que convierten la mano en intención y navegación.', $prompt);
        $this->assertStringContainsString('Ratones de Mesa', $prompt);
        $this->assertStringContainsString('curiosidad, control fino, exploración', $prompt);
        $this->assertStringContainsString('El ratón convierte la mano en cartografía.', $prompt);
        $this->assertStringContainsString('Ratón Xerox Alto', $prompt);
        $this->assertStringContainsString('Ratón Xerox Alto fotografiado en vitrina con fondo claro.', $prompt);
        $this->assertStringContainsString('gris perla, negro mate, blanco vitrina', $prompt);
        $this->assertStringContainsString('Sentí una mezcla de precisión, calma y curiosidad material.', $prompt);
    }
}
