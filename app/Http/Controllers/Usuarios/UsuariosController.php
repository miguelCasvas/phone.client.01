<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Extensiones\ExtensionesController;
use App\Http\Requests\Usuario\StoreRequest;
use App\Http\Requests\Usuario\UpdateRequest;
use App\Http\Requests\Usuario\UpdateRequestPW;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class UsuariosController extends Controller
{
    private $idUsuario;

    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    /**
     * Visualizacion de blade mi usuario (info. gral)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function miUsuario()
    {
        $datosUsuario = Auth::user();
        $datosView = compact('datosUsuario');

        return view('2_usuarios.miUsuario', $datosView);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function crearUsuario(StoreRequest $request)
    {
        $formulario = $request->all();

        $_request = $this->clienteApi->peticionPOST('v1/usuarios', $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse)
            return $response->with('formActivo', true);

        \Alert::success('Usuario creado con exito!');
        return back();
    }

    /**
     * Actualización de la información Gral. de mi usuario
     *
     * @param       $url
     * @param array $formulario
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function actualizarInformacion($url, array $formulario)
    {
        $request = $this->clienteApi->peticionPUT($url, $formulario);
        $response = $this->verificarErrorAPI($request);

        if ($response instanceof RedirectResponse)
            return $response->with('formActivo', true);

        \Alert::success('Actualización correcta!');
        return back();

    }

    /**
     * Actualización de informacion por usuario loqueado
     *
     * @param UpdateRequest $request
     * @param               $idUsuario
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actualizarMiInformacion(UpdateRequest $request, $idUsuario)
    {
        $this->idUsuario = $idUsuario;
        $formulario = $this->filtrarCampos($request->all());
        $url = 'edicionmiusuario/' . $idUsuario;

        \Auth::user()->datos->identificacion    = $formulario['identificacion'] ?: \Auth::user()->datos->identificacion;
        \Auth::user()->datos->nombres           = $formulario['nombres']        ?: \Auth::user()->datos->nombres;
        \Auth::user()->datos->apellidos         = $formulario['apellidos']      ?: \Auth::user()->datos->apellidos;
        \Auth::user()->datos->fecha_nacimiento  = $formulario['fechaNacimiento'] ?: \Auth::user()->datos->apellidos;

        return
            $this->actualizarInformacion($url, $formulario);

    }

    /**
     * Actualización de información usuarios por parte de superAdministrador
     *
     * @param UpdateRequest $request
     * @param               $idUsuario
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actualizarInformacionUsuario(UpdateRequest $request, $idUsuario)
    {
        $this->idUsuario = $idUsuario;
        $formulario = $this->filtrarCampos($request->all());
        $url = 'v1/usuarios/' . $idUsuario;

        return
            $this->actualizarInformacion($url, $formulario);
    }

    /**
     * Actualizacion de contraseña por usuario
     *
     * @param UpdateRequestPW $requestPW
     * @return RedirectResponse
     */
    public function actualizarContrasenia(updateRequestPW $requestPW, $idUsuario)
    {
        $this->idUsuario = $idUsuario;
        $formulario = $this->filtrarCampos($requestPW->all());
        $formulario['contrasenia'] = bcrypt($formulario['contrasenia']);
        $formulario['contrasenia_confirmation'] = $formulario['contrasenia'];

        $url = 'v1/usuarios/' . $idUsuario . '/cambioContrasenia';

        return
            $this->actualizarInformacion($url, $formulario);
    }

    /**
     * Realiza filtrado de campos no necesarios en la consulta
     *
     * @param $campos
     * @return mixed
     */
    public function filtrarCampos($campos)
    {

        # Eliminacion de campos no necesarios
        unset($campos['_token']);
        unset($campos['_method']);
        return $campos;
    }

    /**
     * Listado de usuarios
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listadoUsuarios()
    {
        $url = 'usuarios';
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $usuarios = $request->formatoRespuesta();

        /* OBJETO VACIO PARA CARGUE CORRECTO DE VISTA */
        $datosUsuario = new \stdClass();
        $datosUsuario->id_user = null;
        $datosUsuario->id_usuario = null;
        $datosUsuario->identificacion = null;
        $datosUsuario->nombres = null;
        $datosUsuario->apellidos = null;
        $datosUsuario->fecha_nacimiento = null;
        $datosUsuario->nombre_conjunto = null;
        $datosUsuario->id_conjunto = null;
        $datosUsuario->direccion = null;
        $datosUsuario->telefono = null;
        $datosUsuario->email = null;
        $datosUsuario->nombre_rol = null;
        $datosUsuario->id_rol = null;

        $data = compact('usuarios', 'datosUsuario');

        return view('2_usuarios.inicioUsuarios', $data);
    }

    /**
     * @param Request $request
     * @param         $idUsuario
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function usuario(Request $request, $idUsuario)
    {
        $url = 'usuarios/' . $idUsuario;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $datosUsuario = $request->formatoRespuesta()->data;

        $data = compact('datosUsuario');
        return view('2_usuarios.usuario', $data);

    }

    /**
     * Insercion o actualizacion de extension para usuario
     */
    public function relacionUsuarioExtension(Request $request, $idUsuario)
    {
        $formulario = array('idEstado' => 1, 'idConjunto' => (int) $request->get('idConjunto'));

        $ubicCat = $request->get('ubicCatalogo');
        $numExt = $request->get('numExt');
        $extension = '';

        $contador = 1;
        for ($i = 0; $i <= count($ubicCat); $i++){
            if (empty($ubicCat[$i]) == false){
                $formulario['idUbicacionCatalogo_' . ($contador)] = (int) $ubicCat[$i];
                $extension .= $numExt[$i];
                $contador++;
            }
        }

        $formulario['extension'] = $extension;
        $_request = $this->clienteApi->peticionPOST('v1/extensiones', $formulario);
        $response = $this->verificarErrorAPI($_request);

        if ($response instanceof RedirectResponse){

            if ($response->getSession()->get('errors')->has('extDupli'))
                \Alert::error(current($response->getSession()->get('errors')->get('extDupli')));
            else
                \Alert::error('Error al crear la extension');

            return $response->with('formActivo', true);
        }

        $formulario = array();
        $formulario['idExtension'] = $_request->formatoRespuesta()->data->id_extension;

        $_request = $this->clienteApi->peticionPOST('v1/usuarios/' . $idUsuario . '/extensiones', $formulario);
        $response = $this->verificarErrorAPI($_request);
        if ($response instanceof RedirectResponse)
            return $response->with('formActivo', true);

        \Alert::success('Se relaciono con exito la extensión al usuario!');

        return back();
    }

    /**
     * Eliminación de extension por usuario (mis extensiones) ó por usuario admin | super admin
     *
     * @param Request $request
     * @param $idUsuario
     * @param $idExtension
     * @return RedirectResponse
     */
    public function eliminarRelExtension(Request $request, $idUsuario, $idExtension)
    {
        $newRequest = $request->duplicate(['extensiones' => [$idExtension]]);
        $response = (new ExtensionesController())->eliminarExtension($newRequest);

        return $response;
    }

}
