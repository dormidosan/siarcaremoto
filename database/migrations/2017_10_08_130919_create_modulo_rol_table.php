<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuloRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulo_rol', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('rol_id');
            $table->unsignedInteger('modulo_id');

            $table->index(["modulo_id"], 'fk_modulo_rol_modulos1_idx');

            $table->index(["rol_id"], 'fk_modulo_rol_roles1_idx');


            $table->foreign('rol_id', 'fk_modulo_rol_roles1_idx')
                ->references('id')->on('roles')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('modulo_id', 'fk_modulo_rol_modulos1_idx')
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
        Schema::drop('modulo_rol');
    }
}
