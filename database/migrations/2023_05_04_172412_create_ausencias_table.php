<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAusenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ausencias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 45);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('aceptada')->nullable();
            $table->string('motivos')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('empleados_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ausencias');
    }
}
