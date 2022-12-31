<?php

namespace Phumsoft\Phumpie\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Phumsoft\Phumpie\Traits\Restable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Restable;
}
