<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('Login.login');
// });
Route::get('registrar', function () {
    return view('Login.registro');
});
Route::view('error','Login.error');

Route::get('rentas', function () {
    return view('renta');
});

Route::get('home', function () {
    return view('home');
});

Route::get('clientes', function () {
    return view('clientes');
});
Route::get('/', function () {
    return view('login.iniciar');
});
Route::get('administrar', function () {
    return view('administrar');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::apiResource('apiCuatri','App\Http\Controllers\CuatrimotoController');
Route::apiResource('apiPrecio','App\Http\Controllers\PrecioController');
Route::apiResource('apiRenta','App\Http\Controllers\RentaController');
Route::apiResource('apiCliente','App\Http\Controllers\ClienteController');

// app/Http/routes.php | app/routes/web.php

Route::get('Reporte Rentas', 'App\Http\Controllers\reporteController@pdfRenta')->name('pdf');
Route::get('Reporte Cuatrimotos', 'App\Http\Controllers\reporteController@pdfCuatri')->name('pdfCuatri');
Route::get('Reporte Clientes', 'App\Http\Controllers\reporteController@pdfCliente')->name('pdfCliente');

Route::post('login','App\Http\Controllers\ApiUsuarioController@validar');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('salir','App\Http\Controllers\ApiUsuarioController@salir');


