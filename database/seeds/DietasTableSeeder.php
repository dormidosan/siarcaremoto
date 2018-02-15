<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Carbon\Carbon;

class DietasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        $faker = Faker::create();
        $i=1;
        $p=1;
    	for($j = 1 ; $j < 141 ; $j ++){

    	\DB::table('dietas')->insert(array (
		'asambleista_id'  => $j,
		'mes'  => "noviembre",
		'asistencia'  => $faker->numberBetween($min = 0, $max = 4), // 8567,
		'junta_directiva'  => '0',
		'anio'  => "2016",
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('dietas')->insert(array (
		'asambleista_id'  => $j,
		'mes'  => "diciembre",
		'asistencia'  => $faker->numberBetween($min = 0, $max = 4), // 8567,
		'junta_directiva'  => '0',
		'anio'  => "2016",
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));


    	\DB::table('dietas')->insert(array (
		'asambleista_id'  => $j,
		'mes'  => "marzo",
		'asistencia'  => $faker->numberBetween($min = 0, $max = 4), // 8567,
		'junta_directiva'  => '0',
		'anio'  => "2017",
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

    	\DB::table('dietas')->insert(array (
		'asambleista_id'  => $j,
		'mes'  => "abril",
		'asistencia'  => $faker->numberBetween($min = 0, $max = 4), // 8567,
		'junta_directiva'  => '0',
		'anio'  => "2017",
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));





    	}

    	for($j = 141 ; $j < 145 ; $j ++){

    	\DB::table('dietas')->insert(array (
		'asambleista_id'  => $j,
		'mes'  => "noviembre",
		'asistencia'  => $faker->numberBetween($min = 3, $max = 8), // 8567,
		'junta_directiva'  => '1',
		'anio'  => "2016",
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('dietas')->insert(array (
		'asambleista_id'  => $j,
		'mes'  => "diciembre",
		'asistencia'  => $faker->numberBetween($min = 3, $max = 8), // 8567,
		'junta_directiva'  => '1',
		'anio'  => "2016",
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));


    	\DB::table('dietas')->insert(array (
		'asambleista_id'  => $j,
		'mes'  => "marzo",
		'asistencia'  => $faker->numberBetween($min = 3, $max = 8), // 8567,
		'junta_directiva'  => '1',
		'anio'  => "2017",
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

    	\DB::table('dietas')->insert(array (
		'asambleista_id'  => $j,
		'mes'  => "abril",
		'asistencia'  => $faker->numberBetween($min = 3, $max = 8), // 8567,
		'junta_directiva'  => '1',
		'anio'  => "2017",
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		



    	}











    }
}
