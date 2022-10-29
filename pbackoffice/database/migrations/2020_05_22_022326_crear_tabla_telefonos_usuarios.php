<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaTelefonosUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TelefonosUsuarios', function (Blueprint $table) {
            $table->unsignedInteger("idUsuario");
            $table->enum('tipo', ['Celular', 'Linea']);
            $table->string("numero", 40);
            $table->unsignedTinyInteger('idPais');
            $table->timestamps();
            $table->softDeletes();

            ///////////////////
            //CLAVES FORANEAS//
            ///////////////////
            $table->primary(['idUsuario', 'numero', 'idPais']);
            $table->foreign('idUsuario', 'FK_Telefono_Usuario')->references('id')->on('Usuarios')->onDelete('restrict');
            $table->foreign('idPais', 'FK_Telefono_Pais')->references('id')->on('Paises')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TelefonosUsuarios');
    }
}
