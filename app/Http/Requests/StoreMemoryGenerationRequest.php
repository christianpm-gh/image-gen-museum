<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'emotion_text' => ['required', 'string', 'min:10', 'max:400'],
            'catalog_image_ids' => ['required', 'array', 'size:'.$requiredCount],
            'catalog_image_ids.*' => ['required', 'integer', 'distinct', 'exists:catalog_images,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'catalog_image_ids.size' => 'Debes seleccionar exactamente la cantidad de imágenes permitida por tu ticket.',
        ];
    }
}
