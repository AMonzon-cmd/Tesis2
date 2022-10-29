<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $montos = [50, 100, 200, 250, 280, 350, 400, 650, 1000];
        $fechas = ['2022-10-13','2022-10-14','2022-10-15', '2022-10-16', '2022-10-17', '2022-10-18', '2022-10-19', '2022-10-20' ,'2022-10-21' ,'2022-10-22' ,'2022-10-23', '2022-10-24', '2022-10-25'];

        for ($i=0; $i < 100 ; $i++) { 
            DB::table('Pagos')->insert([
                'usuario_id' => rand(1,5),
                'servicio_id' => rand(1,9),
                'moneda_id' => rand(1,2),
                'monto' => $montos[rand(0,8)],
                'estado' => (rand(1,6) == 5) ? 'Anulado' : 'Confirmado',
                'puntaje_generado' => rand(1, 20),
                'created_at' => $fechas[rand(0, 12)]
            ]);
        }
    }
}
