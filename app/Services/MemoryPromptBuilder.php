<?php

namespace App\Services;

use App\Models\MemoryGeneration;
use Illuminate\Support\Collection;

class MemoryPromptBuilder
{
    public function build(MemoryGeneration $memoryGeneration, Collection $catalogImages): string
    {
        $roomContext = $catalogImages
            ->map(fn ($image) => sprintf(
                '%s: %s',
                $image->exhibition->museumRoom->title,
                $image->exhibition->museumRoom->description
            ))
            ->unique()
            ->implode(' | ');

        $exhibitionContext = $catalogImages
            ->map(fn ($image) => implode(' ', array_filter([
                sprintf('%s:', $image->exhibition->title),
                $image->exhibition->description,
                $image->exhibition->emotional_prompt ? 'Clave emocional: '.$image->exhibition->emotional_prompt.'.' : null,
                $image->exhibition->curator_note ? 'Nota curatorial: '.$image->exhibition->curator_note.'.' : null,
            ])))
            ->unique()
            ->implode(' | ');

        $selectedWorks = $catalogImages
            ->values()
            ->map(function ($image, $index) {
                return sprintf(
                    'Obra %d: %s. Exposicion: %s. Descripcion: %s. Texto alterno: %s. Paleta sugerida: %s.',
                    $index + 1,
                    $image->title,
                    $image->exhibition->title,
                    $image->description,
                    $image->alt_text,
                    $image->palette ?: 'sin paleta curada'
                );
            })
            ->implode(' ');

        return implode("\n", array_filter([
            'Create a single original commemorative museum image based only on textual curatorial references.',
            'Museum context: MusIAum is an abstract museum of human-computer interaction and emotional memory.',
            'Visitor emotion: '.$memoryGeneration->emotion_text,
            'Rooms involved: '.$roomContext,
            'Exhibitions involved: '.$exhibitionContext,
            'Selected works: '.$selectedWorks,
            'Style direction: cinematic, layered, emotionally resonant, premium digital artwork with coherent lighting and atmosphere.',
            'Do not recreate, trace, or imitate a documentary photograph. Reinterpret the selected works as an original image guided by their visual traits, material mood, and emotional tone.',
            'Keep the final image polished, singular, and suitable as a commemorative museum keepsake.',
        ]));
    }
}
