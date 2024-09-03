<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\Enums\ResponseStatus;
use Throwable;

class ApiResponse implements Responsable
{
    public function __construct(
        private ResponseStatus $status,
        private mixed $payload,
        private ?array $metadata = [],
        private ?Throwable $exception = null,
        private int $statusCode = Response::HTTP_OK,
        private ?string $statusText = '',
        private array $headers = []
    ) {}

    /**
     * Transform the resource into an array.
     *
     * @return Illuminate\Http\JsonResponse|void
     */
    public function toResponse($request)
    {
        // return response()->noContent();
        return response()->json(
            $this->array(),
            $this->statusCode,
            $this->headers
        );
    }

    /**
     * Array response.
     *
     * @return array
     */
    public function array()
    {
        $response = [
            'status' => $this->status,
            'statusCode' => $this->statusCode,
            'statusText' => $this->statusText,
            'message' => isset($this->payload['message']) ? $this->payload['message'] : null,
            'errors' => [],
            'metadata' => isset($this->metadata) ? $this->metadata : [],
        ];

        // Remove the element with 'message' key.
        if (is_array($this->payload) && array_key_exists('message', $this->payload)) {
            unset($this->payload['message']);
        }

        if (! $this->status->value) {
            if (isset($this->payload['errors'])) {
                $response['errors'] = $this->payload['errors'];
            }

            if (! is_null($this->exception) && empty($response['errors']) && config('site.debug')) {
                $response['errors']['exception'][] = $this->exception->getMessage();
            }

            if (! is_null($this->exception) && config('app.debug')) {
                $response['debug'] = [
                    'message' => $this->exception->getMessage(),
                    'file'    => $this->exception->getFile(),
                    'line'    => $this->exception->getLine(),
                    'trace'   => $this->exception->getTraceAsString(),
                ];
            }
        } else {
            $response['payload'] = $this->payload;
        }

        return $response;
    }

    /**
     * Json array
     *
     * @return Illuminate\Http\JsonResponse|void
     */
    public function json($request = null)
    {
        return $this->toResponse($request);
    }

    /**
     * Success response.
     *
     * @param  mixed  $payload
     * @param  array  $metadata
     * @param  string|null  $message
     * @param  int  $statusCode
     * @param  string|null  $statusText
     * @param  array  $headers
     * @return self
     */
    public static function success(
        mixed $payload = null,
        ?array $metadata = [],
        ?string $message = null,
        int $statusCode = Response::HTTP_OK,
        ?string $statusText = null,
        array $headers = []
    )
    {
        return new self(
            status: ResponseStatus::SUCCESS,
            payload: ($payload instanceof JsonResource)
                ? array_merge([
                    'message' => $message,
                ], (array) $payload->response()->getData())
                : [
                    'message' => $message,
                    'data' => $payload,
                ],
            metadata: $metadata,
            exception: null,
            statusCode: $statusCode,
            statusText: $statusText,
            headers: $headers
        );
    }

    /**
     * Error response.
     *
     * @param  string|null  $message
     * @param  array  $errors
     * @param  array  $metadata
     * @param  Throwable|null  $exception
     * @param  int  $statusCode
     * @param  string|null  $statusText
     * @param  array  $headers
     * @return self
     */
    public static function error(
        ?string $message = null,
        ?array $errors = [],
        ?array $metadata = [],
        ?Throwable $exception = null,
        int $statusCode = Response::HTTP_OK,
        ?string $statusText = null,
        array $headers = []
    )
    {
        return new self(
            status: ResponseStatus::FAIL,
            payload: [
                'message' => $message,
                'errors' => $errors,
            ],
            metadata: $metadata,
            exception: $exception,
            statusCode: $statusCode,
            statusText: $statusText,
            headers: $headers
        );
    }
}
