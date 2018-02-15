<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('cargo_id');
            $table->unsignedInteger('reunion_id');
            $table->dateTime('entrada')->nullable();
			$table->timestamps();

            $table->index(["cargo_id"], 'fk_presentes_cargos1_idx');

            $table->index(["reunion_id"], 'fk_presentes_reuniones1_idx');


            $table->foreign('cargo_id', 'fk_presentes_cargos1_idx')
                ->references('id')->on('cargos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('reunion_id', 'fk_presentes_reuniones1_idx')
                ->references('id')->on('reuniones')
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
        Schema::drop('presentes');
    }
}
