<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $table = 'precios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'persona_cuatrimoto',
        'costo'
    ];

}
