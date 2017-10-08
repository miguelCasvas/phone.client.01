<?php

namespace App\Http\Controllers\Varios;

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

    public function crearPais(StorePaisRequest $request)
    {
        $formulario = ['nombrePais' => $request->get('nombrePais'), 'nombreOficialPais' => 'no definido'];
        $_request = $this->clienteApi->peticionPOST('pais', $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        \Alert::success('País creado con exito!');
        return back();
    }

    public function editarPais(StorePaisRequest $request, $idPais)
    {
        $formulario = ['nombrePais' => $request->get('nombrePais')];
        $url = 'pais/' . $idPais;

        $_request = $this->clienteApi->peticionPUT($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        \Alert::success('País editado con exito!');
        return back();
    }

    public function eliminarPais(StorePaisRequest $request, $idPais)
    {
        $url = 'pais/' . $idPais;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));

        \Alert::success('País eliminado con exito!');
        return back();
    }

    public function crearDepartamento(StoreDepartamentoRequest $request)
    {
        $formulario = ['idPais' => $request->get('idPais'), 'nombreDepartamento' => $request->get('nombreDepartamento')];
        $_request = $this->clienteApi->peticionPOST('departamento', $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        \Alert::success('Departamento creado con exito!');
        return back();
    }

    public function editarDepartamento(StoreDepartamentoRequest $request, $idDepartamento)
    {
        $formulario = ['idPais' => $request->get('idPais'), 'nombreDepartamento' => $request->get('nombreDepartamento')];
        $url = 'departamento/' . $idDepartamento;

        $_request = $this->clienteApi->peticionPUT($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        \Alert::success('Departamento editado con exito!');
        return back();
    }

    public function departamentosFiltrados(Request $request)
    {
        $url = 'departamentofiltrado';

        $_request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $request->all()));
        $departamento = $_request->formatoRespuesta();

        return response()->json($departamento);

    }

    public function eliminarDepartamento(Request $request, $idDepartamento)
    {
        $url = 'departamento/' . $idDepartamento;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));

        \Alert::success('Departamento eliminado con exito!');
        return back();
    }

    public function ciudadesFiltrados(Request $request)
    {
        $url = 'ciudadfiltrado';

        $_request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $request->all()));
        $departamento = $_request->formatoRespuesta();

        return response()->json($departamento);
    }
}
