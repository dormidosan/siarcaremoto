<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Carbon\Carbon;

class AgendaTableSeeder extends Seeder
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

        \DB::table('agendas')->insert(array(
            'periodo_id' => '2',
            'codigo' => "2015-2017 52",
            'fecha' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->format('Y-m-d H:i:s'),
            'lugar' => 'Sala reuniones AGU',
            'trascendental' => '0',
            'vigente' => '0',
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->format('Y-m-d H:i:s'),
            'fin' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->addHours(5)->format('Y-m-d H:i:s'),
            'activa' => "0",
            'fijada' => "0",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('agendas')->insert(array(
            'periodo_id' => '2',
            'codigo' => "2015-2017 53",
            'fecha' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->format('Y-m-d H:i:s'),
            'lugar' => 'Sala reuniones AGU',
            'trascendental' => '0',
            'vigente' => '0',
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->format('Y-m-d H:i:s'),
            'fin' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->addHours(6)->format('Y-m-d H:i:s'),
            'activa' => "0",
            'fijada' => "0",
            'created_at' => Carbon::now()->addSeconds(2)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(2)->format('Y-m-d H:i:s')
        ));


        \DB::table('agendas')->insert(array(
            'periodo_id' => '2',
            'codigo' => "2015-2017 54",
            'fecha' => Carbon::create(2017, 11, 10, 8, 0)->format('Y-m-d H:i:s'),
            'lugar' => 'FMOcc salon principal',
            'trascendental' => '0',
            'vigente' => '1',
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->format('Y-m-d H:i:s'),
            //'fin'  	  => Carbon::create(2017, 11,10, 8, 0)->addHours(8)->format('Y-m-d H:i:s'),
            'activa' => "0",
            'fijada' => "0",
            'created_at' => Carbon::now()->addSeconds(4)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(4)->format('Y-m-d H:i:s')
        ));


        \DB::table('estado_asistencias')->insert(array(
            'estado' => 'tem',
            'nombre_estado' => "temporal",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('estado_asistencias')->insert(array(
            'estado' => 'per',
            'nombre_estado' => "permanente",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('estado_asistencias')->insert(array(
            'estado' => 'nor',
            'nombre_estado' => "normal",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('estado_asistencias')->insert(array(
            'estado' => 'cam',
            'nombre_estado' => "cambio",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

///////////////////////////////////
        for ($k = 1; $k < 140; $k = $k + 2) {
            \DB::table('asistencias')->insert(array(
                'agenda_id' => '1',
                'asambleista_id' => $k,
                'entrada' => Carbon::create(2017, 11, 10, 8, 0)->toTimeString(),
                'salida' => Carbon::create(2017, 11, 10, 8, 0)->addHours(5)->toTimeString(),
                'propietaria' => '1',
                'temporal' => '0',
                'dieta' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }


        for ($k = 2; $k < 140; $k = $k + 2) {
            \DB::table('asistencias')->insert(array(
                'agenda_id' => '1',
                'asambleista_id' => $k,
                'entrada' => Carbon::create(2017, 11, 10, 8, 0)->toTimeString(),
                'salida' => Carbon::create(2017, 11, 10, 8, 0)->addHours(5)->toTimeString(),
                'propietaria' => '0',
                'temporal' => '0',
                'dieta' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }

///////////////////////////////////
        for ($k = 1; $k < 100; $k = $k + 2) {
            \DB::table('asistencias')->insert(array(
                'agenda_id' => '2',
                'asambleista_id' => $k,
                'entrada' => Carbon::create(2017, 11, 10, 8, 0)->toTimeString(),
                'salida' => Carbon::create(2017, 11, 10, 8, 0)->addHours(4)->toTimeString(),
                'propietaria' => '1',
                'temporal' => '0',
                'dieta' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }


//////////////////////////////

        for ($k = 1; $k < 140; $k = $k + 2) {
            \DB::table('asistencias')->insert(array(
                'agenda_id' => '3',
                'asambleista_id' => $k,
                'entrada' => Carbon::create(2017, 11, 10, 8, 0)->toTimeString(),
                'salida' => Carbon::create(2017, 11, 10, 8, 0)->addHours(5)->toTimeString(),
                'propietaria' => '1',
                'temporal' => '0',
                'dieta' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }


        for ($k = 2; $k < 140; $k = $k + 2) {
            \DB::table('asistencias')->insert(array(
                'agenda_id' => '3',
                'asambleista_id' => $k,
                'entrada' => Carbon::create(2017, 11, 10, 8, 0)->toTimeString(),
                'salida' => Carbon::create(2017, 11, 10, 8, 0)->addHours(5)->toTimeString(),
                'propietaria' => '0',
                'temporal' => '0',
                'dieta' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }


        for ($k = 1; $k < 144; $k++) {

            \DB::table('tiempos')->insert(array(
                'asistencia_id' => $k,
                'estado_asistencia_id' => "1",
                'entrada' => Carbon::create(2017, 11, 10, 8, 0)->toTimeString(),
                'salida' => Carbon::create(2017, 11, 10, 8, 0)->addHours(1)->toTimeString(),
                'tiempo_propietario' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

            \DB::table('tiempos')->insert(array(
                'asistencia_id' => $k,
                'estado_asistencia_id' => "4",
                'entrada' => Carbon::create(2017, 11, 10, 8, 0)->addHours(2)->toTimeString(),
                'salida' => Carbon::create(2017, 11, 10, 8, 0)->addHours(3)->toTimeString(),
                'tiempo_propietario' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

            \DB::table('tiempos')->insert(array(
                'asistencia_id' => $k,
                'estado_asistencia_id' => "3",
                'entrada' => Carbon::create(2017, 11, 10, 8, 0)->addHours(3)->toTimeString(),
                'salida' => Carbon::create(2017, 11, 10, 8, 0)->addHours(4)->toTimeString(),
                'tiempo_propietario' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

            \DB::table('tiempos')->insert(array(
                'asistencia_id' => $k,
                'estado_asistencia_id' => "2",
                'entrada' => Carbon::create(2017, 11, 10, 8, 0)->addHours(4)->toTimeString(),
                'salida' => Carbon::create(2017, 11, 10, 8, 0)->addHours(6)->toTimeString(),
                'tiempo_propietario' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));


        }
        //////////////////


        \DB::table('reuniones')->insert(array(
            'comision_id' => '1',
            'periodo_id' => '2',
            'codigo' => 'JD 24',
            'lugar' => 'sala de reuniones',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->subDay()->format('Y-m-d H:i:s'),
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->format('Y-m-d H:i:s'),
            'fin' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '0',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(2)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(2)->format('Y-m-d H:i:s')
        ));

        \DB::table('reuniones')->insert(array(
            'comision_id' => '1',
            'periodo_id' => '2',
            'codigo' => 'JD 25',
            'lugar' => 'sala de reuniones',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->subDay()->format('Y-m-d H:i:s'),
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->format('Y-m-d H:i:s'),
            'fin' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '0',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(3)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(3)->format('Y-m-d H:i:s')
        ));

        \DB::table('reuniones')->insert(array(
            'comision_id' => '1',
            'periodo_id' => '2',
            'codigo' => 'JD 26',
            'lugar' => 'sala de reuniones',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subDay()->format('Y-m-d H:i:s'),
            //'inicio'  => Carbon::create(2017, 11,10, 8, 0)->format('Y-m-d H:i:s'),
            //'fin'     => Carbon::create(2017, 11,10, 8, 0)->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '1',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(4)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(4)->format('Y-m-d H:i:s')
        ));

        //////////////////


        \DB::table('reuniones')->insert(array(
            'comision_id' => '2',
            'periodo_id' => '2',
            'codigo' => 'CO AS 24',
            'lugar' => 'sala de reuniones',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->subDay()->format('Y-m-d H:i:s'),
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->format('Y-m-d H:i:s'),
            'fin' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '0',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(3)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(3)->format('Y-m-d H:i:s')
        ));

        \DB::table('reuniones')->insert(array(
            'comision_id' => '2',
            'periodo_id' => '2',
            'codigo' => 'CO AS 25',
            'lugar' => 'sala de reuniones',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->subDay()->format('Y-m-d H:i:s'),
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->format('Y-m-d H:i:s'),
            'fin' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '0',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(4)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(4)->format('Y-m-d H:i:s')
        ));

        \DB::table('reuniones')->insert(array(
            'comision_id' => '2',
            'periodo_id' => '2',
            'codigo' => 'CO AS 26',
            'lugar' => 'sala de reuniones',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subDay()->format('Y-m-d H:i:s'),
            //'inicio'  => Carbon::create(2017, 11,10, 8, 0)->format('Y-m-d H:i:s'),
            //'fin'     => Carbon::create(2017, 11,10, 8, 0)->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '1',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(5)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(5)->format('Y-m-d H:i:s')
        ));

        //////////////////


        \DB::table('reuniones')->insert(array(
            'comision_id' => '3',
            'periodo_id' => '2',
            'codigo' => 'CO RE 24',
            'lugar' => 'sala de reuniones',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(3)->subDay()->format('Y-m-d H:i:s'),
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(3)->format('Y-m-d H:i:s'),
            'fin' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(3)->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '0',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(3)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(3)->format('Y-m-d H:i:s')
        ));

        \DB::table('reuniones')->insert(array(
            'comision_id' => '3',
            'periodo_id' => '2',
            'codigo' => 'CO RE 24',
            'lugar' => 'sala de reuniones',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->subDay()->format('Y-m-d H:i:s'),
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->format('Y-m-d H:i:s'),
            'fin' => Carbon::create(2017, 11, 10, 8, 0)->subWeeks(2)->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '0',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(4)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(4)->format('Y-m-d H:i:s')
        ));

        \DB::table('reuniones')->insert(array(
            'comision_id' => '3',
            'periodo_id' => '2',
            'codigo' => 'CO RE 24',
            'lugar' => 'sala de reuniones',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->subDay()->format('Y-m-d H:i:s'),
            'inicio' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->format('Y-m-d H:i:s'),
            'fin' => Carbon::create(2017, 11, 10, 8, 0)->subWeek()->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '0',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(5)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(5)->format('Y-m-d H:i:s')
        ));

        \DB::table('reuniones')->insert(array(
            'comision_id' => '3',
            'periodo_id' => '2',
            'codigo' => 'CO RE 24',
            'lugar' => 'sala de reuniones academica',
            'convocatoria' => Carbon::create(2017, 11, 10, 8, 0)->subDay()->format('Y-m-d H:i:s'),
            //'inicio'  => Carbon::create(2017, 11,10, 8, 0)->format('Y-m-d H:i:s'),
            //'fin'     => Carbon::create(2017, 11,10, 8, 0)->addHours(5)->format('Y-m-d H:i:s'),
            'vigente' => '1',
            'activa' => '0',
            'created_at' => Carbon::now()->addSeconds(6)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(6)->format('Y-m-d H:i:s')
        ));
        
        for ($k=1; $k <8 ; $k++) { 
            
                for ($i=1; $i < 4 ; $i++) { 
        \DB::table('documento_reunion')->insert(array (
        'documento_id'  => $k,
        'reunion_id'  => $i,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));
        }
        }
    }

}
