<?php

namespace App\Http\Controllers;

use App\Models\Renta;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cuatrimoto;


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
        // Obtén la cantidad de cuatrimotos a rentar
        $cantidad = $request->input('cantidad');
    
        // Verifica si hay suficientes cuatrimotos disponibles
        $cuatrimotosDisponibles = Cuatrimoto::where('estado', 'Disponible')->take($cantidad)->get();
        if ($cuatrimotosDisponibles->count() < $cantidad) {
            return redirect()->back()->withInput()->withErrors(['cantidad' => 'No hay suficientes cuatrimotos disponibles']);
        }
    
        // Cambia el estado de las cuatrimotos a "En renta" y asigna el ID de la renta a cada una
        $renta = new Renta();
        $renta->hora_inicio = $request->get('hora_inicio');
        $renta->hora_fin = $request->get('hora_fin');
        $renta->cantidad = $request->get('cantidad');
        $renta->costo = $request->get('costo');
        $renta->no_cuatri = $request->get('no_cuatri');
        $renta->est='En renta';
        $renta->save();
        foreach ($cuatrimotosDisponibles as $cuatrimoto) {
            $cuatrimoto->estado = 'En renta';
           
            $cuatrimoto->id_renta = $renta->id; // Asigna el ID de la renta a la cuatrimoto
            $cuatrimoto->save();
        }
    
        // Crear o actualizar el cliente si es necesario
        $cliente = Cliente::findOrNew($request->get('id_cliente'));
        $cliente->Nombre = $request->get('Nombre');
        $cliente->Apellido = $request->get('Apellido');
        $cliente->telefono = $request->get('telefono');
        $cliente->email = $request->get('email');
        $cliente->Documento = $request->get('Documento');
        $cliente->integrante = $request->get('integrante');
        $cliente->edad = $request->get('edad');

        $cliente->save();
    
        // Asociar el cliente a la renta
        $renta->id_cliente = $cliente->getKey();
        $renta->save();
    
        // Asociar las cuatrimotos seleccionadas a la renta
        $cuatrimotosIds = $request->get('motos');
        $renta->cuatrimotos()->attach($cuatrimotosIds);
    
        // Redireccionar u ofrecer alguna respuesta en caso de éxito
        // ...
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
        $cliente->edad=$request->get('edad');
        $cliente->Documento=$request->get('Documento');
        $cliente->No_cuatri=$request->get('No_cuatri');
        $cliente->integrante=$request->get('integrante');

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
