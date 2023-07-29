<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuatrimoto extends Model
{
    use HasFactory;

    protected $table = 'motos';
    protected $primaryKey='id';
    
    // protected $with = ['rentas'];

    protected $fillable=[
        'id',
        'marca',
        'color',
        'placa',
        'estado',
    ];
    public function rentas()
    {
        return $this->belongsToMany(Renta::class, 'id_renta','id');
    }
    
}
