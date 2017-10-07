<?php

namespace App\Providers;

use App\Http\Controllers\Conjuntos\ConjuntosController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\Varios\GeograficosController;
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

        $this->composerCC();

        $this->composerCatalogo();

        $this->composerGeograficos();
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

        #
        view()->composer('2_usuarios.inicioUsuarios', function($view){

            # Variables que definen que pestaña se encuentra activa
            $pestaniaLista = 'active'; # TABLA
            $divLista = 'active'; # TABLA
            $pestaniaForm = ''; # FORMULARIO CREACION
            $divFormCreacion = ''; # FORMULARIO CREACION

            # La variable formActive toma el vlr de TRUE cuando existe un error
            # en el formulario
            if(! empty(session('formActivo'))){
                $pestaniaLista = '';
                $divLista = '';

                $pestaniaForm = 'active';
                $divFormCreacion = 'active';
            }

            $view
                ->with('pestaniaLista', $pestaniaLista)
                ->with('pestaniaForm', $pestaniaForm)
                ->with('divLista', $divLista)
                ->with('divFormCreacion', $divFormCreacion);

        });
    }

    /**
     * Vlrs pre-cargadar para el modulo de canales de comunicación
     *
     */
    private function composerCC()
    {
        view()->composer('3_canalesComunicaciones.inicioCC', function($view){

            $scriptModal = '';

            # Activar modal para creacion si el formulario presenta errores
            if (session('modalCCActivo') == true)
                $scriptModal = "$('#modalCrearCanal').modal()";

            # Items del campo Conjunto formulario de creación
            $conjuntos = (new ConjuntosController())->listadoConjuntosSelect();

            $view
                ->with('conjuntos', $conjuntos)
                ->with('scriptModal', $scriptModal);

        });
    }

    /**
     * Vlrs pre-cargadar para el modulo de Catalogos
     *
     */
    private function composerCatalogo()
    {
        view()->composer('4_catalogo.inicioCatalogo', function($view){

            $scriptModal = '';

            # Activar modal para creacion si el formulario presenta errores
            if (session('modalCatalogoActivo') == true)
                $scriptModal = "$('#modalCatalogo').modal()";

            # Items del campo Conjunto formulario de creación
            $conjuntos = (new ConjuntosController())->listadoConjuntosSelect();

            $view
                ->with('conjuntos', $conjuntos)
                ->with('scriptModal', $scriptModal);

        });
    }

    /**
     * Vlrs pre-cargar para el modulo Geografico
     */
    private function composerGeograficos()
    {
        view()->composer('20_varios.geograficos', function($view){

            $paises = (new GeograficosController())->listaPaisParaSelect();
            $view
                ->with('paises', $paises);

        });
    }

}
