<?php

namespace App\Rules;

use App\Models\CatalogImage;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ActiveCatalogSelection implements ValidationRule
{
    public function __construct(
        protected int $requiredCount,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            return;
        }

        $selectedIds = collect($value)
            ->filter(fn (mixed $id) => $id !== null && $id !== '')
            ->map(fn (mixed $id) => (int) $id)
            ->unique()
            ->values();

        if ($selectedIds->count() !== $this->requiredCount) {
            $fail('Debes seleccionar exactamente la cantidad de imágenes permitida por tu ticket.');

            return;
        }

        $activeCount = CatalogImage::query()
            ->whereIn('id', $selectedIds)
            ->where('is_active', true)
            ->count();

        if ($activeCount !== $this->requiredCount) {
            $fail('Solo puedes seleccionar imágenes activas del catálogo del museo.');
        }
    }
}
