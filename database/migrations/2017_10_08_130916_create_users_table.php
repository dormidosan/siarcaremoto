<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('persona_id');
            $table->unsignedInteger('rol_id');
            $table->string('name', 15)->nullable();
            $table->string('password', 61)->nullable();
            $table->dateTime('fecha_registro')->nullable();
            $table->dateTime('ultimo_acceso')->nullable();
            $table->string('email', 45)->nullable();
            $table->integer('activo')->nullable();
			$table->rememberToken();
            $table->timestamps();

            $table->index(["persona_id"], 'fk_users_personas_idx');

            $table->index(["rol_id"], 'fk_users_roles1_idx');


            $table->foreign('persona_id', 'fk_users_personas_idx')
                ->references('id')->on('personas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('rol_id', 'fk_users_roles1_idx')
                ->references('id')->on('roles')
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
        Schema::drop('users');
    }
}
