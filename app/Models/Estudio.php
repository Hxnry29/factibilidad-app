<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\LogAuditoria;
use Illuminate\Support\Facades\Auth;

class Estudio extends Model


{
    protected $fillable = [
        'nombre_proyecto', 'inflacion', 'tasa_cambio', 
        'capex', 'plazo_meses', 'ingresos', 'opex', 'estado',
        'vpn', 'rcsd', 'probabilidad_ia', 'recomendacion_ia'
    ];

   
}

