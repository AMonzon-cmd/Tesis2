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
        Schema::create('Pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('servicio_id');
            $table->unsignedTinyInteger('moneda_id');
            $table->decimal('monto', 8, 2);
            $table->enum('estado', ['Confirmado', 'Anulado', 'Pendiente']);
            $table->unsignedInteger('medio_de_pago_id')->nullable();
            $table->unsignedSmallInteger('puntaje_generado')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Pagos');
    }
};
