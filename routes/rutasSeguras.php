<?php

/*
 * --------------------------------------------------------------------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------
 *
 *                                     RUTAS HABILITADAS SOLO PARA CUANDO SE INICIA LA SESION
 *
 * --------------------------------------------------------------------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------
 */

/*
 * Rutas para procesos a realizar sobre mi usuario
 */
Route::get('miperfil', 'Usuarios\UsuariosController@miUsuario')->name('getMiPerfil');
Route::put('miperfil/{idUsuario}', 'Usuarios\UsuariosController@actualizarMiInformacion')->name('putMiPerfil');

/*
 * Rutas para procesos sobre usuarios
 */
# Lista usuarios
Route::get('usuarios', 'Usuarios\UsuariosController@listadoUsuarios')->name('getListadoUsuarios');
# Info. Usuario
Route::get('usuario/{idUsuario}','Usuarios\UsuariosController@usuario')->name('getUsuario');
# Actualizacion info usuarios por Administrador
Route::put('usuario/{idUsuario}', 'Usuarios\UsuariosController@actualizarInformacionUsuario')->name('putUsuario');
# Creación de usuarios por Administrador
Route::post('usuario', 'Usuarios\UsuariosController@crearUsuario')->name('postUsuario');

/*
 * Rutas para procesos sobre conjuntos
 */
# Rutas Conjuntos
Route::get('conjuntos', 'Conjuntos\ConjuntosController@listadoConjuntos')->name('listadoConjuntos');
Route::get('conjunto/{idConjunto}', 'Conjuntos\ConjuntosController@busquedaConjunto')->name('getConjunto');
Route::get('extensiones/conjunto/{idConjunto}', 'Conjuntos\ConjuntosController@listadoExtensionesPorConjunto')->name('getExtensionesConjunto');


/*
 * Rutas para procesos sobre canales de comunicación
 */
Route::get('canalesComunicacion', 'CanalesComunicaciones\CanalesComunicacionesController@index')->name('getModuloCC');
Route::post('canalesComunicacion/eliminacion', 'CanalesComunicaciones\CanalesComunicacionesController@eliminarCanales')->name('getEliminacionCC');
Route::post('canalesComunicacion', 'CanalesComunicaciones\CanalesComunicacionesController@crearCanal')->name('postCrearCC');
Route::post('canalesComunicacion/{idCanal}', 'CanalesComunicaciones\CanalesComunicacionesController@editarCanal')->name('postEditarCC');


/*
 * Rutas para procesos sobre catalogos
 */
Route::get('catalogos', 'Catalogos\CatalogosController@index')->name('getModuloCatalogos');


Route::get('inicioUsuario', function () {
    return view('inicio');
})->name('inicioUsuario');


Route::get('miInfo', function(){

    dd(Auth::user());
});