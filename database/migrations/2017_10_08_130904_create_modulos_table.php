<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre_modulo', 50)->nullable();
            $table->string('url', 50)->nullable();
            $table->unsignedInteger('modulo_padre')->nullable();
            //$table->unsignedInteger('orden');
            $table->string('icono', 50)->nullable();
            $table->boolean('tiene_hijos');
            $table->index(["modulo_padre"], 'fk_modulo_padre_idx');

            $table->foreign('modulo_padre', 'fk_modulo_padre_idx')
                ->references('id')->on('modulos')
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
        Schema::drop('modulos');
    }
}
