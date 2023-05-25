<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

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
        $user = User::find($id);
        return response()->json($user);
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

        // $userEmail = User::find($id)->email;
        // // Pongo vacío el email del array para no validarlo y eliminarlo luego si es el mismo ya que daría error al existir y ser un campo unique
        // if ($userEmail == $request->email) {
        //     $request['email'] = '';
        // }
        $datos = $request->validate([
            'name' => ['nullable', 'max:255', 'string'],
            'email' => ['nullable', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', Rule::unique('empleados')->ignore($id)],
            'apellidos' => ['nullable', 'max:255', 'string'],
            'telefono' => ['nullable', 'max:45', 'regex:/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/'],
            'direccion' => ['nullable', 'max:255', 'string'],
            'codpostal' => ['nullable', 'max:45', 'regex:/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'],
        ]);
        // Convertir los strings vacíos a null
        foreach ($datos as $key => $value) {
            if (is_string($value) && $value === '') {
                $data[$key] = null;
            }
        }
        // Elimino los campos nulos del array
        $datos = array_filter($datos);

        User::find($id)->update($datos);
        return ['mensaje' => "actualizado"];
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
