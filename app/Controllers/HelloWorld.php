<?php

use App\Controllers\BaseControllers;
namespace App\Controllers;

class HelloWorld extends BaseController
{
    public function index()
    {
        $datos['llave1']="Desde Index";
        return view('View_HelloWorld', $datos);
    }
    public function desdeSubCarpeta()
    {
        $datos['llave1']="Desde SubCarpeta";
        return view('View_HelloWorld', $datos);
    }
}
