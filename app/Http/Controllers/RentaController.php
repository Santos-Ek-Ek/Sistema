<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Renta;
use App\Models\Cuatrimoto;

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
    // public function store(Request $request)
    // {
    //     $renta=new Renta();
    //     $renta->id=$request->get('id');
    //     $renta->cliente=$request->get('nombreCliente');
    //     $renta->hora_inicio=$request->get('hora_inicio');
    //     $renta->hora_fin=$request->get('hora_fin');
    //     $renta->cantidad=$request->get('cantidad');
    //     $renta->costo=$request->get('costo');

    //     $renta->save();
    // }

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
        $renta = Renta::find($id);
        $cantidad = $request->input('cantidad');
    
        // Verifica si hay suficientes cuatrimotos disponibles
        $cuatrimotosDisponibles = Cuatrimoto::where('estado', 'Disponible')->take($cantidad)->get();
        if ($cuatrimotosDisponibles->count() < $cantidad) {
            return redirect()->back()->withInput()->withErrors(['cantidad' => 'No hay suficientes cuatrimotos disponibles']);
        }
    
        // Cambia el estado de todas las cuatrimotos a "Disponible" primero
        Cuatrimoto::where('estado', 'En renta')->update(['estado' => 'Disponible']);
    
        // Cambia el estado de las cuatrimotos a "En renta" según la nueva cantidad
        $cuatrimotosSeleccionadas = $cuatrimotosDisponibles->take($cantidad);
        foreach ($cuatrimotosSeleccionadas as $cuatrimoto) {
            $cuatrimoto->estado = 'En renta';
            $cuatrimoto->update();
        }
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
    public function destroy($id)
    {
        $renta = Renta::findOrFail($id);
        
        // Obtén las cuatrimotos asociadas a la renta
        $cuatrimotosAsociadas = $renta->cuatrimotos;
       
    
        // Cambia el estado de las cuatrimotos asociadas a "Disponible"
        foreach ($cuatrimotosAsociadas as $cuatrimoto) {
            $cuatrimoto->estado = 'Disponible';
            $cuatrimoto->save();
        }
        $renta->delete();
    }
}
