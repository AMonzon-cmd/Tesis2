<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPublicidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Publicidad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img', 300);
            $table->string('url', 300)->nullable();
            $table->unsignedInteger('usuario_admin_id');
            $table->timestamp('fecha_desde')->useCurrent();
            $table->timestamp('fecha_hasta')->nullable();
            $table->timestamps();
            $table->softDeletes();
            //$table->foreign('usuario_admin_id', 'FK_Publicidad_UsuarioBackoffice')->references('id')->on('UsuarioBackoffice')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Publicidad');
    }
}
