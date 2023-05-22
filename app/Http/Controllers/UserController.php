<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra formulario para editar datos personales del usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Actualiza los datos personales del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Elimina (soft delete) el usuario sin empresa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Muestra el formulario para borrar (soft delete) el usuario sin empresa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function borrar($id)
    {
        //
    }

    /**
     * Muestra formulario para dar de alta en una empresa a un usuario. Se le asignará empresa y horario.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearAlta()
    {
        //
    }

    /**
     * Almacena el alta de un usuario en la empresa asignándole el id de la empresa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardarAlta(Request $request)
    {
        //
    }

    /**
     * Muestra formulario para dar de baja en una empresa a un empleado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function crearBaja($id)
    {
        //
    }

    /**
     * Almacena la baja de un empleado desasignándole el id de la empresa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardarBaja(Request $request, $id)
    {
        //
    }

    /**
     * Muestra formulario para cambiar el horario del empleado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cambiarHorario($id)
    {
        //
    }

    /**
     * Asigna el horario de la empresa a un empleado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function asignarHorario(Request $request, $id)
    {
        //
    }

    /**
     * Lista los empleados de la empresa.
     *
     * @param  int $id : ID de la empresa
     * @return \Illuminate\Http\Response
     */
    public function listarEmpleados($id)
    {
        //
    }
}
