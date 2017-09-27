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

    /**
     * Actualización de la información Gral. de mi usuario
     *
     * @param UpdateRequest $request
     * @param $idUsuario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actualizarInformacion(UpdateRequest $request, $idUsuario)
    {
        $url = 'edicionmiusuario/' . $idUsuario;
        $formulario = $request->all();

        $response = $this->verificarErrorAPI($this->clienteApi->peticionPUT($url, $formulario));

        \Auth::user()->datos->identificacion = $formulario['identificacion'];
        \Auth::user()->datos->nombres = $formulario['nombres'];
        \Auth::user()->datos->apellidos = $formulario['apellidos'];
        \Auth::user()->datos->fecha_nacimiento = $formulario['fechaNacimiento'];
        \Auth::user()->datos->direccion = $formulario['direccion'];
        \Auth::user()->datos->telefono = $formulario['telefono'];
        //\Auth::user()->datos->password = $formulario['password'];

        \Alert::success('Actualización correcta!');
        return back();
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

        $data = compact('usuarios');

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
