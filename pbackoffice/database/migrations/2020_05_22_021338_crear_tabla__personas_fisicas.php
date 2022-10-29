<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPersonasFisicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         ////////////////////////////////////////////////////////////
        //   TABLA QUE CONTIENE LAS PERSONAS FISICAS DEL SISTEMA   //
        ////////////////////////////////////////////////////////////
        Schema::create('PersonasFisicas', function (Blueprint $table) {
            $table->unsignedInteger("idUsuario")->unique();
            $table->string("nombre", 50);
            $table->string("apellido", 50)->nullable();
            $table->string("documento", 15)->unique();
            $table->enum("sexo", ["masculino", "femenino", "otro"]);
            $table->date("fechaNacimiento")->nullable();
            $table->timestamps();
            
            ///////////////////
            //CLAVES FORANEAS//
            ///////////////////
            $table->primary('idUsuario');
            $table->foreign('idUsuario', 'FK_Usuario_PersonaFisica')->references('id')->on('Usuarios')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PersonasFisicas');
    }
}
