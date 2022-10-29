<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = array(
            array(
                'nombre' => 'Notebook ACER A3',
                'descripcion' => 'Una notebook acer I5 con 8GB de ram',
                'costo'  => 250,
                'stock'  => 5,
                'img'   => 'https://netpc.uy/wp-content/uploads/2020/10/1-142-5.jpg'
            ),
            array(
                'nombre' => 'Celular Xiaomi',
                'descripcion' => 'Celular cuad-core con 6GB de ram. Pantalla 5 pulgadas',
                'costo'  => 150,
                'stock'  => 2,
                'img'    => 'https://f.fenicio.app/imgs/28185b/www.covercompany.com.uy/coveuy/0c2b/original/catalogo/2-2487_7875_1/2000-2000/celular-xiaomi-redmi-note-10-pro-64gb-6gb-ram-gradient-bronze.jpg',
            ),
            array(
                'nombre' => 'Campera Adidas',
                'descripcion' => 'Campera marca adidas de color azul',
                'costo'  => 100,
                'stock'  => 10,
                'img'    => 'https://f.fenicio.app/imgs/7f64c3/www.globalsports.com.uy/gls/d34d/webp/catalogo/ADGK9035-1024-1/460x460/campera-adidas-essentials-3-tiras-blue.jpg'
            ),
            array(
                'nombre' => 'Teclado y Mouse',
                'descripcion' => 'Teclado y mouse inalambricos marca HP',
                'costo'  => 95,
                'stock'  => 25,
                'img'    => 'https://www.nnet.com.uy/productos/imgs/combo-teclado---mouse-cliptec-rzk339s-inalambrico-negro-nnet-66651-35.jpg'
            )
        );

        foreach ($productos as $key => $producto) {
            DB::table('ProductosCatalogo')->insert([
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'],
                'costo' => $producto['costo'],
                'stock' => $producto['stock'],
                'img'   => $producto['img']
            ]);
        }
    }
}
