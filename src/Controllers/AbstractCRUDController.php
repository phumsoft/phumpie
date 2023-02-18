<?php

namespace Phumsoft\Phumpie\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Phumsoft\Phumpie\Interfaces\AbstractControllerInterface;
use Phumsoft\Phumpie\Models\Model;
use Phumsoft\Phumpie\Traits\MessageTranslator;
use Phumsoft\Phumpie\Traits\ModalTranslator;

abstract class AbstractCRUDController extends Controller implements AbstractControllerInterface
{
    use ModalTranslator, MessageTranslator;

    protected object $module;

    protected string $fileKey = 'myFile';

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->repository->toList();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse|Model
     */
    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes[$this->fileKey] = null;
        $attributes['fileKey'] = $this->fileKey;
        if ($request->hasFile($this->fileKey)) {
            $attributes[$this->fileKey] = $request->file($this->fileKey);
        }

        return $this->repository->create($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show(Request $request, int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return JsonResponse|Model
     */
    public function update(Request $request, int $id)
    {
        $attributes = $request->all();
        $attributes[$this->fileKey] = null;
        $attributes['fileKey'] = $this->fileKey;
        if ($request->hasFile($this->fileKey)) {
            $attributes[$this->fileKey] = $request->file($this->fileKey);
        }

        return $this->repository->update($attributes, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse|bool
     *
     * @throws Throwable
     */
    public function destroy(int $id)
    {
        return $this->repository->delete($id);
    }
}
