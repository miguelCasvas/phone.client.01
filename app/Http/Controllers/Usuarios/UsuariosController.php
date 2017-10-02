<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Requests\Usuario\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class UsuariosController extends Controller
{

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


    public function crearUsuario(Request $request)
    {
        echo "HOLA LA";
        dd();
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

        $response = $this->verificarErrorAPI($this->clienteApi->peticionPUT($url, $formulario));

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
        $url = 'edicionmiusuario/' . $idUsuario;

        $formulario = $request->all();

        \Auth::user()->datos->identificacion = $formulario['identificacion'];
        \Auth::user()->datos->nombres = $formulario['nombres'];
        \Auth::user()->datos->apellidos = $formulario['apellidos'];
        \Auth::user()->datos->fecha_nacimiento = $formulario['fechaNacimiento'];

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
        $url = 'usuarios/' . $idUsuario;

        return
            $this->actualizarInformacion($url, $request->all());
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
        $data = compact('datosUsuario');
        return view('2_usuarios.usuario', $data);

    }
}
