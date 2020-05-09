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

// Rutas de prueba
Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return '<h1> Hola con Laravel 5 </h1>';
});


Route::get('/pruebas/{nombre?}', function($nombre  = null){
    $texto = '<h2> Texto desde una ruta </h2>';
    $texto .= 'Nombre: ' . $nombre;
    
    return view('pruebas', array(
        'texto' => $texto
    ));
});

Route::get('/animales', 'PruebaController@index');
Route::get('/test-orm', 'PruebaController@testOrm');

// Rutas de API

    /* Metodos HTTP comunes
        * GET: Conseguir datos o recursos
        * POST: Guardar datos o recursos o hasta logica desde un formulario
        * PUT: Actualizar datos o recursos
        * DELETE: Eliminar datos o recursos
        Un API RestFull utilza todos estos metodos.
    */

    // Rutas de prueba
    Route::get('/usuario/pruebas', 'UserController@pruebas');
    Route::get('/categoria/pruebas', 'CategoryController@pruebas');
    Route::get('/entradas/pruebas', 'PostController@pruebas');

    // Rutas del controlador de usuarios
    Route::post('api/register', 'UserController@register');
    Route::post('api/login', 'UserController@login');