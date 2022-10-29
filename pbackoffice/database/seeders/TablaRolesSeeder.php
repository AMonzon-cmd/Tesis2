<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array(
            "1" => array(
                'rol' => 'Administrador',
                'activo' => 1,
            ),
            "2" => array(
                'rol' => 'Operario',
                'activo' => 1,
            ),
            "3" => array(
                'rol' => 'Moderador',
                'activo' => 1,
            )
        );

        foreach ($roles as $key => $rol) {
            DB::table('Roles')->insert([
             'nombre' => $rol['rol'],
             'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
             'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } 
    }
}
