<?php

namespace Phumsoft\Phumpie\Controllers;

abstract class AbstractAuthController extends AbstractCRUDController
{
    public function __construct()
    {
        $this->middleware('common');
    }
}
