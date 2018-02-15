<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Carbon\Carbon;

class PeticionTableSeeder extends Seeder
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

        

        for ($k=1; $k <5 ; $k++) { 
      
		for ($i=1; $i < 8 ; $i++) { 
		\DB::table('documentos')->insert(array (
		'nombre_documento'  => 'documento'.$k,
		'tipo_documento_id'  => $i,
		'periodo_id'  => '2',
		'fecha_ingreso'  => Carbon::now()->format('Y-m-d H:i:s'),
		'path'  => '0b17d8a78c9516c900892e6a0ad52809.pdf',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));
		}
		}
		
		

		




		for ($i=1; $i < 10; $i++) {
		$c = 0;
		$est = '1';
		if($i>5){
			$c = 1;
			$est = '3';
		}

		\DB::table('peticiones')->insert(array (
		'estado_peticion_id'  => $est,
		'periodo_id'  => '2',
		'codigo'  => $i.'-1234ABC',
		'descripcion'  => 'Prueba por seed',
		'peticionario'  => 'peticionario'.' '.$i,
		'fecha'  => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s'),
		'correo'  => $faker->freeEmail,
		'telefono'  => $faker->tollFreePhoneNumber ,
		'direccion'  =>  $faker->address,
		'resuelto'  => '0',
		'agendado'  => '0',
		'asignado_agenda'  => '0',
		'comision'  => $c,
		'created_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s')
		));



        \DB::table('documento_peticion')->insert(array (
		'documento_id'  => '1',
		'peticion_id'  => $i,
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('documento_peticion')->insert(array (
		'documento_id'  => '2',
		'peticion_id'  => $i,
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('documento_peticion')->insert(array (
		'documento_id'  => '2',
		'peticion_id'  => $i,
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('comision_peticion')->insert(array (
		'comision_id'  => '1',
		'peticion_id'  => $i,
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));



		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => $i,
		'comision_id'  => '1',
		'estado_seguimiento_id'  => '1',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '0',
		'agendado'  => '0',
		'descripcion'  => 'Creacion prueba por seed',
		'created_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s')
		));

		for ($k=1; $k < 3; $k++) { 
		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => $i,
		'comision_id'  => '1',
		'estado_seguimiento_id'  => '1',
		'documento_id'  => $k,
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '0',
		'agendado'  => '0',
		'descripcion'  => 'documento prueba por seed',
		'created_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s')
		));
		}

		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => $i,
		'comision_id'  => '1',
		'estado_seguimiento_id'  => '2',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		//'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '1',
		'agendado'  => '0',
		'descripcion'  => 'Inicio control de JD prueba por seed',
		'created_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s')
		));

		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => $i,
		'comision_id'  => '1',
		'estado_seguimiento_id'  => '3',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '0',
		'agendado'  => '0',
		'descripcion'  => 'Asignado a JD prueba por seed',
		'created_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->addMinutes($i)->format('Y-m-d H:i:s')
		));	

		// --------------------------------
		// ********************************
		// --------------------------------

		}

		for ($h=2; $h < 6; $h++) { 
		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => '9',
		'comision_id'  => $h,
		'estado_seguimiento_id'  => '2',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		//'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '1',
		'agendado'  => '0',
		'descripcion'  => 'Inicio control de comision '.$h.' prueba por seed',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => '9',
		'comision_id'  => $h,
		'estado_seguimiento_id'  => '3',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '0',
		'agendado'  => '0',
		'descripcion'  => 'Asignado a comision '.$h.' prueba por seed',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('comision_peticion')->insert(array (
		'comision_id'  => $h,
		'peticion_id'  => '9',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));



		}       


		for ($h=2; $h < 5; $h++) { 
		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => '8',
		'comision_id'  => $h,
		'estado_seguimiento_id'  => '2',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		//'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '1',
		'agendado'  => '0',
		'descripcion'  => 'Inicio control de comision '.$h.' prueba por seed',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => '8',
		'comision_id'  => $h,
		'estado_seguimiento_id'  => '3',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '0',
		'agendado'  => '0',
		'descripcion'  => 'Asignado a comision '.$h.' prueba por seed',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('comision_peticion')->insert(array (
		'comision_id'  => $h,
		'peticion_id'  => '8',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		} 

		for ($h=2; $h < 4; $h++) { 
		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => '7',
		'comision_id'  => $h,
		'estado_seguimiento_id'  => '2',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		//'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '1',
		'agendado'  => '0',
		'descripcion'  => 'Inicio control de comision '.$h.' prueba por seed',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => '7',
		'comision_id'  => $h,
		'estado_seguimiento_id'  => '3',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '0',
		'agendado'  => '0',
		'descripcion'  => 'Asignado a comision '.$h.' prueba por seed',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('comision_peticion')->insert(array (
		'comision_id'  => $h,
		'peticion_id'  => '7',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));
		}

		for ($h=2; $h < 3; $h++) { 
		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => '6',
		'comision_id'  => $h,
		'estado_seguimiento_id'  => '2',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		//'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '1',
		'agendado'  => '0',
		'descripcion'  => 'Inicio control de comision '.$h.' prueba por seed',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('seguimientos')->insert(array (
		'peticion_id'  => '6',
		'comision_id'  => $h,
		'estado_seguimiento_id'  => '3',
		//'documento_id'  => '1',
		//'reunion_id'  => '1',
		'inicio'  => Carbon::now()->format('Y-m-d H:i:s'),
		'fin'  => Carbon::now()->format('Y-m-d H:i:s'),
		'activo'  => '0',
		'agendado'  => '0',
		'descripcion'  => 'Asignado a comision '.$h.' prueba por seed',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));


		\DB::table('comision_peticion')->insert(array (
		'comision_id'  => $h,
		'peticion_id'  => '6',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));


		}
		

    }
}
