<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        if (!empty($usuarios)) {
            $data = [
                'status' => "success",
                'data' => $usuarios
            ];
        } else {
            $data = [
                'status' => "error",
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
        //Metodo para Guardar los Crear los usuarios
        try {
            $usuario = User::create([
                'name' => strtoupper($request->name),
                'user_name' => strtoupper($request->user_name),
                'email' => $request->email,
                'perfil_id' => $request->perfil_id,
                'password' => Hash::make($request->password),
            ]);
            $data = ['status' => 'success', 'data' => 'Datos registrados exitosamente'];
            return response()->json($data);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'fail', 'data' => 'Ha ocurrido un error al procesar la solicitud'], 500);
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
        $usuario = User::find($id);
        if (!empty($usuario)) {
            $data = [
                'status' => "success",
                "data" => $usuario
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => "error",
                'data'=>''
            ];
            return response()->json($data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $usuario = User::find($request->id);
            $usuario->name = strtoupper($request->name);
            $usuario->user_name = strtoupper($request->user_name);
            $usuario->email = $request->email;
            $usuario->perfil_id = $request->perfil_id;
            if (!empty($request->password)) {
                $usuario->password = Hash::make($request->password);
            }
            $usuario->save();
            $data = ['status' => 'success', 'data' => 'Datos actualizados exitosamente'];
            return response()->json($data);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    public function perfil(Request $request)
    {
        try {
            $usuario = User::find($request->id);
            $usuario->user_name = strtoupper($request->user_name);
            $usuario->email = ($request->email);
            if (!empty($request->password)) {
                $usuario->password = Hash::make($request->password);
            }
            $usuario->save();
            $data = ['status' => 'success', 'data' => 'Datos actualizados exitosamente'];
            return response()->json($data);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_name' => ['required'],
            'password' => ['required'],
            'estado' => "ACTIVO",
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $data = [
                'status' => "success",
                'user_id' => $user->id,
                'nombre' => $user->name,
                'perfil_id' => $user->perfil_id,
            ];
            return response()->json($data, Response::HTTP_OK);
        }

        return response()->json([
            'status' => 'error'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['status' => "success", 'data' => 'Logueo Exitoso']);
    }

    public function cambiarEstado($id)
    {
        $usuario = User::find($id);
        if (!empty($usuario)) {
            if ($usuario->estado == 'ACTIVO') {
                $usuario->estado = 'BLOQUEADO';
            } else {
                $usuario->estado = 'ACTIVO';
            }
            $usuario->save();
            $data = [
                'status' => "success",
                "data" => 'Cambio de Estado realizado exitosamente'
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => "error",
            ];
            return response()->json($data);
        }
    }
}
