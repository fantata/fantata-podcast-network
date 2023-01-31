<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CrudControllerTrait; 

class Show extends Controller
{
    use CrudControllerTrait;
    private $model = Show::class;

    public function validationRules($resource_id = 0)
    {
        return ['title' => 'required', 'description' => 'required'];
    }

}
