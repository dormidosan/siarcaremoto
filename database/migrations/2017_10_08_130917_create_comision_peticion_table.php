<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComisionPeticionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_peticion', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('comision_id');
            $table->unsignedInteger('peticion_id');

            $table->index(["peticion_id"], 'fk_comision_peticion_peticiones1_idx');

            $table->index(["comision_id"], 'fk_comision_peticion_comisiones1_idx');


            $table->foreign('comision_id', 'fk_comision_peticion_comisiones1_idx')
                ->references('id')->on('comisiones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('peticion_id', 'fk_comision_peticion_peticiones1_idx')
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
        Schema::drop('comision_peticion');
    }
}
