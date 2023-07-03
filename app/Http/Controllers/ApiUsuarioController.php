<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Redirect;
use Cache;
use Cookie;

class ApiUsuarioController extends Controller
{
    public function validar(Request $request){
// Obtén los datos de inicio de sesión (correo electrónico y contraseña) del formulario
$name = $request->input('name');
$password = $request->input('password');

// Intenta autenticar al usuario
if (Auth::attempt(['name' => $name, 'password' => $password])) {
    // La contraseña es válida y el usuario ha sido autenticado correctamente
    // Realiza las acciones necesarias, como redireccionar a la página de inicio
    return redirect()->intended('home');
} else {
    // La contraseña es incorrecta o el usuario no existe
    // Vuelve a mostrar el formulario de inicio de sesión con un mensaje de error
    return redirect()->back()->withInput()->withErrors(['password' => 'Credenciales incorrectas']);
}

    }

    public function salir(){
    	Session::flush();
 		Session::reflash();
 		Cache::flush();
 		Cookie::forget('laravel_session');
 		unset($_COOKIE);
 		unset($_SESSION);
 		return Redirect::to('/log');
    }
}