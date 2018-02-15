<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('comision_id');
            $table->unsignedInteger('asambleista_id');
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();
            $table->string('cargo', 15)->nullable();
            $table->boolean('activo')->nullable();

            $table->index(["asambleista_id"], 'fk_asambleista_comision_asambleistas1_idx');

            $table->index(["comision_id"], 'fk_asambleista_comision_comisiones1_idx');


            $table->foreign('comision_id', 'fk_asambleista_comision_comisiones1_idx')
                ->references('id')->on('comisiones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('asambleista_id', 'fk_asambleista_comision_asambleistas1_idx')
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
        Schema::drop('cargos');
    }
}
