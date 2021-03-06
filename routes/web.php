<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('getFormularioInicioSesion');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('getFormularioInicioSesion');
Route::post('login', 'Auth\LoginController@login')->name('postFormularioInicioSesion');
Route::get('logout', 'Auth\LoginController@logout')->name('cerrarSesion');
