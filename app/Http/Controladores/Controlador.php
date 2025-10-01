<?php

namespace App\Http\Controladores;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controlador extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
