<?php

namespace App\Enums;

enum TicketType: string
{
    case Standard = 'standard';
    case Premium = 'premium';

    public function label(): string
    {
        return match ($this) {
            self::Standard => 'Entrada Standard',
            self::Premium => 'Entrada Premium',
        };
    }

    public function requiredCatalogImages(): int
    {
        return match ($this) {
            self::Standard => 1,
            self::Premium => 2,
        };
    }

    public function amount(): int
    {
        return match ($this) {
            self::Standard => (int) config('museum.pricing.standard', 199),
            self::Premium => (int) config('museum.pricing.premium', 349),
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Standard => 'Un recuerdo visual y una imagen curada como referencia.',
            self::Premium => 'Un recuerdo visual y dos imágenes curadas para una composición más rica.',
        };
    }
}
