<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReunionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reuniones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('comision_id');
            $table->unsignedInteger('periodo_id');
            $table->string('codigo', 15)->nullable();
            
            $table->string('lugar', 30)->nullable();
            $table->dateTime('convocatoria')->nullable();

            $table->dateTime('inicio')->nullable();
            $table->dateTime('fin')->nullable();
            $table->boolean('vigente')->nullable();
            $table->boolean('activa')->nullable();


            $table->index(["comision_id"], 'fk_bitacora_comision_comisiones1_idx');

            $table->index(["periodo_id"], 'fk_reuniones_periodos1_idx');


            $table->foreign('comision_id', 'fk_bitacora_comision_comisiones1_idx')
                ->references('id')->on('comisiones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('periodo_id', 'fk_reuniones_periodos1_idx')
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
        Schema::drop('reuniones');
    }
}
