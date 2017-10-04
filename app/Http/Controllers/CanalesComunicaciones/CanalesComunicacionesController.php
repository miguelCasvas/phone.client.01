<?php

namespace App\Http\Controllers\CanalesComunicaciones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CanalesComunicacionesController extends Controller
{

    public function __construct()
    {
        $this->setClienteApiSegura();
    }


    public function index()
    {
        $url = 'canalcomunicacion/conjuntos';
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $canales = $request->formatoRespuesta()->data;
        $arregloCanales = [];

        foreach ($canales as $canal) {
            $arregloCanales[$canal->id_conjunto]['id_conjunto'] = $canal->id_conjunto;
            $arregloCanales[$canal->id_conjunto]['conjunto'] = $canal->nombre_conjunto;
            $arregloCanales[$canal->id_conjunto]['canales'][] = json_decode(json_encode($canal), true);
        }

        $datos = compact('arregloCanales');
        return view('3_canalesComunicaciones.inicioCC', $datos);
    }

    public function eliminarCanales(Request $request)
    {
        dd($request->all());
    }
}
