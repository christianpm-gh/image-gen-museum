<?php

namespace App\Services;

use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\RequestException;

class OpenAiImageGenerator
{
    public function __construct(
        protected HttpFactory $http,
    ) {
    }

    /**
     * @param  list<array{contents:string, filename:string}>  $referenceImages
     * @return array{binary:string, mime:string, model:string, revised_prompt:?string}
     */
    public function generate(array $referenceImages, string $prompt): array
    {
        $models = array_values(array_filter([
            config('services.openai.image_model'),
            config('services.openai.image_fallback_model'),
        ]));

        $lastException = null;

        foreach ($models as $model) {
            try {
                return $this->sendEditRequest($model, $referenceImages, $prompt);
            } catch (\Throwable $exception) {
                $lastException = $exception;
            }
        }

        throw $lastException ?? new \RuntimeException('No fue posible generar la imagen con OpenAI.');
    }

    /**
     * @param  list<array{contents:string, filename:string}>  $referenceImages
     * @return array{binary:string, mime:string, model:string, revised_prompt:?string}
     */
    protected function sendEditRequest(string $model, array $referenceImages, string $prompt): array
    {
        $multipart = [
            ['name' => 'model', 'contents' => $model],
            ['name' => 'prompt', 'contents' => $prompt],
            ['name' => 'size', 'contents' => (string) config('services.openai.image_size', '1536x1024')],
            ['name' => 'quality', 'contents' => (string) config('services.openai.image_quality', 'high')],
            ['name' => 'response_format', 'contents' => 'b64_json'],
            ['name' => 'output_format', 'contents' => 'png'],
        ];

        foreach ($referenceImages as $index => $referenceImage) {
            $multipart[] = [
                'name' => 'image[]',
                'contents' => $referenceImage['contents'],
                'filename' => $referenceImage['filename'] ?: 'reference-'.$index.'.png',
            ];
        }

        $response = $this->http
            ->baseUrl(rtrim(config('services.openai.base_url', 'https://api.openai.com/v1'), '/'))
            ->withToken(config('services.openai.api_key'))
            ->timeout((int) config('services.openai.timeout', 120))
            ->acceptJson()
            ->send('POST', '/images/edits', [
                'multipart' => $multipart,
            ]);

        $response->throw();

        $payload = $response->json();
        $image = $payload['data'][0]['b64_json'] ?? null;

        if (! is_string($image) || $image === '') {
            throw new RequestException($response);
        }

        return [
            'binary' => base64_decode($image, true) ?: '',
            'mime' => 'image/png',
            'model' => $model,
            'revised_prompt' => $payload['data'][0]['revised_prompt'] ?? null,
        ];
    }
}
