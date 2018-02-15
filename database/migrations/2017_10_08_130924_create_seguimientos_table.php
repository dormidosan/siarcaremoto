<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimientos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('peticion_id');
            $table->unsignedInteger('comision_id');
            $table->unsignedInteger('estado_seguimiento_id');
            $table->unsignedInteger('documento_id')->nullable();
            $table->unsignedInteger('reunion_id')->nullable();
            
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();
            $table->boolean('activo')->nullable();
            $table->boolean('agendado')->nullable();
            $table->string('descripcion', 150)->nullable();

            $table->index(["comision_id"], 'fk_seguimientos_comisiones1_idx');

            $table->index(["peticion_id"], 'fk_seguimientos_peticiones1_idx');

            $table->index(["estado_seguimiento_id"], 'fk_seguimientos_estado_seguimientos1_idx');

            $table->index(["documento_id"], 'fk_seguimientos_documentos1_idx');

            $table->index(["reunion_id"], 'fk_seguimientos_reunion1_idx');


            $table->foreign('peticion_id', 'fk_seguimientos_peticiones1_idx')
                ->references('id')->on('peticiones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('comision_id', 'fk_seguimientos_comisiones1_idx')
                ->references('id')->on('comisiones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('estado_seguimiento_id', 'fk_seguimientos_estado_seguimientos1_idx')
                ->references('id')->on('estado_seguimientos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('documento_id', 'fk_seguimientos_documentos1_idx')
                ->references('id')->on('documentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('reunion_id', 'fk_seguimientos_reunion1_idx')
                ->references('id')->on('reuniones')
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
        Schema::drop('seguimientos');
    }
}
