<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Issued = 'issued';
    case Reserved = 'reserved';
    case Consumed = 'consumed';

    public function label(): string
    {
        return match ($this) {
            self::Issued => 'Emitido',
            self::Reserved => 'Reservado',
            self::Consumed => 'Consumido',
        };
    }
}
