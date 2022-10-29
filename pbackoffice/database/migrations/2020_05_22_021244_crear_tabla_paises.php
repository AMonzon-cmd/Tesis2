<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPaises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Paises', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nombre', 50);
            $table->string('isoAlfa', 3);
            $table->unsignedSmallInteger('isoNumerico');
            $table->string('prefijo', 5);
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
        Schema::dropIfExists('Paises');
    }
}
