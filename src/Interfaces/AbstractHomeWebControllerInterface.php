<?php

namespace Phumsoft\Phumpie\Interfaces;

use Illuminate\Http\Request;

interface AbstractHomeWebControllerInterface
{
    /**
     * Display the company info
     *
     * @param  int  $companyId
     * @return mixed;
     */
    public function companyInfo(int $companyId);

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed;
     */
    public function index(Request $request);
}
