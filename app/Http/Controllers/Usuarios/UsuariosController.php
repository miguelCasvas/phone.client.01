<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Requests\Usuario\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    public function miUsuario()
    {
        $datosUsuario = Auth::user();

        $datosView = compact('datosUsuario');

        return view('usuario.miPerfil', $datosView);
    }


    //public function actualizarInformacion(UpdateRequest $request)
    //{
    //
    //}
}
