<?php

namespace App\Http\Controllers;

use App\Models\Renta;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $cliente= Cliente::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cliente = new Cliente();
        $cliente->id=$request->get('id_cliente');
        $cliente->Nombre=$request->get('Nombre');
        $cliente->Apellido=$request->get('Apellido');
        $cliente->telefono=$request->get('telefono');
        $cliente->email=$request->get('email');
        $cliente->Documento=$request->get('Documento');
        $cliente->No_cuatri=$request->get('No_cuatri');
        $cliente->save();

        $renta = new Renta();
        $renta->hora_inicio=$request->get('hora_inicio');
        $renta->hora_fin=$request->get('hora_fin');
        $renta->cantidad=$request->get('cantidad');
        $renta->costo=$request->get('costo');
        $renta->id_cliente = $cliente->getKey();
        $renta->save();
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $cliente=Cliente::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cliente=Cliente::find($id);
        $cliente->Nombre=$request->get('Nombre');
        $cliente->Apellido=$request->get('Apellido');
        $cliente->telefono=$request->get('telefono');
        $cliente->email=$request->get('email');
        $cliente->Documento=$request->get('Documento');
        $cliente->No_cuatri=$request->get('No_cuatri');

        $cliente->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente=Cliente::find($id);
        $cliente->delete();
    }
}
