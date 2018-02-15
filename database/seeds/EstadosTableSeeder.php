<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	\DB::table('estado_seguimientos')->insert(array (
		'estado'  => 'cr',
		'nombre_estado'  => 'creado',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

        \DB::table('estado_seguimientos')->insert(array (
		'estado'  => 'se',
		'nombre_estado'  => 'seguimiento',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('estado_seguimientos')->insert(array (
		'estado'  => 'as',
		'nombre_estado'  => 'asignado',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('estado_seguimientos')->insert(array (
		'estado'  => 'ag',
		'nombre_estado'  => 'agendado',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

        \DB::table('estado_seguimientos')->insert(array (
		'estado'  => 'ds',
		'nombre_estado'  => 'discutido',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('estado_seguimientos')->insert(array (
		'estado'  => 'dc',
		'nombre_estado'  => 'dictamen',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('estado_seguimientos')->insert(array (
		'estado'  => 'ra',
		'nombre_estado'  => 're-abierto',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));


		


		\DB::table('estado_peticiones')->insert(array (
		'estado'  => 're',
		'nombre_estado'  => 'Recibido',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));


        \DB::table('estado_peticiones')->insert(array (
		'estado'  => 'jd',
		'nombre_estado'  => 'Junta Directiva',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('estado_peticiones')->insert(array (
		'estado'  => 'co',
		'nombre_estado'  => 'En comision',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('estado_peticiones')->insert(array (
		'estado'  => 'aa',
		'nombre_estado'  => 'Agendado Plenaria',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('estado_peticiones')->insert(array (
		'estado'  => 'rs',
		'nombre_estado'  => 'Resuelto',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('estado_peticiones')->insert(array (
		'estado'  => 'ra',
		'nombre_estado'  => 'Re-abierto',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));




		\DB::table('parametros')->insert(array (
		'parametro'  => 'iva',
		'nombre_parametro'  => 'iva',
		'valor'  => '0.13',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));


		\DB::table('parametros')->insert(array (
		'parametro'  => 'pas',
		'nombre_parametro'  => 'porcentaje_asistencia',
		'valor'  => '0.80',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('parametros')->insert(array (
		'parametro'  => 'ren',
		'nombre_parametro'  => 'renta',
		'valor'  => '0.17',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('parametros')->insert(array (
		'parametro'  => 'mdi',
		'nombre_parametro'  => 'monto_dieta',
		'valor'  => '25.15',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('parametros')->insert(array (
		'parametro'  => 'qmn',
		'nombre_parametro'  => 'quorum_minimo_nomal',
		'valor'  => '37',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('parametros')->insert(array (
		'parametro'  => 'qmt',
		'nombre_parametro'  => 'quorum_minimo_trascendental',
		'valor'  => '48',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('parametros')->insert(array (
		'parametro'  => 'vmn',
		'nombre_parametro'  => 'votacion_minima_ordinaria',
		'valor'  => '27',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));

		\DB::table('parametros')->insert(array (
		'parametro'  => 'vmt',
		'nombre_parametro'  => 'votacion_minima_trascendental',
		'valor'  => '37',
		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
		));












    }
}
