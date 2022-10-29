<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = array(
            array(
                'nombre' => 'Listado Clientes',
                'slug' => 'listado_clientes'
            ),
            array(
                'nombre' => 'Listado Servicios',
                'slug' => 'listado_servicios'
            ),
            array(
                'nombre' => 'ABM Servicios',
                'slug' => 'abm_servicios'
            ),
            array(
                'nombre' => 'Listado Productos',
                'slug' => 'listado_productos'
            ),
            array(
                'nombre' => 'ABM Productos',
                'slug' => 'abm_productos'
            ),
            array(
                'nombre' => 'Listado Pagos',
                'slug' => 'listado_pagos'
            ),
            array(
                'nombre' => 'ABM Pagos',
                'slug' => 'abm_pagos'
            ),
            array(
                'nombre' => 'Listado Publicidades',
                'slug' => 'listado_publicidades'
            ),
            array(
                'nombre' => 'ABM Publicidades',
                'slug' => 'abm_publicidades'
            ),
            array(
                'nombre' => 'Configuracion',
                'slug' => 'configuracion'
            ),
            array(
                'nombre' => 'ABM Empleados',
                'slug' => 'abm_empleados'
            ),
            array(
                'nombre' => 'ABM Roles',
                'slug' => 'abm_roles'
            ),
            array(
                'nombre' => 'Listado Empleados',
                'slug' => 'listado_empleados'
            ),
            array(
                'nombre' => 'ABM Clientes',
                'slug' => 'abm_clientes'
            ),
            array(
                'nombre' => 'Listado Roles',
                'slug' => 'listado_roles'
            ),
            array(
                'nombre' => 'ABM Roles',
                'slug' => 'abm_roles'
            ),
            array(
                'nombre' => 'Modificacion Permisos',
                'slug' => 'modificacion_permisos'
            ),
        );


        foreach ($permisos as $key => $permiso) {
            $id = DB::table('Permisos')->insertGetId([
                'nombre' => $permiso['nombre'],
                'slug' => $permiso['slug'],
            ]);

            DB::table('PermisosDeRoles')->insert([
                'rol_id' => 1,
                'permiso_id' => $id,
            ]);

            if(in_array($id, [1, 2, 4, 6, 8])){
                DB::table('PermisosDeRoles')->insert([
                    'rol_id' => 2,
                    'permiso_id' => $id,
                ]);
            }

            if(!in_array($id, [1,2,4,6])){
                DB::table('PermisosDeRoles')->insert([
                    'rol_id' => 3,
                    'permiso_id' => $id,
                ]);
            }
        }

    }
}
