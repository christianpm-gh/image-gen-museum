<?php

namespace App\Http\Requests;

use App\Rules\ActiveCatalogSelection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMemoryGenerationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        /** @var \App\Models\Ticket|null $ticket */
        $ticket = $this->route('ticket');
        $requiredCount = $ticket?->requiredCatalogImages() ?? 1;

        return [
            'token' => ['required', 'string', 'max:64'],
            'emotion_text' => ['required', 'string', 'min:10', 'max:280'],
        'catalog_image_ids' => ['required', 'array', 'size:'.$requiredCount, new ActiveCatalogSelection($requiredCount)],
            'catalog_image_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('catalog_images', 'id')->where(fn ($query) => $query->where('is_active', true)),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'catalog_image_ids.size' => 'Debes seleccionar exactamente la cantidad de imágenes permitida por tu ticket.',
            'catalog_image_ids.*.exists' => 'Solo puedes seleccionar imágenes activas del catálogo del museo.',
        ];
    }
}
