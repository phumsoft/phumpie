<?php

namespace Phumpie\Controllers;

use App\Constants\CAbility;
use App\Constants\CModule;
use App\Http\Controllers\Core\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Phumpie\Interfaces\AbstractControllerInterface;
use Phumpie\Models\Model;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class AbstractController extends Controller implements AbstractControllerInterface
{
    /**
     * @var object
     */
    protected object $module;

    protected string $name;

    protected string $fileKey = 'myFile';

    protected bool $skipResponse = false;

    protected bool $skipAuthorize = false;

    public function __construct()
    {
        $this->skipAuthorize = $this->module === CModule::PUBLIC;
    }

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

        $items = $this->repository->toList();

        if ($this->skipResponse === true) {
            return $items;
        }

        return $this->respond($items);
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
        if ($request->company) {
            $attributes['company_id'] = $request->company->id;
        }
        try {
            $data = $this->repository->create($attributes);

            return $this->skipResponse === true ? $data : $this->respondWithMessage('created', $data);
        } catch (ValidatorException $e) {
            return $this->respondWithWarning($e->getMessageBag());
        }
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

        if ($request->get('withTrashed', false)) {
            $this->repository->pushCriteria(WithTrashedCriteria::class);
        }

        $this->repository->skipPresenter();

        return $this->respond($this->repository->find($id));
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
        if ($request->company) {
            $attributes['company_id'] = $request->company->id;
        }

        try {
            $data = $this->repository->update($attributes, $id);

            return $this->skipResponse === true ? $data : $this->respondWithMessage('updated', $data);
        } catch (ValidatorException $e) {
            return $this->respondWithWarning($e->getMessageBag());
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
        if ($this->skipAuthorize === false) {
            $this->authorize(CAbility::DELETE, $this->name);
        }

        try {
            $data = $this->repository->delete($id);

            return $this->skipResponse === true ? $data : $this->respondWithMessage('deleted', $data);
        } catch (ValidatorException $e) {
            return $this->respondWithWarning($e->getMessageBag());
        }
    }
}
