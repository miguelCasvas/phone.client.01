<?php

namespace App\Providers;

use App\Http\Controllers\Conjuntos\ConjuntosController;
use App\Http\Controllers\Roles\RolesController;
use GuzzleHttp\Psr7\Request;
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

        $this->composerConjunto();

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
     * Vlrs pre-cargar para el modulo de conjuntos
     */
    private function composerConjunto()
    {

        view()->composer('5_conjuntos.inicioConjuntos', function($view){


            $listaConjutos = 'active';
            $formCreacion = '';

            if(session()->get('formularioActivo') == true){
                $listaConjutos = '';
                $formCreacion = 'active';
            }

            $view
                ->with('listaConjutos', $listaConjutos)
                ->with('formCreacion', $formCreacion);

        });

        /*
         * EDICION DE CONJUNTO
         */
        view()->composer('5_conjuntos.formularioConjunto', function($view){

            # Datos que se pasan a vista desde controlador
            $datosVista = $view->getData();
            # Datos de conjunto
            $conjunto = $datosVista['conjunto'];

            $controladorGeo = new \App\Http\Controllers\Varios\GeograficosController();
            $controladorConjunto = new \App\Http\Controllers\Conjuntos\ConjuntosController();

            # Busqueda de (pais | depto | ciudad) del conjunto a editar
            $geograficos = $controladorConjunto->geograficosConjunto($conjunto->id_conjunto)->getData()->data;
            $geograficos = current($geograficos);

            # Generar un arreglo con los paises registrados en BD
            $paises = $controladorGeo->listaPaisParaSelect();
            # Arreglo a ser cargado en el campo Departamento
            $departamentos = [0 => 'Selección', $geograficos->id_departamento => $geograficos->nombre_departamento];
            # Arreglo a ser cargado en el campo Ciudad
            $ciudades = [0 => 'Selección', $geograficos->id_ciudad => $geograficos->nombre_ciudad];

            $view
                ->with('paises', $paises)
                ->with('idPais', $geograficos->id_pais)
                ->with('departamentos', $departamentos)
                ->with('idDepartamento', $geograficos->id_departamento)
                ->with('ciudades', $ciudades);

        });

        /*
         * CREACION DE CONJUNTO
         */
        view()->composer('5_conjuntos.formularioCreacionConjunto', function($view){

            $controladorGeo = new \App\Http\Controllers\Varios\GeograficosController();

            # Generar un arreglo con los paises registrados en BD
            $paises = $controladorGeo->listaPaisParaSelect();
            # Arreglo a ser cargado en el campo Departamento
            $departamentos = [0 => 'Selección'];
            # Arreglo a ser cargado en el campo Ciudad
            $ciudades = [0 => 'Selección'];

            $view
                ->with('paises', $paises)
                ->with('departamentos', $departamentos)
                ->with('ciudades', $ciudades);

        });
    }

    /**
     * Vlrs pre-cargar para el modulo Geografico
     */
    private function composerGeograficos()
    {
        view()->composer('20_varios.geograficos', function($view){

            $controladorGeo = new \App\Http\Controllers\Varios\GeograficosController();
            $paises = $controladorGeo->listaPaisParaSelect();
            $departamentos = [0 => 'Selección'];
            $ciudades = [0 => 'Selección'];

            if (empty(old('idPais')) == false){
                $departamentos +=
                    $controladorGeo->listaDeptoParaSelect('departamentofiltrado', ['id_pais' => old('idPais')]);
            }

            if (empty(old('idDepartamento')) == false){
                $ciudades +=
                    $controladorGeo->listaCiudadesParaSelect('ciudadfiltrado', ['id_departamento' => old('idDepartamento')]);
            }

            $view
                ->with('paises', $paises)
                ->with('departamentos', $departamentos)
                ->with('ciudades', $ciudades);

        });
    }


}
