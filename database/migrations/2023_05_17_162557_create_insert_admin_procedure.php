<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInsertAdminProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "DROP PROCEDURE IF EXISTS `insertarAdmin`;
        CREATE PROCEDURE `insertarAdmin`(
            IN p_name VARCHAR(255),
            IN p_email VARCHAR(191),
            IN p_password VARCHAR(255),
            IN p_apellidos VARCHAR(255),
            IN p_telefono VARCHAR(45),
            IN p_direccion VARCHAR(255),
            IN p_tipo VARCHAR(45),
            IN p_empresas_id INT
          )
          BEGIN
            INSERT INTO empleados (name, email, password, apellidos, telefono, direccion, tipo, empresas_id)
            VALUES (p_name, p_email, p_password, p_apellidos, p_telefono, p_direccion, p_tipo, p_empresas_id);
          END;";

        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
