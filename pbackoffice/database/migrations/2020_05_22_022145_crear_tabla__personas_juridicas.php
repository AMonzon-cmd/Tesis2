<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPersonasJuridicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ////////////////////////////////////////////////////////////
        //      TABLA QUE CONTIENE LOS USUARIOS DEL SISTEMA       //
        ////////////////////////////////////////////////////////////   
        Schema::create('PersonasJuridicas', function (Blueprint $table) {
            $table->unsignedInteger("idUsuario");
            $table->string("razonSocial", 100);
            $table->string("nombreFantasia", 100);
            $table->string("rut", 30)->unique();
            $table->enum("formaJuridica",["UNI", "SRL", "SA", "Otra"]);
            $table->date("fechaConformacion");
            $table->timestamps();

            ///////////////////
            //CLAVES FORANEAS//
            ///////////////////
            $table->primary('idUsuario');
            $table->foreign('idUsuario', 'FK_Usuario_PersonaJuridica')->references('id')->on('Usuarios')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PersonasJuridicas');
    }
}
