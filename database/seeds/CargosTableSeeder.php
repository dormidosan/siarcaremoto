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

        \DB::table('tipo_cargos')->insert(array(
            'cargo' => 'pre',
            'nombre_cargo' => "Presidente",
            'grupo' => 'jd',
        ));

        \DB::table('tipo_cargos')->insert(array(
            'cargo' => 'vpr',
            'nombre_cargo' => "Vice Presidente",
            'grupo' => "jd",
        ));

        \DB::table('tipo_cargos')->insert(array(
            'cargo' => 'sjd',
            'nombre_cargo' => "Secretario JD",
            'grupo' => "jd",
        ));

        \DB::table('tipo_cargos')->insert(array(
            'cargo' => 'vo1',
            'nombre_cargo' => "Vocal 1",
            'grupo' => "jd",
        ));

        \DB::table('tipo_cargos')->insert(array(
            'cargo' => 'vo2',
            'nombre_cargo' => "Vocal 2",
            'grupo' => "jd",
        ));

        \DB::table('tipo_cargos')->insert(array(
            'cargo' => 'sc',
            'nombre_cargo' => "Sin Cargo",
            'grupo' => "jd",
        ));

        \DB::table('tipo_cargos')->insert(array(
            'cargo' => 'coo',
            'nombre_cargo' => "Coordinador",
            'grupo' => "co",
        ));

        \DB::table('tipo_cargos')->insert(array(
            'cargo' => 'sec',
            'nombre_cargo' => "Secretario",
            'grupo' => "co",
        ));

        \DB::table('tipo_cargos')->insert(array(
            'cargo' => 'asa',
            'nombre_cargo' => "Asambleista",
            'grupo' => "co",
        ));


        \DB::table('cargos')->insert(array(
            'comision_id' => '1',
            'asambleista_id' => '1',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'tipo_cargo_id' => "1",
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('cargos')->insert(array(
            'comision_id' => '1',
            'asambleista_id' => '2',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'tipo_cargo_id' => "2",
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('cargos')->insert(array(
            'comision_id' => '1',
            'asambleista_id' => '3',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'tipo_cargo_id' => "3",
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        
        \DB::table('cargos')->insert(array(
            'comision_id' => '1',
            'asambleista_id' => '4',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'tipo_cargo_id' => '4',
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('cargos')->insert(array(
            'comision_id' => '1',
            'asambleista_id' => '5',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'tipo_cargo_id' => '5',
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

    

        \DB::table('cargos')->insert(array(
            'comision_id' => '2',
            'asambleista_id' => '11',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'tipo_cargo_id' => '9',
            'activo' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('cargos')->insert(array(
            'comision_id' => '2',
            'asambleista_id' => '12',
            'inicio' => Carbon::create(2015, 6, 28, 0, 0, 0),
            'fin' => Carbon::create(2017, 6, 28, 0, 0, 0),
            'tipo_cargo_id' => '9',
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
                'tipo_cargo_id' => '9',
                'activo' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

        }


    }
}
