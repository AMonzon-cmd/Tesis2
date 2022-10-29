<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaMonedasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monedas = array(
            "1" => array(
                'nombre' => 'Pesos Uruguayos',
                'simbolo' => '$',
                'activo' => 1,
            ),
            "2" => array(
                'nombre' => 'Dolar Estadounidense',
                'simbolo' => 'U$S',
                'activo' => 1,
            ),
        );


        foreach ($monedas as $key => $moneda) {
            DB::table('Monedas')->insert([
             'nombre' => $moneda['nombre'],
             'simbolo' => $moneda['simbolo'],
             'isoCodigo' => '1',
             'isoNumerico' => '1',
             'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
             'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } 

        DB::table('CotizacionMonedas')->insert([
            'moneda_id' => 2,
            'compra' => 41,
            'venta' => 41,
           ]);
    }
}
