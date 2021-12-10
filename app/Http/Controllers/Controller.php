<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $success=200; 
    public $created=201; 
    public $badRequest=400; 
    public $forbidden=403;
    public $notFound=404; 
    public $internalServerError=500; 
    public $badGateway=502; 
}
