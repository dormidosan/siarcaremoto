<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ModulosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Modulos Padres
        //1
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Buscar documento',
            'url'  => 'busqueda',
            'icono'  => 'fa fa-book',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //2
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Comisiones',
            'icono'  => 'glyphicon glyphicon-equalizer',
            'tiene_hijos' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //3
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Agenda',
            'icono'  => 'fa fa-files-o',
            'tiene_hijos' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //4
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Asambleistas',
            'icono'  => 'fa fa-users',
            'tiene_hijos' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //5
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Reporteria',
            'icono'  => 'glyphicon glyphicon-duplicate',
            'tiene_hijos' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //6
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Plantillas',
            'url' => 'Menu_plantillas',
            'modulo_padre' => '5',
            'icono'  => 'fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //7
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Reportes',
            'url' => 'Menu_reportes',
            'icono'  => 'fa-dot-circle-o',
            'modulo_padre' => '5',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //8
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Peticiones',
            'icono'  => 'glyphicon glyphicon-envelope',
            'tiene_hijos' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //9
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Junta Directiva',
            'icono'  => 'glyphicon glyphicon-briefcase',
            'tiene_hijos' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //10
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Administracion',
            'icono'  => 'glyphicon glyphicon-wrench',
            'tiene_hijos' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //11
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Gestionar Usuarios',
            'icono'  => 'glyphicon glyphicon-wrench',
            'modulo_padre' => '10',
            'tiene_hijos' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //Modulos Hijos
        //12
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Crear Comision',
            'url' => 'comisiones/comisiones',
            'modulo_padre' => '2',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //13
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Administrar Comisiones',
            'url' => 'comisiones/administrar_comisiones',
            'modulo_padre' => '2',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //14
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Consultar agenda vigente',
            'url' => 'consultar_agendas_vigentes',
            'modulo_padre' => '3',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //15
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Historial de Agendas',
            'url' => 'historial_agendas',
            'modulo_padre' => '3',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //16
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Listado de Asambleistas',
            'url' => 'listado_asambleistas_facultad',
            'modulo_padre' => '4',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //17
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Asambleistas por Comision',
            'url' => 'listado_asambleistas_comision',
            'modulo_padre' => '4',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //18
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Asambleistas de JD',
            'url' => 'listado_asambleistas_junta',
            'modulo_padre' => '4',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //19
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Registrar Peticiones',
            'url' => 'registrar_peticion',
            'modulo_padre' => '8',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //20
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Monitoreo Peticion',
            'url' => 'monitoreo_peticion',
            'modulo_padre' => '8',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //21
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Listado de Peticiones',
            'url' => 'listado_peticiones',
            'modulo_padre' => '8',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //22
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Trabajo JD',
            'url' => 'trabajo_junta_directiva',
            'modulo_padre' => '9',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //23
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Parametros',
            'url' => 'parametros',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //24
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Plantillas',
            'url' => 'gestionar_plantillas',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //25
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Administracion Usuarios',
            'url' => 'GestionarUsuarios',
            'modulo_padre' => '11',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        /*\DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Registrar Usuarios',
            'url' => 'registrar_usuario',
            'modulo_padre' => '11',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));*/

        //26
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Gestionar Perfiles',
            'url' => 'gestionar_perfiles',
            'modulo_padre' => '11',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //27
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Permisos Temporales',
            'url' => 'registro_permisos_temporales',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //28
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Periodo AGU',
            'url' => 'periodos_agu',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //29
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Dietas Asambleistas',
            'url' => 'dietas_asambleista',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        

    }
}
