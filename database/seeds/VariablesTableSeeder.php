<?php

use Illuminate\Database\Seeder;


use Carbon\Carbon;

class VariablesTableSeeder extends Seeder
{


    public function run()
    {

        \DB::table('tipo_documentos')->insert(array(
            'tipo' => 'peticion'
        ));

        \DB::table('tipo_documentos')->insert(array(
            'tipo' => 'atestado'
        ));

        \DB::table('tipo_documentos')->insert(array(
            'tipo' => 'dictamen'
        ));

        \DB::table('tipo_documentos')->insert(array(
            'tipo' => 'acuerdo'
        ));

        \DB::table('tipo_documentos')->insert(array(
            'tipo' => 'acta'
        ));

        \DB::table('tipo_documentos')->insert(array(
            'tipo' => 'acta jd'
        ));

        \DB::table('tipo_documentos')->insert(array(
            'tipo' => 'bitacora'
        ));


        \DB::table('periodos')->insert(array(
            'nombre_periodo' => '2013-2015',
            'inicio' => '2013-06-02',
            'fin' => '2015-06-02',
            'activo' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('periodos')->insert(array(
            'nombre_periodo' => '2015-2017',
            'inicio' => '2015-06-02',
            'fin' => '2017-06-02',
            'activo' => '1',
            'created_at' => Carbon::now()->addSeconds(2)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addSeconds(2)->format('Y-m-d H:i:s')
        ));

        \DB::table('roles')->insert(array(
            'nombre_rol' => 'administrador'

        ));

        \DB::table('roles')->insert(array(
            'nombre_rol' => 'secretario'

        ));

        \DB::table('roles')->insert(array(
            'nombre_rol' => 'asambleista'

        ));


        \DB::table('comisiones')->insert(array(
            'codigo' => 'jda',
            'nombre' => 'junta directiva',
            'permanente' => '1',
            'descripcion' => 'comision de JD',
            'activa' => '1',
            'especial' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'aso',
            'nombre' => 'comision asociaciones',
            'permanente' => '1',
            'descripcion' => 'comision de creacion de asociaciones',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'reg',
            'nombre' => 'comision reglamentos',
            'permanente' => '1',
            'descripcion' => 'comision de creacion de reglamentos',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'leg',
            'nombre' => 'comision legislacion',
            'permanente' => '0',
            'descripcion' => 'comision de legislar la ues',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'pre',
            'nombre' => 'comision presupuestos',
            'permanente' => '0',
            'descripcion' => 'comision de prespuesto y dinero',
            'activa' => '0',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            'nombre' => 'CIENCIAS Y HUMANIDADES',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            'nombre' => 'CIENCIAS AGRONOMICAS',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            'nombre' => 'CIENCIAS ECONOMICAS',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            'nombre' => 'ODONTOLOGIA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            'nombre' => 'INGENIERIA Y ARQUITECTURA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            'nombre' => 'QUIMICA Y FARMACIA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            'nombre' => 'MEDICINA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            'nombre' => 'CIENCIAS NATURALES Y MATEMATICA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            'nombre' => 'JURISPRUDENCIA Y CIENCIAS SOCIALES',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            //'nombre' => 'MULTIDISCIPLINARIA DE OCCIDENTE',
            'nombre' => 'FMOcc',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            //'nombre' => 'MULTIDISCIPLINARIA  PARACENTRAL',
            'nombre' => 'FMP',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        \DB::table('facultades')->insert(array(
            //'nombre' => 'MULTIDISCIPLINARIA ORIENTAL',
            'nombre' => 'FMO',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('sectores')->insert(array(
            'nombre' => 'Estudiantil',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('sectores')->insert(array(
            'nombre' => 'Docente',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('sectores')->insert(array(
            'nombre' => 'Profesional no docente',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        for ($i = 0; $i < 5; $i++) {
            \DB::table('plantillas')->insert(array(
                'codigo' => 'pla' . $i,
                'nombre' => 'documento' . $i,
                'path' => '0b17d8a78c9516c900892e6a0ad52809.pdf',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

        }
    }

}
	
