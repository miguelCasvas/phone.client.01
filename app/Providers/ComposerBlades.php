<?php

namespace App\Providers;

use App\Http\Controllers\CanalesComunicaciones\CanalesComunicacionesController;
use App\Http\Controllers\Catalogos\UbicacionCatalogoController;
use App\Http\Controllers\Conjuntos\ConjuntosController;
use App\Http\Controllers\Marcados\MarcadosController;
use App\Http\Controllers\Roles\RolesController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

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

        $this->composerUbicacionCatalogo();

        $this->composerTipoSalida();

        $this->composerMarcado();
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
            if(in_array(\Auth::user()->datos->id_rol, [1, 2])){
                $campos->correo->readOnly = false;
                $campos->conjunto->select = true;
                $campos->conjunto->opc = (new ConjuntosController())->listadoConjuntosSelect();
                $campos->rol->select = true;
                $campos->rol->opc = (new RolesController())->listadoRolesSelect();

                if (\Auth::user()->datos->id_rol == 2){
                    unset($campos->rol->opc[1]);
                    unset($campos->rol->opc[2]);
                }
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
            $departamentos = [0 => trans('configbasica.controlador.seleccion')];
            $ciudades = [0 => trans('configbasica.controlador.seleccion')];

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

    /**
     * Vlrs pre-cargar para el modulo ubicacion Catalogos
     */
    private function composerUbicacionCatalogo()
    {
        view()->composer('4_catalogo.ubicacionCatalogo', function($view){
            $conjuntoSelected = null;
            $catalogo = [];
            $contentTdUbicacion = '<td align="center" class="text-muted"><h4>Ubicaciones</h4></td>';
            $idCatalogo = null;
            $scriptModalUbicCat = '';

            # Si por url llega como parametro el id del conjunto
            if (\request()->has('idConjunto')){
                $conjuntoSelected = \request()->get('idConjunto');
                $catalogo = (new ConjuntosController())->listadoCatalogosPorConjunto(\request(), $conjuntoSelected)->data;

            }

            # Si por url llega como parametro el id del catalogo
            if (\request()->has('idCatalogo')){
                $newRequest = \request()->duplicate(['id_catalogo' => \request()->get('idCatalogo')]);
                $contentTdUbicacion = (new UbicacionCatalogoController())->renderUbicaciones($newRequest);
                $idCatalogo = \request()->get('idCatalogo');
            }

            # Si se generan errores en la actualizacion de la ubicación
            if (session('formUbicCat_Activo') == true)
                $scriptModalUbicCat = '$("#ModalUbicacionCat").modal()';

            $view
                ->with('conjuntoSelected', $conjuntoSelected)
                ->with('catalogo', $catalogo)
                ->with('contentTdUbicacion', $contentTdUbicacion)
                ->with('idCatalogo', $idCatalogo)
                ->with('scriptModalUbicCat', $scriptModalUbicCat);

        });
    }

    /**
     * Vlrs pre-cargar para el modulo Tipo salida
     */
    private function composerTipoSalida()
    {
        view()->composer('3_canalesComunicaciones.tipoSalida', function($view){

            $scriptModal = '';

            # Activar modal para creacion si el formulario presenta errores
            if (session('modalCCActivo') == true)
                $scriptModal = "$('#modalCrearCanal').modal()";

            # Items del campo Conjunto formulario de creación
            $conjuntos = (new ConjuntosController())->listadoConjuntosSelect();
            $idConjunto = null;

            $canalesComunicacion = [null => 'Selección'];

            # Si se selecciona un conjunto
            if (\request()->has('id_conjunto')){
                $canalesComunicacion = (new CanalesComunicacionesController())->listadoCanalesPorConjunto_Select();
                $idConjunto = \request()->get('id_conjunto');
            }

            $view
                ->with('idConjunto', $idConjunto)
                ->with('conjuntos', $conjuntos)
                ->with('canalesComunicacion', $canalesComunicacion);


        });

    }

    private function composerMarcado()
    {
        view()->composer('9_marcado.inicio_marcado', function($view){

            # Listado extensiones
            $extensiones = [null => 'Selección'];
            $extensionGet = null;

            # Plan de marcado de extension
            $planMarcado = [];

            # Items del campo Conjunto formulario de creación
            $conjuntos = (new ConjuntosController())->listadoConjuntosSelect();
            $idConjunto = null;

            $canalesComunicacion = [null => 'Selección'];
            $tiposSalida = [];

            # Si se selecciona un conjunto
            if (\request()->has('id_conjunto')){
                $newRequest = \request()->duplicate(['id_conjunto' => \request()->get('id_Conjunto')]);
                $tiposSalida = (new ConjuntosController())->listadoTipoSalidaPorCatalogo($newRequest);
                $idConjunto = \request()->get('id_conjunto');
            }

            # Si se selecciona una extension
            if (\request()->has('extension')){
                $extensionGet = \request()->get('extension');
                $planMarcado =
                    (new MarcadosController())->obtenerPlanDeMarcado_Extension($extensionGet);

            }

            foreach (\Auth::user()->extensiones as $extension) {
                $extensiones[$extension->extension] = $extension->extension;
            }

            $view
                ->with('idConjunto', $idConjunto)
                ->with('extensiones', $extensiones)
                ->with('extensionGet', $extensionGet)
                ->with('conjuntos', $conjuntos)
                ->with('planMarcado', $planMarcado)
                ->with('tiposSalida', $tiposSalida);

        });
    }
}
