<?php

namespace App\Http\Controllers\Extensiones;

use App\Http\Controllers\Conjuntos\ConjuntosController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExtensionesController extends Controller
{

    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    public function index()
    {
        $conjuntos = $this->getListadoConjuntos();
        $data = compact('conjuntos');

        return view('7_extensiones.inicioExtensiones', $data);
    }

    public function getListadoConjuntos()
    {
        return (new ConjuntosController())->listadoConjuntos(\request())->data;
    }

    public function eliminarRelExtensiones(Request $request)
    {

        if ($request->has('extension') == false){
            \Alert::warning('Por favor, seleccione una o mas extensiones para desasociar');
            return back();
        }

        $extensiones = $request->get('extension');
        $idsUsuarioExtension = array();
        $idsExtensionesSinRel = array();

        foreach ($extensiones as $idExtension => $extension) {
            foreach ($extension as $idUsuExten => $item) {
                if ($idUsuExten != 'null'){
                    $idsUsuarioExtension[] = $idUsuExten;
                    $url = 'usuarioextension/' . $idUsuExten;
                    $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));
                }
                else
                    $idsExtensionesSinRel[] = $idExtension;
            }
        }

        if (empty($idsUsuarioExtension)){
            \Alert::warning('Por favor, seleccione una o mas extensiones con relación a usuarios');
            return back();
        }

        if (empty($idsExtensionesSinRel) == false){
            \Alert::warning('Eliminación de relacion(es) Correcta, pero se enviaron extensiones sin relación');
            return back();
        }

        \Alert::success('Eliminación de relacion(es) Correcta');
        return back();

    }

    public function eliminarExtension(Request $request)
    {
        $extensiones = $request->get('extensiones');

        # Validar si no viene ninguna extension a eliminar
        if (empty($extensiones)){
            \Alert::warning('Por favor, seleccione una o mas extensiones para eliminar');
            return back();
        }

        foreach ($extensiones as $extension) {
            $url = 'v1/extensiones/' . $extension;
            $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));
        }

        \Alert::success('Eliminación de extension(es) Correcta!');
        return back();

    }
}
