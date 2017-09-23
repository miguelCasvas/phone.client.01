<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Requests\Usuario\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        $response = $this->clienteApi->peticionPOST($url, $formulario);
        dd($response->formatoRespuesta());
    }
}
