<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versiones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('documento_id');
            $table->string('nombre_documento', 45)->nullable();
            $table->dateTime('fecha_ingreso')->nullable();
            $table->string('path', 45)->nullable();
            $table->timestamps();

            $table->index(["documento_id"], 'fk_versiones_documentos1_idx');


            $table->foreign('documento_id', 'fk_versiones_documentos1_idx')
                ->references('id')->on('documentos')
                ->onDelete('no action')
                ->onUpdate('no action');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('versiones');
    }
}
