<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    public $table='solicitudes';

    protected $appends = ['full_name'];

    protected $fillable = [
        'nombres',
        'apellidos',
        'num_doc',
        'sexo',
        'fecha_nac',
        'correo',
        'telefono',
        'empresa',
        'orden_visita',
        'arl',
        'eps',
        'pension',
        'estado_solicitud',
        'motivo',
        'estado',
    ];

    public function getFullNameAttribute() // Obtener el Nombre Completo
    {
        return $this->nombres . ' ' . $this->apellidos;
    }


    public static function getActive(){
        return Solicitud::where('estado', 'ACTIVO')->get();
    }

    public static function getAprobados(){
        return Solicitud::where('estado_solicitud', 'APROBAR')->get();
    }

}
