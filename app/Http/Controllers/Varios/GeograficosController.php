<?php

namespace App\Http\Controllers\Varios;

use App\Http\Requests\Geograficos\StoreCiudadRequest;
use App\Http\Requests\Geograficos\StoreDepartamentoRequest;
use App\Http\Requests\Geograficos\StorePaisRequest;
use App\Http\Requests\Geograficos\UpdatePaisRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeograficosController extends Controller
{
    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    /**
     * @param $url
     * @param array $params
     * @return \App\Http\PeticionesAPI\Cliente
     */
    public function peticionGenericaGet($url, array $params = [])
    {
       return
            $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $params));

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
        $arregloPaises = array(trans('configbasica.controlador.seleccion'));
 
        foreach ($paises as $pais) {
            $arregloPaises[$pais->id_pais] = $pais->nombre_pais;
        }

        return $arregloPaises;
    }

    public function crearPais(StorePaisRequest $request)
    {
        $formulario = ['nombrePais' => $request->get('nombrePais'), 'nombreOficialPais' => 'no definido'];
        $_request = $this->clienteApi->peticionPOST('pais', $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        $datos = $response->formatoRespuesta()->data;
        $datosEnvio = $request->all();
        $datosEnvio['selectPais'] = $datos->id_pais;
        $datosEnvio['idPais'] = $datos->id_pais;

        \Alert::success(trans('configbasica.controlador.paisCreado'));
        return back()->withInput($datosEnvio);
    }

    public function editarPais(StorePaisRequest $request, $idPais)
    {
        $formulario = ['nombrePais' => $request->get('nombrePais')];
        $url = 'pais/' . $idPais;

        $_request = $this->clienteApi->peticionPUT($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        $datos = $response->formatoRespuesta()->data;
        $datosEnvio = $request->all();
        $datosEnvio['selectPais'] = $datos->id_pais;
        $datosEnvio['idPais'] = $datos->id_pais;

        \Alert::success(trans('configbasica.controlador.paisEditado'));
        return back()->withInput($datosEnvio);
    }

    public function eliminarPais(StorePaisRequest $request, $idPais)
    {
        $url = 'pais/' . $idPais;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));

        \Alert::success(trans('configbasica.controlador.paisEliminado'));
        return back();
    }

    /*
     * DEPARTAMENTOS
     */
    public function departamentosFiltrados(Request $request)
    {
        $url = 'departamentofiltrado';
        $_request = $this->peticionGenericaGet($url, $request->all());
        $departamento = $_request->formatoRespuesta();

        return response()->json($departamento);
    }

    public function listaDeptoParaSelect($url, array $params)
    {
        $request = $this->peticionGenericaGet($url, $params);
        $deptos = $request->formatoRespuesta()->data;
        $departamentos = [];

        foreach ($deptos as $departamento) {
            $departamentos[$departamento->id_departamento] = $departamento->nombre_departamento;
        }

        return $departamentos;

    }

    public function crearDepartamento(StoreDepartamentoRequest $request)
    {
        $formulario = ['idPais' => $request->get('idPais'), 'nombreDepartamento' => $request->get('nombreDepartamento')];
        $_request = $this->clienteApi->peticionPOST('departamento', $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        $datos = $response->formatoRespuesta()->data;
        $datosEnvio = $request->all();
        $datosEnvio['selectDepartamento'] = $datos->id_departamento;
        $datosEnvio['idDepartamento'] = $datos->id_departamento;

        \Alert::success(trans('configbasica.controlador.deptoCreado'));
        return back()->withInput($datosEnvio);
    }

    public function editarDepartamento(StoreDepartamentoRequest $request, $idDepartamento)
    {
        $formulario = ['idPais' => $request->get('idPais'), 'nombreDepartamento' => $request->get('nombreDepartamento')];
        $url = 'departamento/' . $idDepartamento;

        $_request = $this->clienteApi->peticionPUT($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        \Alert::success(trans('configbasica.controlador.deptoEditado'));
        return back()->withInput($request->all());
    }

    public function eliminarDepartamento(Request $request, $idDepartamento)
    {
        $url = 'departamento/' . $idDepartamento;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));

        \Alert::success(trans('configbasica.controlador.deptoEliminado'));
        return back();
    }

    /*
     * CIUDADES
     */
    public function ciudadesFiltrados(Request $request)
    {
        $url = 'ciudadfiltrado';

        $_request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $request->all()));
        $departamento = $_request->formatoRespuesta();

        return response()->json($departamento);
    }

    public function listaCiudadesParaSelect($url, array $params)
    {
        $request = $this->peticionGenericaGet($url, $params);
        $ciudadesRequest = $request->formatoRespuesta()->data;
        $ciudades = [];

        foreach ($ciudadesRequest as $ciudad) {
            $ciudades[$ciudad->id_ciudad] = $ciudad->nombre_ciudad;
        }

        return $ciudades;

    }

    public function crearCiudad(StoreCiudadRequest $request)
    {
        $formulario = [
            'idDepartamento' => $request->get('idDepartamento'),
            'nombreCiudad' => $request->get('nombreCiudad')
        ];

        $_request = $this->clienteApi->peticionPOST('ciudad', $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        $datos = $response->formatoRespuesta()->data;
        $datosEnvio = $request->all();
        $datosEnvio['selectCiudad'] = $datos->id_ciudad;
        $datosEnvio['idCiudad'] = $datos->id_ciudad;

        \Alert::success(trans('configbasica.controlador.ciudadCreada'));
        return back()->withInput($datosEnvio);
    }

    public function editarCiudad(StoreCiudadRequest $request, $idCiudad)
    {
        $formulario = [
            'idPais' => $request->get('idPais'),
            'idDepartamento' => $request->get('idDepartamento'),
            'nombreCiudad' => $request->get('nombreCiudad')
        ];
        $url = 'ciudad/' . $idCiudad;

        $_request = $this->clienteApi->peticionPUT($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        \Alert::success(trans('configbasica.controlador.ciudadEditada'));
        return back()->withInput($request->all());
    }

    public function eliminarCiudad(Request $request, $idCiudad)
    {
        $url = 'ciudad/' . $idCiudad;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));

        \Alert::success(trans('configbasica.controlador.ciudadEliminada'));
        return back();
    }
}
