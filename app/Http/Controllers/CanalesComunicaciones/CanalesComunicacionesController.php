<?php

namespace App\Http\Controllers\CanalesComunicaciones;

use App\Http\Requests\CanalComunicacion\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CanalesComunicacionesController extends Controller
{

    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    /**
     * Redireccionamiento inicio de modulo Canal Comunicación
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    public function crearCanal(StoreRequest $request)
    {
        $formulario = $request->all();
        $_request = $this->clienteApi->peticionPOST('canalcomunicacion', $formulario);

        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response->with('modalCCActivo', true);

        \Alert::success('Canal de comunicación creada con exito!');
        return back();

    }

    public function editarCanal(StoreRequest $request, $idCanal)
    {
        $url = 'canalcomunicacion/'. $idCanal;
        $formulario = $request->all();

        $_request = $this->clienteApi->peticionPUT($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response->with('modalCCActivo', true);

        \Alert::success('Canal de comunicación editado con exito!');
        return back();

    }

    /**
     * Eliminar relacion de conjunto ft canal de comunicacion
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminarCanales(Request $request)
    {
        $urlBase = 'canalcomunicacion/';
        $cc_conjunto = $request->get('cc_conjunto');

        if (empty($cc_conjunto)){
            \Alert::success('Por favor, indique canal(es) a eliminar!');
            return back();
        }

        foreach ($cc_conjunto as $conjunto => $canales) {

            foreach ($canales as $idCanal => $vlr) {
                $url = $urlBase . $idCanal;
                $request = $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));
            }
        }

        \Alert::success('Canal(es) eliminados correctamente!');
        return back();

    }

}
