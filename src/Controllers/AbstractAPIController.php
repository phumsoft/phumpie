<?php

namespace Phumsoft\Phumpie\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Phumsoft\Phumpie\Models\Model;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class AbstractAPIController extends AbstractCRUDController
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $items = parent::index($request);

            return $this->respond($items);
        } catch (ValidatorException $e) {
            return $this->respondValidatorException($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse|Model
     */
    public function store(Request $request)
    {
        try {
            $created = parent::store($request);
            $message = __('message.success.create', ['name' => $this->name]);

            $this->setStatusCode(IlluminateResponse::HTTP_CREATED);

            return $this->respondWithMessage($message, $created);
        } catch (ValidatorException $e) {
            return $this->respondValidatorException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse|Model
     */
    public function update(Request $request, int $id)
    {
        try {
            $updated = parent::update($request, $id);
            $message = __('message.success.update', ['name' => $this->name]);

            $this->setStatusCode(IlluminateResponse::HTTP_ACCEPTED);

            return $this->respondWithMessage($message, $updated);
        } catch (ValidatorException $e) {
            return $this->respondValidatorException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse|bool
     *
     * @throws Throwable
     */
    public function destroy(int $id)
    {
        try {
            parent::destroy($id);
            $message = __('message.success.destroy', ['name' => $this->name]);

            $this->setStatusCode(IlluminateResponse::HTTP_NO_CONTENT);

            return $this->respondWithMessage($message);
        } catch (ValidatorException $e) {
            return $this->respondValidatorException($e);
        }
    }

    /**
     * Transform the respond validation exception message
     *
     * @param  ValidatorException  $e The validator exception
     * @return JsonResponse The json response
     */
    private function respondValidatorException(ValidatorException $e)
    {
        $messageBag = $e->getMessageBag();
        $messages = $messageBag->getMessages();
        $message = $messageBag->first();

        return $this->respondWithWarning($message, ['error' => $messages]);
    }
}