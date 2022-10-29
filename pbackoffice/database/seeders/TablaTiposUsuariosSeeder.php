<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaTiposUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = array(
            "1" => array(
                'tipo' => 'Persona Fisica',
                'activo' => 1,
            ),
            "2" => array(
                'tipo' => 'Persona Juridica',
                'activo' => 1,
            ),
        );

        foreach ($tipos as $key => $tipo) {
            DB::table('TiposUsuario')->insert([
             'tipoUsuario' => $tipo['tipo'],
             'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
             'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } 
    }
}
