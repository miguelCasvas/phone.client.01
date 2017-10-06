<?php

namespace App\Http\Controllers\Catalogos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogosController extends Controller
{
    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    private function listadoCatalogos()
    {
        $url = 'catalogo';
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $catalogos = $request->formatoRespuesta();

        return $catalogos;
    }

    /**
     * Redireccion a inicio de modulo CATALOGOS
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $listadoCatalogos = $this->listadoCatalogos()->data;

        $arregloCatalogos = [];

        foreach ($listadoCatalogos as $catalogo) {
            $arregloCatalogos[$catalogo->id_conjunto]['id_conjunto'] = $catalogo->id_conjunto;
            $arregloCatalogos[$catalogo->id_conjunto]['conjunto'] = $catalogo->nombre_conjunto;
            $arregloCatalogos[$catalogo->id_conjunto]['catalogo'][] = json_decode(json_encode($catalogo), true);
        }

        $data = compact('arregloCatalogos');


        return view('4_catalogo/inicioCatalogo', $data);
    }


}
