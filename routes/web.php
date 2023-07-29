<?php

use App\Http\Controllers\reporteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Cuatrimoto;

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
})->middleware('auth');

Route::get('home', function () {
    return view('home');
})->middleware('auth');

Route::get('clientes', function () {
    return view('clientes');
})->middleware('auth');
Route::get('/', function () {
    return view('login.iniciar');
})->name('login');
Route::get('administrar', function () {
    return view('administrar');
})->middleware('auth');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::apiResource('apiCuatri','App\Http\Controllers\CuatrimotoController');
Route::apiResource('apiPrecio','App\Http\Controllers\PrecioController');
Route::apiResource('apiRenta','App\Http\Controllers\RentaController');
Route::apiResource('apiCliente','App\Http\Controllers\ClienteController');

// app/Http/routes.php | app/routes/web.php

Route::get('Reporte Rentas', 'App\Http\Controllers\reporteController@pdfRenta')->name('pdf');
Route::get('Reporte Cuatrimotos', 'App\Http\Controllers\reporteController@pdfCuatri')->name('pdfCuatri');
Route::get('Reporte Clientes', 'App\Http\Controllers\reporteController@pdfCliente')->name('pdfCliente');
Route::get('ticket','App\Http\Controllers\reporteController@ticket')->name('ticket');


Route::post('login','App\Http\Controllers\ApiUsuarioController@validar');
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('salir','App\Http\Controllers\ApiUsuarioController@salir');


Route::get('api/cuatrimotos/disponibles', 'App\Http\Controllers\CuatrimotoController@obtenerCuatrimotosDisponibles');
Route::get('cuatrimotos/dis', 'App\Http\Controllers\CuatrimotoController@obtenerCuatrimotosDis');
Route::get('cuatrimotos/en_renta', 'App\Http\Controllers\CuatrimotoController@obtenerCuatrimotosRentas');


