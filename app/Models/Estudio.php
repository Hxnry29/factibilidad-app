<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    protected $fillable = [
        'nombre_proyecto', 'inflacion', 'tasa_cambio', 
        'capex', 'plazo_meses', 'ingresos', 'opex', 'estado',
        'vpn', 'rcsd', 'probabilidad_ia', 'recomendacion_ia'
    ];
}
