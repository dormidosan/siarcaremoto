<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisiones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('codigo', 5)->nullable();
            $table->string('nombre', 50)->nullable();
            $table->boolean('permanente')->nullable();
            $table->string('descripcion', 50)->nullable();
            $table->boolean('activa')->nullable();
            $table->boolean('especial')->nullable();
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
        Schema::drop('comisiones');
    }
}
