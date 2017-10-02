<?php

namespace App\Providers;

use App\Http\Controllers\Conjuntos\ConjuntosController;
use App\Http\Controllers\Roles\RolesController;
use Illuminate\Support\ServiceProvider;

class ComposerBlades extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composerUsuario();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Vlrs por defecto a ser cargados en los campos del
     * formulario de creación de usuarios
     *
     */
    private function composerUsuario()
    {
        view()->composer('0_partials.formularioUsuario', function($view){

            $campos = new \stdClass();
            $campos->correo = new \stdClass();
            $campos->correo->readOnly = true;

            $campos->conjunto = new \stdClass();
            $campos->conjunto->select = false;

            $campos->rol = new \stdClass();
            $campos->rol->select = false;

            # Asignación de atributos y vlrs para usuario super Administrador
            if(\Auth::user()->datos->id_rol == 1){
                $campos->correo->readOnly = false;
                $campos->conjunto->select = true;
                $campos->conjunto->opc = (new ConjuntosController())->listadoConjuntosSelect();
                $campos->rol->select = true;
                $campos->rol->opc = (new RolesController())->listadoRolesSelect();
            }

            $view->with('campos', $campos);
        });
    }

}
