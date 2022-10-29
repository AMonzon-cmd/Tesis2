<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaUsuariosAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UsuariosBackoffice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email',60)->unique();
            $table->string('pass', 250);
            $table->string('nombre',25);
            $table->string('apellido', 25);
            $table->string('documento', 10)->index();
            $table->unsignedTinyInteger('rol_id');
            $table->unsignedInteger('usuario_genera_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rol_id', 'FK_UsuarioBackoffice_Rol')->references('id')->on('Roles')->onDelete('restrict');
            $table->foreign('usuario_genera_id', 'FK_UsuarioBackoffice_UsuarioGenera')->references('id')->on('UsuariosBackoffice')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('UsuariosBackoffice');
    }
}
