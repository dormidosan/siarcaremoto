<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeticionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peticiones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('estado_peticion_id');
            $table->unsignedInteger('periodo_id')->nullable();
            $table->string('codigo', 10)->nullable();
            //$table->string('nombre', 45)->nullable();
            $table->string('descripcion', 45)->nullable();
            $table->string('peticionario', 45)->nullable();
            $table->dateTime('fecha')->nullable();
            $table->string('correo', 45)->nullable();
            $table->string('telefono', 9)->nullable();
            $table->string('direccion', 45)->nullable();
            $table->boolean('resuelto')->nullable();
            $table->boolean('agendado')->nullable();
            $table->boolean('asignado_agenda')->nullable();
            $table->boolean('comision')->nullable();

            $table->index(["estado_peticion_id"], 'fk_peticiones_estado_peticiones1_idx');

            $table->index(["periodo_id"], 'fk_peticiones_periodos1_idx');


            $table->foreign('estado_peticion_id', 'fk_peticiones_estado_peticiones1_idx')
                ->references('id')->on('estado_peticiones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('periodo_id', 'fk_peticiones_periodos1_idx')
                ->references('id')->on('periodos')
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
        Schema::drop('peticiones');
    }
}


       