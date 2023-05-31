<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornadas', function (Blueprint $table) {
            $table->id();
            $table->integer('dia');
            $table->integer('minutos_descanso');
            $table->integer('minutos_descanso_intensiva')->nullable();
            $table->time('hora_inicio');
            $table->time('hora_inicio_intensiva')->nullable();
            $table->time('hora_fin');
            $table->time('hora_fin_intensiva')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('jornadas');
    }
}
