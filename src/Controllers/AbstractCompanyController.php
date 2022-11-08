<?php

namespace Phumsoft\Phumpie\Controllers;

abstract class AbstractCompanyController extends AbstractAuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function authorize($ability)
    {
        $request = request();
        $company = $request->company;

        parent::authorize($ability->value, [$company, $this->module]);
    }
}
