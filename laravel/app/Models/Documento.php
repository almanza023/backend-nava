<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    public $table='documentos';

    protected $fillable = [
        'solicitud_id',
        'nombre',
        'ruta',
        'estado'
    ];

    public static function getDocumentosSolicitud($id){
        return Documento::where('solicitud_id', $id)->where('estado', 'ACTIVO')->get();
    }
}
