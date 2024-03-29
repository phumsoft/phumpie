<?php

namespace Phumsoft\Phumpie\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;

trait Restable
{
    /**
     * The default skip response.
     */
    protected bool $skipResponse = false;

    /**
     * The default status code.
     */
    protected int $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * Getter for the status code.
     *
     * @return int The status code
     */
    protected function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Setter for the status code.
     *
     * @param  int  $statusCode The given status code
     */
    protected function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Will return a response.
     *
     * @param  mix  $data The given data
     * @param  array  $headers The given headers
     * @return JsonResponse The JSON-response
     */
    protected function respond($data, array $headers = []): JsonResponse
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Skip Message Response
     *
     * @param  bool  $status
     * @return void
     */
    protected function skipResponse($status = true)
    {
        $this->skipResponse = $status;
    }

    /**
     * Will return a response.
     *
     * @param  mixed  $data The given data
     * @param  mixed  $data The given data
     * @param  array  $headers The given headers
     * @return mixed The JSON-response
     */
    protected function respondWithMessage(array|string $message = 'Item has been created.', mixed $data = [], array $headers = []): mixed
    {
        if ($this->skipResponse) {
            return $data;
        }
        $transformed = $this->transformer($message, $data);

        return $this->respond($transformed, $headers);
    }

    /**
     * Will result in a 400 error code.
     *
     * @param  string  $message The given message
     * @param  mixed  $data The given data
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return mixed The JSON-response with the error code
     */
    protected function respondWithWarning(string $message = 'Warning', mixed $data = [], array $headers = []): mixed
    {
        if ($this->skipResponse) {
            return $data;
        }
        $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST);

        $transformed = $this->transformer($message, $data);

        return $this->respond($transformed, $headers);
    }

    /**
     * Will result in an error.
     *
     * @param  array|string  $message The given message
     * @param  mixed  $data The given data
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return mixed The JSON-response with the error message
     */
    protected function respondWithError(array|string $message, mixed $data = [], array $headers = []): mixed
    {
        if ($this->skipResponse) {
            return $data;
        }

        $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);

        $transformed = $this->transformer($message, $data);

        return $this->respondWithMessage($transformed, $headers);
    }

    /**
     * Transform data format
     *
     * @param  array|string  $message The given message
     * @param  mixed  $data Data to transform
     * @return array Transformed data
     */
    private function transformer(string $message, mixed $data): mixed
    {
        if (is_array($message)) {
            $message = Arr::first($message, null, 'message');
        }

        if (is_array($message)) {
            $message = Arr::get($message, 'message');
        }
        $data = is_null($data) || is_bool($data) ? [] : $data;

        $transformed = $data;
        if (!Arr::exists($data, 'data')) {
            $transformed = ['data' => $data];
        }
        $transformed = array_merge(
            $transformed,
            [
                'message' => $message,
                'status' => $this->getStatusCode(),
            ]
        );

        return $transformed;
    }
}
