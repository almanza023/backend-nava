<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('num_doc');
            $table->date('fecha_nac');
            $table->string('correo');
            $table->string('telefono');
            $table->string('empresa');
            $table->string('orden_visita');
            $table->string('arl');
            $table->string('eps');
            $table->string('pension');
            $table->string('estado_solicitud')->default("CREADA");
            $table->string('motivo')->nullable();
            $table->string('estado')->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
