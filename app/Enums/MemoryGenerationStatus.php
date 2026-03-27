<?php

namespace App\Enums;

enum MemoryGenerationStatus: string
{
    case Queued = 'queued';
    case Processing = 'processing';
    case Completed = 'completed';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Queued => 'En cola',
            self::Processing => 'Procesando',
            self::Completed => 'Completado',
            self::Failed => 'Fallido',
        };
    }
}
