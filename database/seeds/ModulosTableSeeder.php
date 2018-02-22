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
            'orden' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //2
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Comisiones',
            'icono'  => 'glyphicon glyphicon-equalizer',
            'tiene_hijos' => true,
            'orden' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //3
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Agenda',
            'icono'  => 'fa fa-files-o',
            'tiene_hijos' => true,
            'orden' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //4
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Asambleistas',
            'icono'  => 'fa fa-users',
            'tiene_hijos' => true,
            'orden' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //5
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Reporteria',
            'icono'  => 'glyphicon glyphicon-duplicate',
            'tiene_hijos' => true,
            'orden' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //6 OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Plantillas',
            'url' => 'Menu_plantillas',
            'modulo_padre' => '5',
            'icono'  => 'fa-dot-circle-o',
            'nivel_acceso' => 5,
            'orden' => 16,
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
            'nivel_acceso' => 6,
            'orden' => 17,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //8
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Peticiones',
            'icono'  => 'glyphicon glyphicon-envelope',
            'tiene_hijos' => true,
            'orden' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //9
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Junta Directiva',
            'icono'  => 'glyphicon glyphicon-briefcase',
            'tiene_hijos' => true,
            'orden' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //10
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Administracion',
            'icono'  => 'glyphicon glyphicon-wrench',
            'tiene_hijos' => true,
            'orden' => 8,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //11
        /*\DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Gestionar Usuarios',
            'icono'  => 'glyphicon glyphicon-wrench',
            'modulo_padre' => '10',
            'nivel_acceso' => 10,
            'tiene_hijos' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));*/

        //Modulos Hijos
        //11
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Crear Comision',
            'url' => 'comisiones/comisiones',
            'modulo_padre' => '2',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 1,
            'tiene_hijos' => false,
            'orden' => 9,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //12
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Administrar Comisiones',
            'url' => 'comisiones/administrar_comisiones',
            'modulo_padre' => '2',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 2,
            'tiene_hijos' => false,
            'orden' => 10,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //13
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Consultar agenda vigente',
            'url' => 'plenarias/consultar_agendas_vigentes',
            'modulo_padre' => '3',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 3,
            'orden' => 11,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //14
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Historial de Agendas',
            'url' => 'plenarias/historial_agendas',
            'modulo_padre' => '3',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 4,
            'orden' => 12,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //15
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Listado de Asambleistas',
            'url' => 'asambleistas/listado_asambleistas_facultad',
            'modulo_padre' => '4',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'orden' => 13,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //16
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Asambleistas por Comision',
            'url' => 'asambleistas/listado_asambleistas_comision',
            'modulo_padre' => '4',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'orden' => 14,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //17
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Asambleistas de JD',
            'url' => 'asambleistas/listado_asambleistas_junta',
            'modulo_padre' => '4',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'orden' => 15,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //18
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Registrar Peticiones',
            'url' => 'peticiones/registrar_peticion',
            'modulo_padre' => '8',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 7,
            'tiene_hijos' => false,
            'orden' => 18,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //19
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Monitoreo Peticion',
            'url' => 'peticiones/monitoreo_peticion',
            'modulo_padre' => '8',
            'icono'  => 'fa fa-dot-circle-o',
            'tiene_hijos' => false,
            'orden' => 19,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //20
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Listado de Peticiones',
            'url' => 'peticiones/listado_peticiones',
            'modulo_padre' => '8',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 8,
            'tiene_hijos' => false,
            'orden' => 20,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //21
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Trabajo JD',
            'url' => 'juntadirectiva/trabajo_junta_directiva',
            'modulo_padre' => '9',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 9,
            'orden' => 21,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //22
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Parametros',
            'url' => 'administracion/parametros',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 11,
            'orden' => 23,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //23
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Plantillas',
            'url' => 'administracion/gestionar_plantillas',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 12,
            'orden' => 24,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //24
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Administracion Usuarios',
            'url' => 'administracion/gestionar_usuarios',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 16,
            'orden' => 21,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //25
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Gestionar Perfiles',
            'url' => 'administracion/gestionar_perfiles',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 17,
            'orden' => 22,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //26
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Permisos Temporales',
            'url' => 'administracion/registro_permisos_temporales',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 13,
            'orden' => 25,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //27
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Periodo AGU',
            'url' => 'administracion/periodos_agu',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 14,
            'orden' => 26,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));

        //28
        \DB::table('modulos')->insert(array (
            'nombre_modulo'  => 'Dietas Asambleistas',
            'url' => 'administracion/dietas_asambleista',
            'modulo_padre' => '10',
            'icono'  => 'fa fa-dot-circle-o',
            'nivel_acceso' => 15,
            'orden' => 27,
            'tiene_hijos' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ));


        

    }
}
