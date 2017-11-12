<?php

namespace App\Http\Controllers\Marcados;

use App\Http\Controllers\Conjuntos\ConjuntosController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarcadosController extends Controller
{

    public function index(Request $request)
    {

        return view('9_marcado.inicio_marcado');
    }


}
