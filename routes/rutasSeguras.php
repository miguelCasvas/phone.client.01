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
# Actualizacion contraseña usuarios
Route::put('usuario/{idUsuario}/contrasenia', 'Usuarios\UsuariosController@actualizarContrasenia')->name('putUsuarioPW');
# asociar extension con usuario
Route::post('usuario/{idUsuario}/extension', 'Usuarios\UsuariosController@relacionUsuarioExtension')->name('postUsuarioExten');
Route::delete('usuario/{idUsuario}/extension/{idExtension}', 'Usuarios\UsuariosController@eliminarRelExtension')->name('delUsuarioExten');
# Actualizacion info usuarios por Administrador
Route::put('usuario/{idUsuario}', 'Usuarios\UsuariosController@actualizarInformacionUsuario')->name('putUsuario');
# Creación de usuarios por Administrador
Route::post('usuario', 'Usuarios\UsuariosController@crearUsuario')->name('postUsuario');

/*
 * Rutas para procesos sobre conjuntos
 */
# Rutas Conjuntos
Route::get('inicioconjuntos', 'Conjuntos\ConjuntosController@index')->name('getInicioConjuntos');

Route::get('conjunto/{idConjunto}/edicion', 'Conjuntos\ConjuntosController@vistaEdicionConjunto')->name('getEdicionConjunto')->where('idConjunto', '[0-9]+');
Route::get('conjunto/{idConjunto}/eliminacion', 'Conjuntos\ConjuntosController@eliminarConjunto')->name('getEliminarConjunto')->where('idConjunto', '[0-9]+');
Route::post('conjunto/{idConjunto}/edicion', 'Conjuntos\ConjuntosController@editarConjunto')->name('postEdicionConjunto')->where('idConjunto', '[0-9]+');
Route::post('conjunto/creacion', 'Conjuntos\ConjuntosController@crearConjunto')->name('postCreacionConjunto');

Route::get('conjuntos', 'Conjuntos\ConjuntosController@listadoConjuntos')->name('listadoConjuntos');
Route::get('conjunto/{idConjunto}', 'Conjuntos\ConjuntosController@busquedaConjunto')->name('getConjunto')->where('idConjunto', '[0-9]+');
Route::get('conjunto/{idConjunto}/extensiones', 'Conjuntos\ConjuntosController@listadoExtensionesPorConjunto')->name('getExtensionesConjunto');
Route::get('conjunto/{idConjunto}/catalogos', 'Conjuntos\ConjuntosController@renderSelectsCatalogo')->name('getSelectsCatalogosConjunto');
Route::get('conjunto/extension_ft_usuario', 'Conjuntos\ConjuntosController@listadoExtensionUsuarioPorConjunto')->name('getExtensionFtUsuarioConjunto');

/*
 * Rutas para procesos sobre canales de comunicación
 */
Route::get('canalesComunicacion', 'CanalesComunicaciones\CanalesComunicacionesController@index')->name('getModuloCC');
Route::get('canalesComunicacion/tiposSalida', 'CanalesComunicaciones\CanalesComunicacionesController@moduloTiposDeSalida')->name('getTiposSalida');
Route::post('canalesComunicacion/tiposSalida','CanalesComunicaciones\CanalesComunicacionesController@crearTipoSalida')->name('postTiposSalida');
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
Route::get('catalogos/orden', 'Catalogos\CatalogosController@ordenCatalogo')->name('getOrdenCatalogos');

/*
 * Rutas para procesos sobre Ubicacion catalogos
 */
Route::get('ubicacioncatalogo', 'Catalogos\UbicacionCatalogoController@index')->name('getUbicacionCatalogo');
Route::post('ubicacioncatalogo','Catalogos\UbicacionCatalogoController@crearUbicacionCatalogo')->name('postCrearUbicacionCatalogo');
Route::post('ubicacioncatalogo/{idUbic}','Catalogos\UbicacionCatalogoController@editarUbicacionCatalogo')->name('postUbicacionCatalogo');
Route::get('ubicacioncatalogofiltros', 'Catalogos\UbicacionCatalogoController@ubicacionCatalogoFiltrado')->name('getUbicacionCatalogoFiltrado');
Route::get('ubicacioncatalogo/orden', 'Catalogos\UbicacionCatalogoController@ordenUbicacionCatalogo')->name('getOrdenUbicacionCatalogos');

/*
 * Rutas para procesos Geograficos
 */
Route::get('filtrosdepartamentos','Varios\GeograficosController@departamentosFiltrados')->name('getFiltradoDepartamentos');
Route::get('filtrosCiudades','Varios\GeograficosController@ciudadesFiltrados')->name('getFiltradoCiudades');
Route::post('pais', 'Varios\GeograficosController@crearPais')->name('postPais');
Route::post('pais/{idPais}', 'Varios\GeograficosController@editarPais')->name('putPais')->where('idPais', '[0-9]+');
Route::post('pais/eliminacion/{idPais}', 'Varios\GeograficosController@eliminarPais')->name('delPais')->where('idPais', '[0-9]+');

/*
 * Rutas para procesos extensiones
 */
Route::get('extensionesinicio', 'Extensiones\ExtensionesController@index')->name('getInicioExtensiones');
Route::post('extensiones/eliminarelacion', 'Extensiones\ExtensionesController@eliminarRelExtensiones')->name('delRelExtensiones');
Route::post('extensiones/eliminar', 'Extensiones\ExtensionesController@eliminarExtension')->name('delExtensiones');

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

Route::get('enconstruccion', function () {
    return view('20_varios.enConstruccion');
})->name('getEnConstruccion');

/*
 * Rutas para procesos Notificaciones
 */
Route::get('inicionotificaciones', 'Notificaciones\NotificacionesController@index')->name('getInicioNotificaciones');


/*
 * Rutas para procesos MARCADOS
 * */
Route::group(['prefix' => 'marcados'],function(){

    #Inicio de MODULO
    Route::get('', 'Marcados\MarcadosController@index')->name('getInicioMarcados');
    Route::post('', 'Marcados\MarcadosController@crearMarcado')->name('postMarcado');
    Route::get('genera/orden', 'Marcados\MarcadosController@generarOrden')->name('generarOrden');
    Route::delete('{idMarcado}', 'Marcados\MarcadosController@eliminarMarcado')->name('eliminarMarcado');

}
);