<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('asambleista_id');
            $table->unsignedInteger('delegado_id')->nullable();
            $table->dateTime('fecha_permiso')->nullable();
            $table->string('motivo', 45)->nullable();
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();

            $table->index(["asambleista_id"], 'fk_permiso_inasistencias_asambleistas1_idx');
            $table->index(["delegado_id"], 'fk_permiso_inasistencias_delegado1_idx');

            $table->foreign('asambleista_id', 'fk_permiso_inasistencias_asambleistas1_idx')
                ->references('id')->on('asambleistas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('delegado_id', 'fk_permiso_inasistencias_delegado1_idx')
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
        Schema::drop('permisos');
    }
}
