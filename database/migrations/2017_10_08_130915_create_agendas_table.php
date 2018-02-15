<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('periodo_id');
            $table->string('codigo',15)->nullable();
            $table->date('fecha')->nullable();
            $table->string('lugar', 30)->nullable();
            $table->boolean('trascendental')->nullable();
            $table->boolean('vigente')->nullable();
            $table->dateTime('inicio')->nullable();
            $table->dateTime('fin')->nullable();
            $table->boolean('activa')->nullable();
            $table->boolean('fijada')->nullable();

            $table->index(["periodo_id"], 'fk_agendas_periodos1_idx');


            $table->foreign('periodo_id', 'fk_agendas_periodos1_idx')
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
        Schema::drop('agendas');
    }
}
