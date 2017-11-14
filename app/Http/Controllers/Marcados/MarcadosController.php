<?php

namespace App\Http\Controllers\Marcados;

use App\Http\Controllers\Conjuntos\ConjuntosController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarcadosController extends Controller
{

    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    public function index(Request $request)
    {

        return view('9_marcado.inicio_marcado');
    }

    public function crearMarcado(Request $request)
    {
        $url = 'v1/extensiones/planDeMarcado';
        $metodoParams = str_replace('%vlrDeCambio%', $request->get('nuevoMarcado'), $request->get('metodoParams'));

        $formulario['context'] = 'phoneup-iax';
        $formulario['exten'] = $request->get('extension');
        $formulario['app'] = $request->get('metodo');
        $formulario['appdata'] = $metodoParams . ',' . (int) $request->get('segundosMarcado');
        $formulario['dataVisual'] = $request->get('nuevoMarcado');

        $_request = $this->clienteApi->peticionPOST($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            \Alert::error('Error al generar el plan de marcado!');
        else
            \Alert::success('Plan de marcado creado con exito!');

        return back();

    }

    public function obtenerPlanDeMarcado_Extension($extension)
    {
        $url = 'v1/extensiones/planDeMarcado';
        $params = ['extension' => $extension];
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $params));
        $planDeMarcado = $request->formatoRespuesta()->data;

        return $planDeMarcado;
    }

    public function generarOrden(Request $request)
    {

        foreach ($request->get('Marcado') as $orden => $idMarcado) {
            $url = 'v1/extensiones/planDeMarcado/' . $idMarcado . '/ordenar';
            $formulario['orden'] = ($orden + 1);
            $_request = $this->clienteApi->peticionPOST($url, $formulario);
        }
        
        return response()->json($request->all());
    }

    public function eliminarMarcado(Request $request, $idMarcado)
    {
        $url = 'v1/extensiones/planDeMarcado/' . $idMarcado;
        $_request = $this->clienteApi->peticionDELETE($url);

        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            \Alert::error('Error al generar la eliminación del plan de marcado!');
        else
            \Alert::success('Plan de marcado eliminado con exito!');

        return back();
    }
}
