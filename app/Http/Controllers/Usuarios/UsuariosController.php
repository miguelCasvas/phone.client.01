<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Requests\Usuario\StoreRequest;
use App\Http\Requests\Usuario\UpdateRequest;
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

    public function crearUsuario(StoreRequest $request)
    {
        $formulario = $request->all();
        $_request = $this->clienteApi->peticionPOST('usuarios', $formulario);

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

        if (empty($formulario['idExtension']) == false){
            $relacion = $this->relacionUsuarioExtension($formulario['idExtension']);

            if ($relacion == false)
                return back();

        }

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
        $url = 'usuarios/' . $idUsuario;

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

        # Valida si la contraseña viene definida si es asi la serealiza para su envio
        if (empty($campos['contrasenia']) == false){
            $campos['password'] = Hash::make($campos['contrasenia']);
            $campos['password_confirmation'] = $campos['password'];
        }

        # Eliminacion de campos no necesarios
        unset($campos['_token']);
        unset($campos['_method']);
        unset($campos['contrasenia']);
        unset($campos['contrasenia_confirmation']);

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
     * @param $idUsuario
     */
    public function usuario(Request $request, $idUsuario)
    {
        $url = 'usuarios/' . $idUsuario;
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $datosUsuario = $request->formatoRespuesta()->data;
        //dd($datosUsuario);
        $data = compact('datosUsuario');
        return view('2_usuarios.usuario', $data);

    }

    /**
     * Insercion o actualizacion de extension para usuario
     */
    private function relacionUsuarioExtension($idExtension)
    {
        $url = 'usuarioextension/' . $idExtension;
        $request = $this->clienteApi->peticionGET($url);
        $response = $this->verificarErrorAPI($request);

        if(empty($response->formatoRespuesta()->data) == false){
            \Alert::error('Esta Extensión ya se encuentra asignada!');
            return false;
        }

        $formulario['idExtension'] = $idExtension;
        $formulario['idUsuario'] = $this->idUsuario;

        $request = $this->clienteApi->peticionPOST($url, $formulario);

        return true;
    }
}
