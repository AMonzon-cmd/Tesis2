<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaUsuarios extends Migration
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
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->increments("id");
            $table->enum('tipo', ['Persona Fisica', 'Persona Juridica']);
            $table->string("email",40)->unique();
            $table->string("contrasena", 60);
            $table->string('tokenActivacion', 40)->nullable();
            $table->unsignedInteger("puntos")->default(0);
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
        Schema::dropIfExists('Usuarios');
    }
}
