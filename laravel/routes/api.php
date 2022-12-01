<?php

use App\Http\Controllers\AutorizacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('solicitudes')->group(function () {
    Route::get('/',        [SolicitudController::class, 'index']);
    Route::get('/aprobadas',        [SolicitudController::class, 'getAprobados']);
    Route::post('/crear', [SolicitudController::class, 'store']);
    Route::post('/estado', [SolicitudController::class, 'estadoSolicitud']);
    Route::get('/{id}', [SolicitudController::class, 'show']);
});

Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::post('/register', [UsuarioController::class, 'store']);
    Route::post('/perfil', [UsuarioController::class, 'perfil']);
    Route::post('/update', [UsuarioController::class, 'update']);
    Route::post('/login', [UsuarioController::class, 'login']);
    Route::post('/logout', [UsuarioController::class, 'logout']);
    Route::get('/{id}', [UsuarioController::class, 'show']);
    Route::get('/cambiar/estado/{id}', [UsuarioController::class, 'cambiarEstado']);
});

Route::prefix('perfiles')->group(function () {
    Route::get('/', [PerfilController::class, 'index']);
});

Route::prefix('documentos')->group(function () {
    Route::post('/cargar', [DocumentoController::class, 'store']);
});
