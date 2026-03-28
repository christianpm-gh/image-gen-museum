<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\RequestException;
use Throwable;

class OpenAiImageGenerator
{
    protected ?string $lastAttemptedModel = null;

    public function __construct(
        protected HttpFactory $http,
    ) {
    }

    /**
     * @return array{binary:string, mime:string, model:string, revised_prompt:?string}
     */
    public function generate(string $prompt): array
    {
        $models = array_values(array_filter([
            config('services.openai.image_model'),
            config('services.openai.image_fallback_model'),
        ]));

        $lastException = null;

        foreach ($models as $model) {
            $this->lastAttemptedModel = $model;

            try {
                return $this->sendGenerationRequest($model, $prompt);
            } catch (Throwable $exception) {
                $lastException = $exception;
            }
        }

        if ($lastException instanceof Throwable) {
            throw new \RuntimeException($this->summarizeFailure($lastException), 0, $lastException);
        }

        throw new \RuntimeException('No fue posible generar la imagen con OpenAI.');
    }

    public function lastAttemptedModel(): ?string
    {
        return $this->lastAttemptedModel;
    }

    /**
     * @return array{binary:string, mime:string, model:string, revised_prompt:?string}
     */
    protected function sendGenerationRequest(string $model, string $prompt): array
    {
        $request = $this->http
            ->baseUrl(rtrim(config('services.openai.base_url', 'https://api.openai.com/v1'), '/'))
            ->withToken(config('services.openai.api_key'))
            ->timeout((int) config('services.openai.timeout', 120))
            ->acceptJson()
            ->asJson();

        $caBundle = config('services.openai.ca_bundle');

        if (is_string($caBundle) && $caBundle !== '') {
            $request = $request->withOptions([
                'verify' => $caBundle,
            ]);
        }

        $response = $request
            ->post('/images/generations', [
                'model' => $model,
                'prompt' => $prompt,
                'size' => (string) config('services.openai.image_size', '1536x1024'),
                'quality' => (string) config('services.openai.image_quality', 'high'),
                'response_format' => 'b64_json',
                'output_format' => 'png',
            ]);

        $response->throw();

        $payload = $response->json();
        $image = $payload['data'][0]['b64_json'] ?? null;

        if (! is_string($image) || $image === '') {
            throw new \RuntimeException('OpenAI no devolvió una imagen utilizable en la respuesta.');
        }

        return [
            'binary' => base64_decode($image, true) ?: '',
            'mime' => 'image/png',
            'model' => $model,
            'revised_prompt' => $payload['data'][0]['revised_prompt'] ?? null,
        ];
    }

    protected function summarizeFailure(Throwable $exception): string
    {
        $modelNote = $this->lastAttemptedModel ? ' Modelo: '.$this->lastAttemptedModel.'.' : '';

        if ($exception instanceof RequestException && $exception->response !== null) {
            $status = $exception->response->status();
            $detail = $exception->response->json('error.message');

            if (is_string($detail) && $detail !== '') {
                return sprintf(
                    'OpenAI devolvió un error HTTP %s al generar el recuerdo.%s %s',
                    $status,
                    $modelNote,
                    trim($detail)
                );
            }

            return sprintf('OpenAI devolvió un error HTTP %s al generar el recuerdo.%s', $status, $modelNote);
        }

        if ($exception instanceof ConnectionException) {
            return sprintf(
                'No fue posible conectar con OpenAI.%s %s',
                $modelNote,
                trim($exception->getMessage())
            );
        }

        return 'No fue posible generar el recuerdo visual con OpenAI.'.$modelNote;
    }
}
