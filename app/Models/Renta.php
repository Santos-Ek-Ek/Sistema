<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    use HasFactory;
    protected $table = 'rentas';
    protected $primaryKey='id';
    protected $with = ['clientes'];
    

    protected $fillable=[
        'id',
        'id_cliente',
        // 'cliente',
        'hora_inicio',
        'hora_fin',
        'cantidad',
        'costo',
        'no_cuatri'
    ];

    public function clientes(){
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }
    public function cuatrimotos()
    {
        return $this->belongsToMany(Cuatrimoto::class, 'id', 'id_renta');
    }

    public function motos()
{
    return $this->hasMany(Cuatrimoto::class, 'id_renta', 'id');
}
}
