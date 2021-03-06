<?php

namespace App\Http\Controllers\Conjuntos;

use App\Http\Controllers\Catalogos\CatalogosController;
use App\Http\Controllers\Catalogos\UbicacionCatalogoController;
use App\Http\Requests\Conjunto\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class ConjuntosController extends Controller
{
    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    public function index()
    {
        $url = 'v1/conjuntos/datosgenerales_1';
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));

        $conjuntos = $request->formatoRespuesta()->data;

        # Filtrado de conjuntos a retornar
        if (\Auth::user()->id_rol != 1){

            $conjuntosAux = array();

            foreach ($conjuntos as $key => $conjunto){
                if ($conjunto->id_conjunto == \Auth::user()->id_conjunto)
                    $conjuntosAux[] = $conjunto;
            }

            $conjuntos = $conjuntosAux;
        }

        $data = compact('conjuntos');
        return view('5_conjuntos.inicioConjuntos', $data);
    }

    /**
     * Redireccionamiento al formulario de edicion
     *
     * @param Request $request
     * @param $idConjunto
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vistaEdicionConjunto(Request $request, $idConjunto)
    {
        $conjunto = $this->busquedaConjunto($request, $idConjunto)->getData()->data;
        $data = compact('conjunto');
        return view('5_conjuntos.formularioConjunto', $data);

    }

    /**
     * Envio de información al API para edición de conjunto
     *
     * @param StoreRequest $request
     * @param $idConjunto
     * @return \App\Http\PeticionesAPI\Cliente|RedirectResponse
     */
    public function editarConjunto(StoreRequest $request, $idConjunto)
    {
        $url = 'conjunto/'. $idConjunto;
        $formulario = $request->all();

        $_request = $this->clienteApi->peticionPUT($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response;

        \Alert::success('Conjunto editado con exito!');
        return back();
    }

    /**
     * Envio de información al API para almacenamiento del conjunto
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function crearConjunto(StoreRequest $request)
    {
        $url = 'conjunto';
        $formulario = $request->all();

        $_request = $this->clienteApi->peticionPOST($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response->with('formularioActivo', true);

        \Alert::success('Conjunto creado con exito!');
        return back();
    }

    /**
     * Eliminación de conjunto
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminarConjunto(Request $request, $idConjunto)
    {
        $url = 'conjunto/' . $idConjunto;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionDELETE($url));

        \Alert::success('Conjunto eliminado correctamente!');
        return back();
    }

    /**
     * Realiza la consulta al api de todos los conjuntos registrados
     *
     * @return mixed
     */
    public function listadoConjuntos(Request $request)
    {
        if (Auth::user()->id_rol == 1)
            $url = 'conjunto';
        else
            $url = 'conjunto/' . Auth::user()->id_conjunto;

        $params = $request->all();
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $params));
        $conjuntos = $request->formatoRespuesta();

        if(is_array($conjuntos->data) == false)
            $conjuntos->data = [$conjuntos->data];

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
     * Realiza la busqueda geografica del conjunto por su id
     * * Pais
     * * Departamento
     * * Ciudad
     *
     * @param $idConjunto
     * @return \Illuminate\Http\JsonResponse
     */
    public function geograficosConjunto($idConjunto)
    {
        $url = 'conjuntos/datosgenerales_2';
        $params = ['id_conjunto' => $idConjunto];
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $params));
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
        $conjuntos = $this->listadoConjuntos(\request())->data;
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
        $url = 'v1/conjuntos/'.$idConjunto.'/extensiones';
        $params = ['id_conjunto' => $idConjunto];

        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $params));

        $extensiones = $request->formatoRespuesta();

        return response()->json($extensiones);
    }

    /**
     * Busqueda de extensiones activa por conjunto con relacion a usuarios
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listadoExtensionUsuarioPorConjunto(Request $request)
    {
        $url = 'v1/conjuntos/datosgenerales_4';
        $params = $request->all();
        $_request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $params));
        $extensiones = $_request->formatoRespuesta();

        return response()->json($extensiones);
    }

    public function listadoCatalogosPorConjunto(Request $request, $idConjunto)
    {
        $catalogos = (new CatalogosController())->listadoCatalogoPorConjunto($request, $idConjunto);

        return $catalogos;

    }

    public function listadoTipoSalidaPorCatalogo(Request $request)
    {
        $url = 'v1/conjuntos/canalesComunicacion/tipoSalida';
        $params = $request->all();

        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, $params));
        return $request->formatoRespuesta()->data;
    }

    /**
     *
     *
     * @param Request $request
     * @param         $idConjunto
     *
     * @return string
     */
    public function renderSelectsCatalogo(Request $request, $idConjunto)
    {
        $catalogo = $this->listadoCatalogosPorConjunto($request, $idConjunto)->data;
        $optUbic = [];

        foreach ($catalogo as $item) {

            # Replica peticion cambiando los params del request
            # Se genera la busqueda de las ubicaciones de cada catalogo
            $url = 'ubicacioncatalogofiltrado';
            $_request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url, ['id_catalogo' => $item->id_catalogo]));
            $ubicacionCatalogo = $_request->formatoRespuesta()->data;

            # Armando options de cada catalogo
            $optUbic[$item->id_catalogo][null] = ['text' => 'Selección', 'dataExt' => null];

            foreach ($ubicacionCatalogo as $subItem) {
                $optUbic[$item->id_catalogo][$subItem->id_ubicacion_catalogo]['text'] = $subItem->nombre_ubicacion_catalogo;
                $optUbic[$item->id_catalogo][$subItem->id_ubicacion_catalogo]['dataExt'] = $subItem->valor_extension;
            }
        }
        $data = compact('catalogo', 'optUbic');
        return view('0_partials.segmentosExtension', $data)->render();
    }
}
