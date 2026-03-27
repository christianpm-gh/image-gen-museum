<?php

namespace App\Services;

use App\Models\MemoryGeneration;
use Illuminate\Support\Collection;

class MemoryPromptBuilder
{
    public function build(MemoryGeneration $memoryGeneration, Collection $catalogImages): string
    {
        $references = $catalogImages
            ->map(fn ($image) => sprintf('%s (%s)', $image->title, $image->exhibition->title))
            ->implode(', ');

        $rooms = $catalogImages
            ->map(fn ($image) => $image->exhibition->museumRoom->title)
            ->unique()
            ->implode(', ');

        $curatorNotes = $catalogImages
            ->map(fn ($image) => $image->exhibition->curator_note)
            ->filter()
            ->unique()
            ->implode(' | ');

        return implode("\n", array_filter([
            'Create a single evocative museum souvenir image.',
            'Mood and emotion: '.$memoryGeneration->emotion_text,
            'Reference images selected by the visitor: '.$references,
            'Museum rooms involved: '.$rooms,
            'Curator notes: '.$curatorNotes,
            'Style direction: cinematic, layered, emotionally resonant, premium digital artwork.',
            'Preserve the emotional tone of the visitor and reinterpret the references instead of copying them literally.',
            'Output a polished image suitable as a commemorative museum keepsake.',
        ]));
    }
}
