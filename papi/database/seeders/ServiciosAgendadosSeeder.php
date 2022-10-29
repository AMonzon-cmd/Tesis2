<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosAgendadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servicios = array(
            array(
                'idUsuario' => 1,
                'idServicio' => 1,
            ),
            array(
                'idUsuario' => 1,
                'idServicio' => 2,
            )
        );

        foreach ($servicios as $key => $servicio) {
            DB::table('ServiciosAgendados')->insert([
                'idUsuario'    => $servicio['idUsuario'],
                'idServicio'   => $servicio['idServicio']
            ]);
        }
    }
}
