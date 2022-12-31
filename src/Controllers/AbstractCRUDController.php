<?php

namespace Phumsoft\Phumpie\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Phumsoft\Phumpie\Interfaces\AbstractControllerInterface;
use Phumsoft\Phumpie\Models\Model;

abstract class AbstractCRUDController extends Controller implements AbstractControllerInterface
{
    /**
     * @var object
     */
    protected object $module;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $fileKey = 'myFile';

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
        return $this->repository->toList();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
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
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id)
    {
        return $this->repository->find($id);
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
     * @param  int  $id
     * @return JsonResponse|bool
     *
     * @throws Throwable
     */
    public function destroy(int $id)
    {
        return $this->repository->delete($id);
    }
}
