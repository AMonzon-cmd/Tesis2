<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaMonedas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ////////////////////////////////////////////////////////////
        //       TABLA QUE CONTIENE LAS MONEDAS DEL SISTEMA       //
        ////////////////////////////////////////////////////////////
        Schema::create('Monedas', function (Blueprint $table) {
            $table->tinyIncrements("id");
            $table->string("nombre");
            $table->string("simbolo");
            $table->string('isoCodigo');
            $table->unsignedSmallInteger('isoNumerico');
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
        Schema::dropIfExists('Monedas');
    }
}
