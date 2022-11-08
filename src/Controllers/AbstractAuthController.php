<?php

namespace Phumsoft\Phumpie\Controllers;

abstract class AbstractAuthController extends AbstractController
{
    public function __construct()
    {
        if (request()->route()->getPrefix() === 'api/{company_id}') {
            $this->middleware('auth:api');
        } else {
            $this->middleware('auth');
        }
        $this->middleware('common');
    }
}
