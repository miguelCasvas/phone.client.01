<?php

namespace App\Http\Controllers\Conjuntos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConjuntosController extends Controller
{
    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    /**
     * Realiza la consulta al api de todos los conjuntos registrados
     *
     * @return mixed
     */
    public function listadoConjuntos()
    {
        $url = 'conjunto';
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $conjuntos = $request->formatoRespuesta();

        return $conjuntos;
    }

    /**
     * Busqueda de conjunto por id
     *
     * @param $idConjunto
     * @return mixed
     */
    public function busquedaConjunto(Request $request, $idConjunto)
    {
        $url = 'conjunto/' . $idConjunto;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $conjunto = $request->formatoRespuesta();

        return response()->json($conjunto);

    }

    /**
     * Retorna un arreglo con el id del conjunto como key
     * y el nombre del conjunto como value para campos Select
     *
     * @return array
     */
    public function listadoConjuntosSelect()
    {
        $conjuntos = $this->listadoConjuntos()->data;
        $arregloConjuntos[] = 'Selección';

        foreach ($conjuntos as $conjunto)
            $arregloConjuntos[$conjunto->id_conjunto] = $conjunto->nombre_conjunto;

        return $arregloConjuntos;
    }

    /**
     * Busqueda de extensiones activas por conjunto
     *
     * @param $idConjunto
     * @return \Illuminate\Http\JsonResponse
     */
    public function listadoExtensionesPorConjunto($idConjunto)
    {
        $url = 'extensiones/conjunto/' . $idConjunto;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $extensiones = $request->formatoRespuesta();

        return response()->json($extensiones);
    }
}
