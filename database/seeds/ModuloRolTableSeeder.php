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
        //
        for ($i=1;$i<=29;$i++){
            \DB::table('modulo_rol')->insert(array (
                'rol_id'  => 1,
                'modulo_id'  => $i,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }

    }
}
