<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    public $table='perfiles';

    protected $fillable = [
        'nombre',
        'estado',
    ];

    public static function getActive(){
        return Perfil::where('estado', 'ACTIVO')->get();
    }


}
