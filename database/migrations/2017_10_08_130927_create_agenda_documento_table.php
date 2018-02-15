<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_documento', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('documento_id');
            $table->unsignedInteger('agenda_id');

            $table->index(["documento_id"], 'fk_agenda_documento_documentos1_idx');

            $table->index(["agenda_id"], 'fk_agenda_documento_agendas1_idx');

            


            $table->foreign('documento_id', 'fk_agenda_documento_documentos1_idx')
                ->references('id')->on('documentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('agenda_id', 'fk_agenda_documento_agendas1_idx')
                ->references('id')->on('agendas')
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
        Schema::drop('agenda_documento');
    }
}
