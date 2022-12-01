<?php

namespace App\Http\Controllers;


use App\Models\ConsultaSQL;
use App\Models\Estudio;
use App\Models\Imagen;
use App\Models\Paciente;
use App\Models\Perfil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfiles=Perfil::getActive();
        if(count($perfiles)==0){
            return response()->json(['status'=>"error", "data"=>"No se encontraron registro con el registro seleccionado"]);
        }
        return response()->json(['status'=>"success", "data"=>$perfiles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perfil=Perfil::find($id);
        if(empty($perfil)){
            return response()->json(['status'=>"error", "data"=>"No se encontraron registro con el registro seleccionado"]);
        }
        return response()->json(['status'=>"success", "data"=>$perfil]);
    }






}
