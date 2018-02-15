<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Carbon\Carbon;

class CargosTableSeeder extends Seeder
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
        $i = 1;
        $p = 1;

        \DB::table('cargos')->insert(array(
            'comision_id' => '1',
            'asambleista_id' => '1',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'cargo' => "Presidente",
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('cargos')->insert(array(
            'comision_id' => '1',
            'asambleista_id' => '2',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'cargo' => "Vice Presidente",
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('cargos')->insert(array(
            'comision_id' => '1',
            'asambleista_id' => '2',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'cargo' => "Secretario JD",
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        for ($j = 4; $j < 6; $j++) {

            \DB::table('cargos')->insert(array(
                'comision_id' => '1',
                'asambleista_id' => $j,
                'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
                'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
                'cargo' => "Vocal",
                'activo' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

        }

        \DB::table('cargos')->insert(array(
            'comision_id' => '2',
            'asambleista_id' => '11',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'cargo' => "Coordinador",
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('cargos')->insert(array(
            'comision_id' => '2',
            'asambleista_id' => '12',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'cargo' => "Secretario",
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        for ($j = 45; $j < 55; $j++) {

            \DB::table('cargos')->insert(array(
                'comision_id' => '2',
                'asambleista_id' => $j,
                'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
                'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
                'cargo' => "Asambleista",
                'activo' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

        }


    }
}
