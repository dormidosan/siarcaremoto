<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('agenda_id');
            $table->unsignedInteger('peticion_id')->nullable();
            $table->string('descripcion', 45)->nullable();
            $table->smallInteger('numero')->nullable();
            $table->char('romano', 4)->nullable();
            $table->boolean('activo')->nullable();
            $table->boolean('retirado')->nullable();

            $table->index(["peticion_id"], 'fk_puntos_peticiones1_idx');

            $table->index(["agenda_id"], 'fk_puntos_agendas1_idx');


            $table->foreign('agenda_id', 'fk_puntos_agendas1_idx')
                ->references('id')->on('agendas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('peticion_id', 'fk_puntos_peticiones1_idx')
                ->references('id')->on('peticiones')
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
        Schema::drop('puntos');
    }
}
