<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Reclamos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fechas = ['2022-10-13','2022-10-14','2022-10-15', '2022-10-16', '2022-10-17', '2022-10-18', '2022-10-19', '2022-10-20' ,'2022-10-21' ,'2022-10-22' ,'2022-10-23', '2022-10-24', '2022-10-25'];
        
        for ($i=0; $i < 100 ; $i++) { 
            DB::table('RelProductoUsuario')->insert([
                'usuario_id' => rand(1,5),
                'producto_id' => rand(1,6),
                'puntos_usuario' => rand(1,10),
                'puntos_producto' => rand(1,10),
                'fecha_reclamo' => (rand(1,5) == 5) ? '2022-10-23' : null,
                'created_at' => $fechas[rand(0,10)]
            ]);
        }
    }
}
