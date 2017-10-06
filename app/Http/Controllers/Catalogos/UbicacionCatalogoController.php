<?php

namespace App\Http\Controllers\Catalogos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UbicacionCatalogoController extends Controller
{
    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    public function index()
    {
        return view('4_catalogo.ubicacionCatalogo');
    }
    
    /**
     * Generar busqueda en ubicacion catalogo por filtros
     *
     * @param Request $request
     * @return mixed
     */
    public function ubicacionCatalogoFiltrado(Request $request)
    {
        $url = 'ubicacioncatalogofiltrado';

        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $request->all()));
        $ubicacionCatalogo = $request->formatoRespuesta();

        return response()->json($ubicacionCatalogo);
    }
}
