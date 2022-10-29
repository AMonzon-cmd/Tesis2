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
                'img'    => 'https://www.impacto.com.pe/storage/products/16155685082.jpg'
            ),
            array(
                'nombre' => 'Audifonos RGB',
                'descripcion' => 'Audifonos USB con microfono y RGB',
                'costo'  => 50,
                'stock'  => 3,
                'img'    => 'https://m.media-amazon.com/images/I/71A-tk9Bh-L._AC_SS450_.jpg'
            ),
            array(
                'nombre' => 'Cuadro',
                'descripcion' => 'Cuadro de bosque y montañas',
                'costo'  => 15,
                'stock'  => 2,
                'img'    => 'https://http2.mlstatic.com/D_NQ_NP_729952-MLU50418111956_062022-O.webp'
            ),
            array(
                'nombre' => 'Monitor Dell',
                'descripcion' => 'Monitor 32 pulgadas Dell',
                'costo'  => 135,
                'stock'  => 1,
                'img'    => 'https://m.media-amazon.com/images/I/81UXLSVxOSL._AC_SL1500_.jpg'
            ),
            // array(
            //     'nombre' => 'Skateboard',
            //     'descripcion' => 'Skateboard electrico con control remoto',
            //     'costo'  => 65,
            //     'stock'  => 1,
            //     'img'    => 'https://m.media-amazon.com/images/I/61oqnLTXIwL._AC_SL1500_.jpg'
            // ),
            array(
                'nombre' => 'Championes Adidas',
                'descripcion' => 'Adidas Mens X9000l3 Running',
                'costo'  => 95,
                'stock'  => 25,
                'img'    => 'https://m.media-amazon.com/images/I/71ieUTYz2QS._AC_UL1500_.jpg'
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
