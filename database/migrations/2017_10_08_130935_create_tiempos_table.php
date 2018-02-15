<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiemposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiempos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('asistencia_id');
            $table->unsignedInteger('estado_asistencia_id');
            $table->Time('entrada')->nullable();
            $table->Time('salida')->nullable();
            $table->boolean('tiempo_propietario')->nullable();

            $table->index(["estado_asistencia_id"], 'fk_tiempos_estado_asistencia1_idx');
            $table->index(["asistencia_id"], 'fk_tiempos_asistencia1_idx');

            $table->foreign('estado_asistencia_id', 'fk_asistencias_estado_asistencia1_idx')
                ->references('id')->on('estado_asistencias')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('asistencia_id', 'fk_tiempos_asistencia1_idx')
                ->references('id')->on('asistencias')
                ->onDelete('no action')
                ->onUpdate('no action');

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
        Schema::drop('tiempos');
    }
}
