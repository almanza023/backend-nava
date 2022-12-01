<?php

namespace App\Http\Controllers;



use App\Models\Documento;
use Illuminate\Http\Request;


class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Crear un carpeta con el ID de la solicitud para almacenar todos los documentos
        \Storage::makeDirectory($request->solicitud_id);
        $patch1=$request->solicitud_id.'/';

        //Carga de Archivo
        $nombre= \Storage::disk('public')->put($patch1,  $request->archivo);
        $ruta=env('APP_URL').'/laravel/public/'.$nombre;
            if(!empty($ruta)){
                Documento::create([
                    'solicitud_id'=>$request->solicitud_id,
                    'nombre'=>$request->nombre,
                    'ruta'=>$ruta,
                    ]);
            return response()->json(['status'=>"success", "data"=>"Documento Cargado Exitosamente"]);
            }else{
                return response()->json(['status'=>"error", "data"=>""]);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $documentos=Documento::getDocumentosSolicitud($id);
        if(count($documentos)==0){
            return response()->json(['status'=>"error", "data"=>"No se encontraron registro con el registro seleccionado"]);
        }
        return response()->json(['status'=>"success", "data"=>$documentos]);
    }






}
