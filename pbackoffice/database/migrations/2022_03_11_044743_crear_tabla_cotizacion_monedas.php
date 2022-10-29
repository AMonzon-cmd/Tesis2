<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CotizacionMonedas', function (Blueprint $table) {
            $table->unsignedInteger('moneda_id');
            $table->decimal('compra', 9,3)->comment('El precio siempre es en base al peso UYU');
            $table->decimal('venta', 9,3)->comment('El precio siempre es en base al peso UYU');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CotizacionMonedas');
    }
};
