<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoPeticionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_peticion', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('peticion_id');
            $table->unsignedInteger('documento_id');

            $table->index(["peticion_id"], 'fk_peticion_documento_peticiones1_idx');

            $table->index(["documento_id"], 'fk_peticion_documento_documentos1_idx');


            $table->foreign('peticion_id', 'fk_peticion_documento_peticiones1_idx')
                ->references('id')->on('peticiones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('documento_id', 'fk_peticion_documento_documentos1_idx')
                ->references('id')->on('documentos')
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
        Schema::drop('documento_peticion');
    }
}
