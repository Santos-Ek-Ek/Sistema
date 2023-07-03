<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuatrimoto;

class CuatrimotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $cuatri=Cuatrimoto::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cuatri=new Cuatrimoto();
        $cuatri->id=$request->get('id_cuatri');
        $cuatri->color=$request->get('color');
        $cuatri->marca=$request->get('marca');
        $cuatri->placa=$request->get('placa');
        $cuatri->estado=$request->get('estado');

        $cuatri->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $cuatri=Cuatrimoto::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cuatri=Cuatrimoto::find($id);
        $cuatri->id=$request->get('id_cuatri');
        $cuatri->color=$request->get('color');
        $cuatri->marca=$request->get('marca');
        $cuatri->placa=$request->get('placa');
        $cuatri->estado=$request->get('estado');

        $cuatri->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cuatri=Cuatrimoto::find($id);
        $cuatri->delete();
    }
}
