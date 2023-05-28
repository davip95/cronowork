<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $datos = $request->validate([
            'name' => ['nullable', 'max:255', 'string'],
            'email' => ['nullable', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', Rule::unique('empleados')->ignore($id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults(), 'max:255'],
            'apellidos' => ['nullable', 'max:255', 'string'],
            'telefono' => ['nullable', 'max:45', 'regex:/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/'],
            'direccion' => ['nullable', 'max:255', 'string'],
            'codpostal' => ['nullable', 'max:45', 'regex:/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'],
        ]);
        if (!empty($datos['password'])) {
            $datos['password'] = Hash::make($request->password);
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        User::find($id)->delete();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return ['mensaje' => "borrado"];
    }

    /**
     * Actualiza el admin de la empresa. El anterior pasa a ser empleado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmpleado(Request $request, $id)
    {
        $datos = $request->validate([
            'email' => ['required', 'confirmed', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/'],
        ]);
        try {
            $nuevoEmpleado = User::select()->where('empresas_id', $id)->where('email', $datos['email'])->firstOrFail();
            $nuevoEmpleado->tipo = 'admin';
            $nuevoEmpleado->save();
            $exEmpleado = User::find(Auth::user()->id);
            $exEmpleado->tipo = 'empleado';
            $exEmpleado->save();
            // Cierro sesión
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return ['mensaje' => "Empleado cambiado"];
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    }

    /**
     * Muestra formulario para dar de alta en una empresa a un usuario. Se le asignará empresa y horario.
     *
     * @return \Illuminate\Http\Response
     */
    // public function crearAlta()
    // {
    //     //
    // }

    /**
     * Almacena el alta de un usuario en la empresa asignándole el id de la empresa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardarAlta(Request $request)
    {
        $empresaId = User::find(Auth::user()->id)->empresas_id;
        $datos = $request->validate([
            'email' => ['required', 'confirmed', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/'],
        ]);
        try {
            $usuario = User::select()->where('email', $datos['email'])->firstOrFail();
            if (!empty($usuario->empresas_id)) {
                return response()->json(['error' => 'Empleado ya dado de alta'], 422);
            } else {
                $usuario->empresas_id = $empresaId;
                $usuario->tipo = 'empleado';
                $usuario->save();
                return ['mensaje' => "Empleado dado de alta"];
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    }

    /**
     * Muestra formulario para dar de baja en una empresa a un empleado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function crearBaja($id)
    // {
    //     //
    // }

    /**
     * Almacena la baja de un empleado desasignándole el id de la empresa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardarBaja(Request $request)
    {
        $empresaId = User::find(Auth::user()->id)->empresas_id;
        $datos = $request->validate([
            'email' => ['required', 'confirmed', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/'],
        ]);
        try {
            $usuario = User::select()->where('email', $datos['email'])->firstOrFail();
            if (empty($usuario->empresas_id)) {
                return response()->json(['error' => 'Empleado ya dado de baja'], 422);
            } else if ($usuario->empresas_id == $empresaId) {
                $usuario->empresas_id = null;
                $usuario->tipo = 'usuario';
                $usuario->save();
                return ['mensaje' => "Empleado dado de baja"];
            } else {
                return response()->json(['error' => 'Empleado no encontrado'], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
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
        $empleados = User::select('name', 'apellidos', 'email', 'fecha_alta', 'codpostal')
            ->where('empresas_id', $id)
            ->get();

        $empleadosData = $empleados->map(function ($empleado) {
            return [
                'name' => $empleado->name,
                'apellidos' => $empleado->apellidos,
                'email' => $empleado->email,
                'fecha_alta' => $empleado->fecha_alta,
                'codpostal' => $empleado->codpostal,
            ];
        });

        return response()->json([
            'data' => $empleadosData
        ]);
    }

    /**
     * Devuelve la vista de empleados de la empresa.
     *
     * @return \Illuminate\Http\Response
     */
    public function verEmpleados()
    {
        return view('admins.empleados');
    }
}
