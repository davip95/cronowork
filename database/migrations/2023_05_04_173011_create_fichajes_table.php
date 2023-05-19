<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichajes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 45);
            $table->dateTime('fecha_hora_fichaje');
            $table->boolean('modificado')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('empleados_id');
            $table->unsignedBigInteger('horarios_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichajes');
    }
}
