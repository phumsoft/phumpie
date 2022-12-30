<?php

namespace Phumsoft\Phumpie\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Phumsoft\Phumpie\Constants\CAbility;
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

    /**
     * @var bool
     */
    protected bool $skipResponse = false;

    /**
     * @var bool
     */
    protected bool $skipAuthorize = false;

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($this->skipAuthorize === false) {
            $this->authorize(CAbility::READ, $this->module);
        }

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
        if ($this->skipAuthorize === false) {
            $this->authorize(CAbility::CREATE, $this->module);
        }

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
        if ($this->skipAuthorize === false) {
            $this->authorize(CAbility::READ, $this->name);
        }

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
        if ($this->skipAuthorize === false) {
            $this->authorize(CAbility::UPDATE, $this->name);
        }

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
        if ($this->skipAuthorize === false) {
            $this->authorize(CAbility::DELETE, $this->name);
        }
        return $this->repository->delete($id);
    }
}
