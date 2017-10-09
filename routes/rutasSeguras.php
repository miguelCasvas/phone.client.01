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
Route::post('catalogos/eliminacion', 'Catalogos\CatalogosController@eliminarCatalogo')->name('postEliminacionCatalogo');
Route::post('catalogo', 'Catalogos\CatalogosController@crearCatalogo')->name('postCrearCatalogo');
Route::post('catalogo/{idCatalogo}', 'Catalogos\CatalogosController@editarCatalogo')->name('postEditarCatalogo');

/*
 * Rutas para procesos sobre Ubicacion catalogos
 */
Route::get('ubicacioncatalogo', 'Catalogos\UbicacionCatalogoController@index')->name('getUbicacionCatalogo');
Route::get('ubicacioncatalogofiltros', 'Catalogos\UbicacionCatalogoController@ubicacionCatalogoFiltrado')->name('getUbicacionCatalogoFiltrado');


/*
 * Rutas para procesos Geograficos
 */
Route::get('filtrosdepartamentos','Varios\GeograficosController@departamentosFiltrados')->name('getFiltradoDepartamentos');
Route::get('filtrosCiudades','Varios\GeograficosController@ciudadesFiltrados')->name('getFiltradoCiudades');
Route::post('pais', 'Varios\GeograficosController@crearPais')->name('postPais');
Route::post('pais/{idPais}', 'Varios\GeograficosController@editarPais')->name('putPais')->where('idPais', '[0-9]+');
Route::post('pais/eliminacion/{idPais}', 'Varios\GeograficosController@eliminarPais')->name('delPais')->where('idPais', '[0-9]+');

Route::post('departamento', 'Varios\GeograficosController@crearDepartamento')->name('postDepartamento');
Route::post('departamento/{idDepto}', 'Varios\GeograficosController@editarDepartamento')->name('putDepartamento')->where('idDepto', '[0-9]+');
Route::post('departamento/eliminacion/{idDepto}', 'Varios\GeograficosController@eliminarDepartamento')->name('delDepartamento')->where('idDepto', '[0-9]+');

Route::post('ciudad', 'Varios\GeograficosController@crearCiudad')->name('postCiudad');
Route::post('ciudad/{idCiudad}', 'Varios\GeograficosController@editarCiudad')->name('putCiudad')->where('idCiudad', '[0-9]+');
Route::post('ciudad/eliminacion/{idCiudad}', 'Varios\GeograficosController@eliminarCiudad')->name('delCiudad')->where('idCiudad', '[0-9]+');


/*
 * Rutas configuraciones del sistema
 */
Route::get('configuraciones', function(){
    return view('20_varios.inicioVarios');
})->name('getConfiguraciones');

Route::get('inicioUsuario', function () {
    return view('inicio');
})->name('inicioUsuario');


Route::get('miInfo', function(){
    abort(500, 'HOLA LA');
    dd(Auth::user());
});