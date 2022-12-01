<?php

namespace App\Http\Controllers;

use App\Mail\SolicitudMail;
use App\Models\ConsultaSQL;
use App\Models\Documento;
use App\Models\Paciente;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitudes=Solicitud::getActive();
        if(!empty($solicitudes)){
            $data=[
                'status'=>"success",
                'data'=>$solicitudes
            ];
        }else{
            $data=[
                'status'=>"error",
                'data'=>""
            ];
        }
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $solicitud=Solicitud::create([
                'nombres'=>strtoupper($request->nombres),
                'apellidos'=>strtoupper($request->apellidos),
                'num_doc'=>$request->num_doc,
                'fecha_nac'=>$request->fecha_nac,
                'telefono'=>$request->telefono,
                'correo'=>$request->correo,
                'empresa'=>strtoupper($request->empresa),
                'orden_visita'=>$request->orden_visita,
                'arl'=>strtoupper($request->arl),
                'eps'=>strtoupper($request->eps),
                'pension'=>strtoupper($request->pension),
            ]);

            DB::commit();
            $data=[
                'status'=>"success",
                'data'=>"Datos registrados exitosamente",
                'solicitud_id'=>$solicitud->id
            ];
            return response()->json($data);

        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 500);
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
        $solicitud=Solicitud::find($id);
        if(!empty($solicitud)){
            $documentos=Documento::getDocumentosSolicitud($id);
            $data=[
                'status'=>"success",
                'data'=>$solicitud,
                'documentos'=>$documentos,
            ];
        }else{
            $data=[
                'status'=>"error",
                'data'=>''
            ];
        }
        return response()->json($data, 200);
    }

    public function estadoSolicitud(Request $request){
        $solicitud=Solicitud::find($request->solicitud_id);
        if(!empty($solicitud)){
            $solicitud->estado_solicitud=$request->estado_solicitud;
            $solicitud->motivo=$request->motivo;
            $solicitud->save();
            $data=[
                'status'=>"success",
                'data'=>"Datos Registrados Exitosamente",
            ];
            if($request->estado_solicitud=="RECHAZAR"){
                $details=[
                    'titulo'=>"ESTADO DE SOLICITUD NAVA",
                    'asunto'=>"ESTADO DE SOLICITUD NAVA",
                    'nombre'=>$solicitud->full_name,
                    'motivos'=>$solicitud->mensaje,
                    'tipo'=>2
                    ];
                    if (filter_var($solicitud->correo, FILTER_VALIDATE_EMAIL)) {
                        Mail::to($solicitud->correo)->send(new SolicitudMail($details));
                    }
            }
        }else{
            $data=[
                'status'=>"error",
                'data'=>''
            ];
        }
        return response()->json($data, 200);
    }

    public function getAprobados(){
        $solicitudes=Solicitud::getAprobados();
        if(!empty($solicitudes)){
            $data=[
                'status'=>"success",
                'data'=>$solicitudes
            ];
        }else{
            $data=[
                'status'=>"error",
                'data'=>""
            ];
        }
        return response()->json($data);
    }
}
