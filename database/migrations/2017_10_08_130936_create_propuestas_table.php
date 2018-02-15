<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuestas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('punto_id');
            $table->unsignedInteger('asambleista_id');
            $table->string('nombre_propuesta', 254)->nullable();
            $table->smallInteger('favor')->nullable();
            $table->smallInteger('contra')->nullable();
            $table->smallInteger('abstencion')->nullable();
            $table->smallInteger('nulo')->nullable();
            $table->smallInteger('ronda')->nullable();
            $table->boolean('activa')->nullable();
            $table->boolean('votado')->nullable();
            $table->smallInteger('pareja')->nullable();
            $table->smallInteger('ganadora')->nullable();

            $table->index(["punto_id"], 'fk_propuestas_puntos1_idx');
            $table->index(["asambleista_id"], 'fk_propuestas_asambleistas1_idx');


            $table->foreign('punto_id', 'fk_propuestas_puntos1_idx')
                ->references('id')->on('puntos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('asambleista_id', 'fk_propuestas_asambleistas1_idx')
            ->references('id')->on('asambleistas')
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
        Schema::drop('propuestas');
    }
}
