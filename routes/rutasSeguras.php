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
//Route::post('usuario', 'Usuarios\UsuariosController@crearUsuario')->name('postUsuario');
Route::post('usuario', function(){
    dd('PRUEBA ESTA');
})->name('postUsuario');



Route::get('inicioUsuario', function () {
    return view('inicio');
})->name('inicioUsuario');


Route::get('miInfo', function(){

    dd(Auth::user());
});