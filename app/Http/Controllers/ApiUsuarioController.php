<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Redirect;
use Cache;
use Cookie;

class ApiUsuarioController extends Controller
{
    public function validar(Request $request){
    	$usuario = $request->name;
    	$password = $request->password;

    	$resp = User::where('name','=',$usuario)
        ->where('password','=',$password)
        ->get();

    	if(count($resp)>0)
    	{
    		$usuario = $resp[0]->name;
    		Session::put('nombre',$usuario);
    		// // Session::put('rol',$resp[0]->rol->rol);
    		// Session::put('id',$resp[0]->id);
    		// if($resp[0]->rol->rol == "Psicólogo"){
    			return Redirect::to('home');
    		// }
    		// else if($resp[0]->rol->rol == "Maestro"){
    		// 	return Redirect::to('comentario');
    		// }
    	}
    	else{
            print("Usuario no encontrado");
    		// return Redirect::to('error');
    	}

    }

    public function salir(){
    	Session::flush();
 		Session::reflash();
 		Cache::flush();
 		Cookie::forget('laravel_session');
 		unset($_COOKIE);
 		unset($_SESSION);
 		return Redirect::to('/iniciar');
    }
}