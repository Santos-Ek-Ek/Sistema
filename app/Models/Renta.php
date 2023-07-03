<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    use HasFactory;
    protected $table = 'rentas';
    protected $primaryKey='id';

    protected $fillable=[
        'id',
        'id_cliente',
        // 'cliente',
        'hora_inicio',
        'hora_fin',
        'cantidad',
        'costo'
    ];
}
