<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ////////////////////////////////////////////////////////////
        //       TABLA QUE CONTIENE LOS ROLES DEL EMPLEADO        //
        ////////////////////////////////////////////////////////////
        Schema::create('Roles', function (Blueprint $table) {
            $table->tinyIncrements("id");
            $table->string("nombre");
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
        Schema::dropIfExists('Roles');
    }
}
