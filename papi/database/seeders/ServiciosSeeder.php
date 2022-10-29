<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
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
                'nombre' => 'UTE',
                'descripcion' => 'Servicio para pagar la UTE'
            ),
            array(
                'nombre' => 'OSE',
                'descripcion' => 'Servicio para pagar la OSE'
            ),
            array(
                'nombre' => 'Antel',
                'descripcion' => 'Servicio para pagar antel'
            ),
            array(
                'nombre' => 'Movistar',
                'descripcion' => 'Servicio para pagar Movistar'
            ),
            array(
                'nombre' => 'Impuestos',
                'descripcion' => 'Servicio para pagar impuestos'
            ),
            array(
                'nombre' => 'DGI',
                'descripcion' => 'Servicio para pagar DGI'
            ),
            array(
                'nombre' => 'Sucive',
                'descripcion' => 'Servicio para pagar patente'
            ),
            array(
                'nombre' => 'Direct TV',
                'descripcion' => 'Servicio para pagar cable'
            ),
            array(
                'nombre' => 'CASMU',
                'descripcion' => 'Servicio para pagar mutualista'
            ),
            array(
                'nombre' => 'Club atletico Peñarol',
                'descripcion' => 'Servicio para pagar afiliacion a cuadro peñarol'
            )

        );

        foreach ($servicios as $key => $servicio) {
            DB::table('Servicios')->insert([
                'nombre'        => $servicio['nombre'],
                'descripcion'   => $servicio['descripcion']
            ]);
        }
    }
}
