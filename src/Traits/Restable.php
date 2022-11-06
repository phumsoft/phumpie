<?php

namespace Phumsoft\Phumpie\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait Restable
{
    /**
     * The default status code.
     *
     * @var int
     */
    protected int $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @param $filePath
     * @param $fileName
     * @param  array  $headers
     * @return BinaryFileResponse
     */
    public function respondWithFile($filePath, $fileName, array $headers = []): BinaryFileResponse
    {
        return Response::download($filePath, $fileName, $headers);
    }

    /**
     * Will return a response.
     *
     * @param  array|string  $message
     * @param  mixed  $data The given data
     * @param  array  $headers The given headers
     * @return JsonResponse The JSON-response
     */
    public function respondWithMessage(array|string $message = 'Item has been created.', mixed $data = null, array $headers = []): JsonResponse
    {
        $message = parse_trans($this->name . '.' . $message);

        $type = 'success';
        if (is_array($message)) {
            $type = Arr::get($message, 'type', 'success');
            $message = Arr::get($message, 'message');
        }
        $data = is_null($data) || is_bool($data) ? [] : $data;
        $data = array_merge(
            $data,
            [
                'type' => $type,
                'statusText' => $message,
                'statusCode' => $this->getStatusCode(),
            ]
        );

        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Will return a response.
     *
     * @param  mix  $data The given data
     * @param  array  $headers The given headers
     * @return JsonResponse The JSON-response
     */
    public function respond($data, array $headers = []): JsonResponse
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Getter for the status code.
     *
     * @return int The status code
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Setter for the status code.
     *
     * @param  int  $statusCode The given status code
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Will result in a 400 error code.
     *
     * @param  string  $message The given message
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return JsonResponse The JSON-response with the error code
     */
    protected function respondWithWarning(string $message = 'Warning', array $headers = []): JsonResponse
    {
        $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST);

        return $this->respondWithError($message, $headers);
    }

    /**
     * Will result in an error.
     *
     * @param  array|string  $message The given message
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return JsonResponse The JSON-response with the error message
     */
    public function respondWithError(array|string $message, array $headers = []): JsonResponse
    {
        $message = parse_trans($this->name . '.' . $message);

        if (is_array($message)) {
            $message = Arr::get($message, 'message');
        }

        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode(),
            ],
            'statusCode' => $this->getStatusCode(),
            'statusText' => $message ?: __('messages.notFound', ['name' => 'Model']),
        ], $headers);
    }

    /**
     * Will result in a 401 error code.
     *
     * @param  string|null  $message The given message
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return JsonResponse The JSON-response with the error code
     */
    protected function respondUnauthorized(string $message = null, array $headers = []): JsonResponse
    {
        $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED);

        return $this->respond([
            'statusCode' => $this->getStatusCode(),
            'title' => $message ?: __('auth.token.expired.title'),
            'statusText' => __('auth.token.expired.message'),
        ], $headers);
    }

    /**
     * Will result in a 403 error code.
     *
     * @param  string  $message The given message
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return JsonResponse The JSON-response with the error message
     */
    protected function respondForbidden(string $message = 'Forbidden', array $headers = []): JsonResponse
    {
        $this->setStatusCode(IlluminateResponse::HTTP_FORBIDDEN);

        return $this->respondWithError($message, $headers);
    }

    /**
     * Will result in a 404 error code.
     *
     * @param  string  $message The given message
     * @return JsonResponse The JSON-response with the error message
     */
    protected function respondNotFound(string $message = 'Not found'): JsonResponse
    {
        $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND);

        return $this->respondWithError($message);
    }

    /**
     * Will result in a 405 error code.
     *
     * @param  string  $message The given message
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return JsonResponse The JSON-response with the error message
     */
    protected function respondNotAllowed(string $message = 'Method not allowed', array $headers = []): JsonResponse
    {
        $this->setStatusCode(IlluminateResponse::HTTP_METHOD_NOT_ALLOWED);

        return $this->respondWithError($message, $headers);
    }

    /**
     * Will result in a 422 error code.
     *
     * @param  string  $message The given message
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return JsonResponse The JSON-response with the error code
     */
    protected function respondUnprocessableEntity(string $message = 'Unprocessable', array $headers = []): JsonResponse
    {
        $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY);

        return $this->respondWithError($message, $headers);
    }

    /**
     * Will result in a 429 error code.
     *
     * @param  string  $message The given message
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return JsonResponse The JSON-response with the error message
     */
    protected function respondTooManyRequests(string $message = 'Too many requests', array $headers = []): JsonResponse
    {
        $this->setStatusCode(IlluminateResponse::HTTP_TOO_MANY_REQUESTS);

        return $this->respondWithError($message, $headers);
    }

    /**
     * Will result in a 500 error code.
     *
     * @param  string  $message The given message
     * @param  array  $headers The headers that should be send with the JSON-response
     * @return JsonResponse The JSON-response with the error message
     */
    protected function respondInternalError(string $message = 'Internal Server Error', array $headers = []): JsonResponse
    {
        $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);

        return $this->respondWithError($message, $headers);
    }
}
