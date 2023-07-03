<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Renta;

class RentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $renta=Renta::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $renta=new Renta();
        $renta->id=$request->get('id');
        $renta->cliente=$request->get('nombreCliente');
        $renta->hora_inicio=$request->get('hora_inicio');
        $renta->hora_fin=$request->get('hora_fin');
        $renta->cantidad=$request->get('cantidad');
        $renta->costo=$request->get('costo');

        $renta->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $renta=Renta::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $renta=Renta::find($id);
        $renta->cliente=$request->get('cliente');
        $renta->hora_inicio=$request->get('hora_inicio');
        $renta->hora_fin=$request->get('hora_fin');
        $renta->cantidad=$request->get('cantidad');
        $renta->costo=$request->get('costo');

        $renta->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $renta=Renta::find($id);
        $renta->delete();
    }
}
