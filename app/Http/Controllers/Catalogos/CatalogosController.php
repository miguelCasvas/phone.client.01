<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Requests\Catalogo\StoreRequest;
use Illuminate\Http\RedirectResponse;
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

    public function crearCatalogo(StoreRequest $request)
    {
        $formulario = $request->all();
        $_request = $this->clienteApi->peticionPOST('catalogo', $formulario);

        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response->with('modalCatalogoActivo', true);

        \Alert::success('Catalogo creada con exito!');
        return back();

    }

    /**
     * Edicion de catalogo
     *
     * @param StoreRequest $request
     * @param $idCatalogo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editarCatalogo(StoreRequest $request, $idCatalogo)
    {
        $url = 'catalogo/'. $idCatalogo;
        $formulario = $request->all();

        $_request = $this->clienteApi->peticionPUT($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response->with('modalCatalogoActivo', true);

        \Alert::success('Catalogo editado con exito!');
        return back();

    }

    /**
     * Eliminar relacion de conjunto ft Catalogo
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminarCatalogo(Request $request)
    {
        $urlBase = 'catalogo/';
        $catalogo_conjunto = $request->get('catalogo_conjunto');

        if (empty($catalogo_conjunto)){
            \Alert::success('Por favor, indique catalogo(s) a eliminar!');
            return back();
        }

        foreach ($catalogo_conjunto as $conjunto => $catalogo) {

            foreach ($catalogo as $idCatalogo => $vlr) {
                $url = $urlBase . $idCatalogo;
                $request = $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));
            }
        }

        \Alert::success('Catalogo(s) eliminado(s) correctamente!');
        return back();

    }

}
