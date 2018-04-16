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

        \DB::table('tipo_documentos')->insert(array(
            'tipo' => 'convocatoria'
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

        \DB::table('roles')->insert(array(
            'nombre_rol' => 'junta'

        ));

        \DB::table('roles')->insert(array(
            'nombre_rol' => 'empleado'

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
            'codigo' => 'cge',
            'nombre' => 'Comision de Genero',
            'permanente' => '1',
            'descripcion' => 'comision para defensa de Genero',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'clg',
            'nombre' => 'Comisión de legislación',
            'permanente' => '1',
            'descripcion' => 'comision de estudio de legislación',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'ccn',
            'nombre' => 'Comisión de convenios',
            'permanente' => '1',
            'descripcion' => 'comision de trata de convenios',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'cdc',
            'nombre' => 'Comisión de comunicaciones',
            'permanente' => '1',
            'descripcion' => 'comision de fomento de comunicaciones',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'ccu',
            'nombre' => 'Comisión de cultura',
            'permanente' => '1',
            'descripcion' => 'comision de proteccion de cultura',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'cds',
            'nombre' => 'Comisión de salud',
            'permanente' => '1',
            'descripcion' => 'comision de cuido de salud estudiantil',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'cse',
            'nombre' => 'Comisión de seguimiento de las autoridades electas',
            'permanente' => '1',
            'descripcion' => 'comision para control de elecciones',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'cae',
            'nombre' => 'Comisión de asociaciones estudiantiles',
            'permanente' => '1',
            'descripcion' => 'comision de estudio de asociaciones',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'cpr',
            'nombre' => 'Comisión de presupuesto',
            'permanente' => '1',
            'descripcion' => 'comision de prespuesto y dinero',
            'activa' => '1',
            'especial' => '0',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        \DB::table('comisiones')->insert(array(
            'codigo' => 'cma',
            'nombre' => 'Comisión de medio ambiente',
            'permanente' => '0',
            'descripcion' => 'comision control de medio ambiente',
            'activa' => '1',
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
/*
        for ($i = 0; $i < 5; $i++) {
            \DB::table('plantillas')->insert(array(
                'codigo' => 'pla' . $i,
                'nombre' => 'documento' . $i,
                'path' => '0b17d8a78c9516c900892e6a0ad52809.pdf',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

        }
*/
        \DB::table('plantillas')->insert(array(
                'codigo' => 'pla1',
                'nombre' => 'dictamen',
                'path' => '0b17d8a78c9516c900892e6a0ad52809.pdf',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

        \DB::table('plantillas')->insert(array(
                'codigo' => 'pla1',
                'nombre' => 'acuerdo',
                'path' => '0b17d8a78c9516c900892e6a0ad52809.pdf',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

        \DB::table('plantillas')->insert(array(
                'codigo' => 'pla1',
                'nombre' => 'bitacora',
                'path' => '0b17d8a78c9516c900892e6a0ad52809.pdf',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

        \DB::table('plantillas')->insert(array(
                'codigo' => 'pla1',
                'nombre' => 'bitacora_jd',
                'path' => '0b17d8a78c9516c900892e6a0ad52809.pdf',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));

        \DB::table('plantillas')->insert(array(
                'codigo' => 'pla1',
                'nombre' => 'atestado',
                'path' => '0b17d8a78c9516c900892e6a0ad52809.pdf',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));


        \DB::table('hojas')->insert(array(
                'nombre' => 'documento hoja de vida',
                'path' => '0b17d8a78c9516c900892e6a0ad52808.pdf',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
    }

}
	
