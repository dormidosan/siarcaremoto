<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoReunionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_reunion', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('documento_id');
            $table->unsignedInteger('reunion_id');

            $table->index(["reunion_id"], 'fk_documento_reunion_reuniones1_idx');

            $table->index(["documento_id"], 'fk_comision_documento_documentos1_idx');


            $table->foreign('documento_id', 'fk_comision_documento_documentos1_idx')
                ->references('id')->on('documentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('reunion_id', 'fk_documento_reunion_reuniones1_idx')
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
        Schema::drop('documento_reunion');
    }
}
