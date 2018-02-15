<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre_documento', 45)->nullable();
            $table->unsignedInteger('tipo_documento_id');
            $table->unsignedInteger('periodo_id');
            $table->dateTime('fecha_ingreso')->nullable();
            $table->string('path', 45)->nullable();

            $table->index(["tipo_documento_id"], 'fk_documentos_tipo_documentos1_idx');

            $table->index(["periodo_id"], 'fk_documentos_periodos1_idx');


            $table->foreign('tipo_documento_id', 'fk_documentos_tipo_documentos1_idx')
                ->references('id')->on('tipo_documentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('periodo_id', 'fk_documentos_periodos1_idx')
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
        Schema::drop('documentos');
    }
}
