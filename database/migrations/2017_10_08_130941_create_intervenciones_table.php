<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntervencionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervenciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('punto_id');
            $table->unsignedInteger('asambleista_id');
            $table->text('descripcion')->nullable();

            $table->index(["punto_id"], 'fk_intervenciones_puntos1_idx');
            $table->index(["asambleista_id"], 'fk_intervenciones_asambleistas1_idx');


            $table->foreign('punto_id', 'fk_intervenciones_puntos1_idx')
                ->references('id')->on('puntos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('asambleista_id', 'fk_intervenciones_asambleistas1_idx')
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
        Schema::drop('intervenciones');
    }
}
