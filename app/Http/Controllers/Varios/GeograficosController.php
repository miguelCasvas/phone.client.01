<?php

namespace App\Http\Controllers\Varios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeograficosController extends Controller
{
    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    public function listaPaises()
    {
        $url = 'pais';
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $paises = $request->formatoRespuesta();

        return response()->json($paises);
    }

    public function listaPaisParaSelect()
    {
        $paises = $this->listaPaises()->getData()->data;
        $arregloPaises = array('Selección');

        foreach ($paises as $pais) {
            $arregloPaises[$pais->id_pais] = $pais->nombre_pais;
        }

        return $arregloPaises;
    }

    public function departamentosFiltrados(Request $request)
    {
        $url = 'departamentofiltrado';

        $_request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $request->all()));
        $departamento = $_request->formatoRespuesta();

        return response()->json($departamento);

    }
}
