<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TablaUsuarioEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = array(
            "1" => array(
                'email' => 'sistemas@netcodesolutions.com',
                'password' => Hash::make('$istema$00'),
                'nombre' => 'Sistemas',
                'apellido' => 'Netcode',
                'documento' => '000000000',
                'rol'       => 1
            ),
            "2" => array(
                'email' => 'operario@netcodesolutions.com',
                'password' => Hash::make('operario123'),
                'nombre' => 'Operario',
                'apellido' => 'Netcode',
                'documento' => '000000001',
                'rol'       => 2
            ),
            "3" => array(
                'email' => 'mod@netcodesolutions.com',
                'password' => Hash::make('moderador123'),
                'nombre' => 'Operario',
                'apellido' => 'Netcode',
                'documento' => '000000002',
                'rol'       => 3
            ),
        );


        foreach ($usuarios as $key => $usuario) {
            DB::table('UsuariosBackoffice')->insert([
             'email' => $usuario['email'],
             'pass' => $usuario['password'],
             'nombre' => $usuario['nombre'],
             'apellido' => $usuario['apellido'],
             'documento' => $usuario['documento'],
             'rol_id' => $usuario['rol'],
             'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
             'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } 


    }
}
