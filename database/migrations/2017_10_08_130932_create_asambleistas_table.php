<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsambleistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asambleistas', function (Blueprint $table) {
                       $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('periodo_id');
            $table->unsignedInteger('facultad_id');
            $table->unsignedInteger('sector_id');
            $table->string('propietario', 10)->nullable();
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();
            $table->integer('activo')->nullable();
            $table->integer('baja')->nullable();
            $table->string('ruta', 45)->nullable();

            $table->index(["facultad_id"], 'fk_asambleistas_facultades1_idx');

            $table->index(["user_id"], 'fk_asambleistas_users1_idx');

            $table->index(["periodo_id"], 'fk_asambleistas_periodos1_idx');

            $table->index(["sector_id"], 'fk_asambleistas_sectores1_idx');


            $table->foreign('user_id', 'fk_asambleistas_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('periodo_id', 'fk_asambleistas_periodos1_idx')
                ->references('id')->on('periodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('facultad_id', 'fk_asambleistas_facultades1_idx')
                ->references('id')->on('facultades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sector_id', 'fk_asambleistas_sectores1_idx')
                ->references('id')->on('sectores')
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
        Schema::drop('asambleistas');
    }
}
