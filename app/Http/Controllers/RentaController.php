<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Renta;
use App\Models\Cuatrimoto;
use DB;

class RentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $renta=Renta::all();
        //  return view('rentas.blade.php', compact('renta')); 
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
    
        // Obtén las cuatrimotos en renta asociadas a la renta actual
        $cuatrimotosEnRenta = $renta->motos;
    
        // Verifica si hay suficientes cuatrimotos disponibles
        $cuatrimotosDisponibles = Cuatrimoto::where('estado', 'Disponible')->take($cantidad)->get();
        if ($cuatrimotosDisponibles->count() < $cantidad) {
            return redirect()->back()->withInput()->withErrors(['cantidad' => 'No hay suficientes cuatrimotos disponibles']);
        }
    
        if ($cuatrimotosEnRenta) {
            // Cambia el estado de todas las cuatrimotos en renta a "Disponible" primero
            Cuatrimoto::whereIn('id', $cuatrimotosEnRenta->pluck('id'))->update([
                'estado' => 'Disponible',
                'id_renta' => null
            ]);
        }
    
        // Cambia el estado de las cuatrimotos a "En renta" según la nueva cantidad
        $cuatrimotosSeleccionadas = $cuatrimotosDisponibles->take($cantidad);
        Cuatrimoto::whereIn('id', $cuatrimotosSeleccionadas->pluck('id'))->update([
            'estado' => 'En renta',
            'id_renta' => $renta->id
        ]);
        // if ($renta->motos->isNotEmpty()) {
        //     $confirmacion = confirm('¿Estás seguro de cambiar el estado de la cuatrimoto en renta? Esto afectará la cantidad de la renta.');
        //     if (!$confirmacion) {
        //         return redirect()->back();
        //     }
        // }
    
        // Actualiza los demás datos de la renta
        $renta->cliente = $request->get('cliente');
        $renta->hora_inicio = $request->get('hora_inicio');
        $renta->hora_fin = $request->get('hora_fin');
        $renta->cantidad = $request->get('cantidad');
        $renta->costo = $request->get('costo');
        $renta->no_cuatri = $request->get('no_cuatri');
        $renta->est ='En renta';
        $renta->update();
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encuentra la renta que se va a eliminar
        $renta = Renta::find($id);
    
        // Verifica si la renta existe antes de continuar
        if ($renta) {
            // Obtén las cuatrimotos en renta asociadas a la renta que se va a eliminar
            $cuatrimotosEnRenta = $renta->motos;
    
            // Cambia el estado de todas las cuatrimotos en renta a "Disponible" y elimina la referencia a la renta
            foreach ($cuatrimotosEnRenta as $cuatrimoto) {
                $cuatrimoto->estado = 'Disponible';
                $cuatrimoto->id_renta = null;
                $cuatrimoto->save(); // Utiliza "save()" en lugar de "update()" para que los eventos Eloquent se ejecuten correctamente
            }
    
            // Finalmente, elimina la renta
            $renta->delete();
        }
    }
    
    public function finalizarRenta($id)
    {
        // Encuentra la renta por su ID
        $renta = Renta::find($id);
    
        // Verifica si la renta existe antes de continuar
        if (!$renta) {
            return response()->json(['message' => 'Renta no encontrada'], 404);
        }
    
        // Obtén las cuatrimotos en renta asociadas a la renta actual
        $cuatrimotosEnRenta = $renta->motos;
    
        // Cambia el estado de todas las cuatrimotos en renta a "Disponible" y elimina la referencia a la renta
        foreach ($cuatrimotosEnRenta as $cuatrimoto) {
            $cuatrimoto->estado = 'Disponible';
            $cuatrimoto->id_renta = null;
            $cuatrimoto->update();
        }
    
        // Cambia el estado de la renta a "Finalizado"
        $renta->est = 'Finalizado';
        $renta->save();
    
        // Finaliza la renta (puedes agregar más lógica si es necesario)
    
        return response()->json(['message' => 'Renta finalizada exitosamente']);
    }
    

    
}
