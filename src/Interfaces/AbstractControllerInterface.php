<?php

namespace Phumsoft\Phumpie\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AbstractControllerInterface
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed;
     */
    public function index(Request $request);

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|Phumsoft\Phumpie\Models\Model
     */
    public function store(Request $request);

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id);

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|Phumsoft\Phumpie\Models\Model
     */
    public function update(Request $request, int $id);

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function destroy(int $id);

    /**
     * Skip Message Response
     *
     * @param bool $status
     *
     * @return $this
     */
    public function skipResponse($status = true);
}
