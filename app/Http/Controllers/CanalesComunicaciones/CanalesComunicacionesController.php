<?php

namespace App\Http\Controllers\CanalesComunicaciones;

use App\Http\Requests\CanalComunicacion\StoreRequest;
use App\Http\Requests\TipoSalida\StoreRequest As StoreTpoSalida;
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function moduloTiposDeSalida()
    {
        $listado = $this->listadoTpoSalida_ft_Canales();
        $data = compact('listado');

        return view('3_canalesComunicaciones.tipoSalida', $data);
    }

    public function crearTipoSalida(StoreTpoSalida $request)
    {
        $formulario = $request->all();
        unset($formulario['_token']);

        $url = 'v1/tiposalida';
        $_request = $this->clienteApi->peticionPOST($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            \Alert::error('Error al crear el tipo de salida vuelva a intentarlo!');
        else
            \Alert::success('Tipo salida creada con exito!');

        return back();
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
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

    /**
     * @param StoreRequest $request
     * @param $idCanal
     * @return RedirectResponse
     */
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

    /**
     * @return mixed
     */
    private function listadoTpoSalida_ft_Canales()
    {
        $url = 'v1/tiposalida/listado';
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        return $request->formatoRespuesta()->data;
    }

    /**
     * @return mixed
     */
    public function listadoCanalesPorConjunto()
    {
        $url = 'v1/conjuntos/canalesComunicacion';
        $params = \request()->all();
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $params));
        return $request->formatoRespuesta()->data;
    }

    /**
     * @return array
     */
    public function listadoCanalesPorConjunto_Select()
    {
        $data = $this->listadoCanalesPorConjunto();
        $options = [null => 'Selección'];

        foreach ($data as $datum) {
            $options[$datum->id_canal] = $datum->canal;
        }

        return $options;
    }
}
