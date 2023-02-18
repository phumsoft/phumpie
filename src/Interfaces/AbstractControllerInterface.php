<?php

namespace Phumsoft\Phumpie\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AbstractControllerInterface
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed;
     */
    public function index(Request $request);

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response|Phumsoft\Phumpie\Models\Model
     */
    public function store(Request $request);

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show(Request $request, int $id);

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|Phumsoft\Phumpie\Models\Model
     */
    public function update(Request $request, int $id);

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function destroy(int $id);
}
