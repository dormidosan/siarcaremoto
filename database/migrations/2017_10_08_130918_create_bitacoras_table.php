<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('accion', 45)->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->string('comentario', 254)->nullable();
            $table->timestamps();


            $table->index(["user_id"], 'fk_bitacoras_users1_idx');

            $table->foreign('user_id', 'fk_bitacoras_users1_idx')
                ->references('id')->on('users')
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
        Schema::drop('bitacoras');
    }
}
