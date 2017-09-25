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

    public function miUsuario()
    {
        $datosUsuario = Auth::user();
        $datosView = compact('datosUsuario');

        return view('2_usuarios.miUsuario', $datosView);
    }


    public function actualizarInformacion(UpdateRequest $request, $idUsuario)
    {
        $url = 'edicionmiusuario/' . $idUsuario;
        $formulario = $request->all();

        $response = $this->verificarErrorAPI($this->clienteApi->peticionPOST($url, $formulario));

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
}
