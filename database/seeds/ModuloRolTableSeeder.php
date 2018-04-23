<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ModuloRolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //asignacion de acceso a todos los modulos al rol administrador
        for ($i=1;$i<=30;$i++){
            \DB::table('modulo_rol')->insert(array (
                'rol_id'  => 1,
                'modulo_id'  => $i,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }

        //asignacion de acceso a secretario
        $modulos_secretario = array(1,3,14,15,4,16,17,18,8,19,20,21);
        foreach ($modulos_secretario as $value){
            \DB::table('modulo_rol')->insert(array (
                'rol_id'  => 2,
                'modulo_id'  => $value,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }

        //asignacion de acceso a secretario
        $modulos_asambleista = array(1,2,3,14,15,13,12,4,16,17,18,5,7);
        foreach ($modulos_asambleista as $value){
            \DB::table('modulo_rol')->insert(array (
                'rol_id'  => 3,
                'modulo_id'  => $value,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }

        //asignacion de acceso a secretario
        $modulos_junta = array(1,2,3,14,15,13,12,4,16,17,18,5,7,9,21);
        foreach ($modulos_junta as $value){
            \DB::table('modulo_rol')->insert(array (
                'rol_id'  => 4,
                'modulo_id'  => $value,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }


    }
}
