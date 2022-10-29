<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPersonasEmpleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PersonasEmpleados', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("idUsuario")->unique();
            $table->string("nombre", 50);
            $table->string("apellido", 50);
            $table->string("documento", 15)->unique();
            $table->enum("sexo", ["Masculino", "Femenino", "Otro"]);
            $table->date("fechaNacimiento");
            $table->unsignedTinyInteger("idRol");
            $table->timestamps();

            ///////////////////
            //CLAVES FORANEAS//
            ///////////////////
            $table->foreign('idUsuario', 'FK_Usuario_PersonaEmpleado')->references('id')->on('Usuarios')->onDelete('restrict');
            $table->foreign('idRol', 'FK_Rol_PersonaEmpleado')->references('id')->on('Roles')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PersonasEmpleados');
    }
}
