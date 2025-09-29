<?php

namespace App\Http\Controllers;

use App\Traits\Api\Response\ResponseHandler;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\FileHandler;
use App\Traits\TranslatableHandler;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FileHandler, TranslatableHandler, ResponseHandler;

    protected $pagination_count = 50;

}
