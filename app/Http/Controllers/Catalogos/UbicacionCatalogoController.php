<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Conjuntos\ConjuntosController;
use App\Http\Requests\UbicacionCatalogo\StoreRequest;
use App\Http\Requests\UbicacionCatalogo\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;

class UbicacionCatalogoController extends Controller
{
    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    public function index(Request $request)
    {
        $conjuntos = (new ConjuntosController())->listadoConjuntosSelect();
        $catalogos = new \stdClass();

        $data = compact('conjuntos');

        return view('4_catalogo.ubicacionCatalogo', $data);
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

    public function renderUbicaciones(Request $request)
    {
        $data = $this->ubicacionCatalogoFiltrado($request)->getData();
        $contentTable = '';

        try{

            if (empty($data->data))
                throw new Exception();

            foreach ($data->data as $datum) {

                $metadataBtn = 'data-id-ubic="'.$datum->id_ubicacion_catalogo.'"';
                $metadataBtn .= 'data-nom-ubic="'.$datum->nombre_ubicacion_catalogo.'"';
                $metadataBtn .= 'data-vlr-ubic="'.$datum->valor_extension.'"';

                $contentTable .= '<tr>';
                $contentTable .= '<td width="10px"><input type="checkbox" name=""></td>';
                $contentTable .= '<td width="10px">' .
                                    '<button class="btn btn-primary btn-xs btn-edit-ubic" '.$metadataBtn.' type="button">' .
                                    '<i class="fa fa-pencil" aria-hidden="true"></i></button>' .
                                 '</td>';
                $contentTable .= '<td>' . $datum->nombre_ubicacion_catalogo .'</td>';
                $contentTable .= '<td>' . $datum->valor_extension .'</td>';
                $contentTable .= '</tr>';
            }
        }catch(\Exception $e){
            $contentTable = '<td align="center" class="text-muted"><h4>Sin ubicaciones</h4></td>';
        }

        return $contentTable;
    }

    /**
     * Edicion de Ubicación Catalogo
     *
     * @param UpdateRequest $request
     * @return RedirectResponse
     */
    public function editarUbicacionCatalogo(UpdateRequest $request, $idUbicCat)
    {
        $formulario = $request->all();
        $_request = $this->clienteApi->peticionPUT('v1/ubicacioncatalogo/' . $idUbicCat, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response->with('formUbicCat_Activo', true);

        \Alert::success('Actualizacion exitosa!');
        return back();
    }

    public function crearUbicacionCatalogo(StoreRequest $request)
    {
        $url = 'v1/ubicacioncatalogo';
        $formulario = $request->all();
        $_request = $this->clienteApi->peticionPOST($url, $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response->with('formUbicCat_Activo', true);

        \Alert::success('Ubicación creada con exito!');
        return back();
    }

}
