<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //$this->call(TablaTiposUsuariosSeeder::class);//----------------------> Tipos de Usuarios del Sistemaphp
        $this->call(ProductosSeeder::class);
        $this->call(ServiciosSeeder::class);
        $this->call(TablaMonedasSeeder::class);//----------------------> Monedas del Sistema
        $this->call(TablaRolesSeeder::class);//----------------------> Roles del Sistema
        $this->call(ClientesSeeder::class);
        $this->call(TablaUsuarioEmpleadoSeeder::class);//----------------------> Monedas del Sistema
        $this->call(PermisosSeeder::class);
        $this->call(PagosSeeder::class);
        $this->call(Reclamos::class);
    }
}
