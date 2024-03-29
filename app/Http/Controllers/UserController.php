<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Empresa;
use App\Models\Horario;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Muestra los datos personales del usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user['horarios_id']) {
            $horario = Horario::find($user->horarios_id)->descripcion;
        } else {
            $horario = null;
        }
        $response = [
            'user' => $user,
            'horario' => $horario
        ];
        return response()->json($response);
    }

    /**
     * Muestra los datos de contacto y laborales del empleado.
     *
     * @param  int  $empresaId
     * @param  int  $empleadoId
     * @return \Illuminate\Http\Response
     */
    public function verDetalles($empresaId, $empleadoId)
    {
        $user = User::find($empleadoId);
        if ($user['horarios_id']) {
            $horario = Horario::find($user->horarios_id)->descripcion;
        } else {
            $horario = null;
        }
        $response = [
            'user' => $user,
            'horario' => $horario
        ];
        return response()->json($response);
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
    public function updateAdmin(Request $request, $id)
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
            'horarioId' => ['required', 'exists:horarios,id']
        ]);
        try {
            $usuario = User::select()->where('email', $datos['email'])->firstOrFail();
            if (!empty($usuario->empresas_id)) {
                return response()->json(['error' => 'Empleado ya dado de alta'], 422);
            } else {
                $usuario->empresas_id = $empresaId;
                $usuario->tipo = 'empleado';
                $usuario->fecha_alta = Carbon::now()->toDateString();
                $usuario->horarios_id = $datos['horarioId'];
                $usuario->save();
                return ['mensaje' => "Empleado dado de alta"];
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    }

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
                $usuario->fecha_alta = null;
                $usuario->horarios_id = null;
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
     * Almacena la baja de un empleado del listado datatable desasignándole el id de la empresa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardarBajaDatatable($id)
    {
        $empleado = User::find($id);
        $empleado->empresas_id = null;
        $empleado->tipo = 'usuario';
        $empleado->fecha_alta = null;
        $empleado->horarios_id = null;
        $empleado->save();
        return ['mensaje' => "Empleado dado de baja"];
    }

    /**
     * Almacena la baja pedida por el empleado. Éste pasa a ser usuario sin empresa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $empresaId
     * @param  int  $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function bajaEmpleado(Request $request, $empresaId, $usuarioId)
    {
        $empleado = User::find($usuarioId);
        $empleado->empresas_id = null;
        $empleado->tipo = 'usuario';
        $empleado->fecha_alta = null;
        $empleado->horarios_id = null;
        $empleado->save();
        // Cierro sesión
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return ['mensaje' => "Empleado dado de baja"];
    }

    /**
     * Muestra formulario para reasignar horario a un empleado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $empresaId
     * @return \Illuminate\Http\Response
     */
    public function reasignarHorario(Request $request, $empresaId)
    {
        $empresaId = Empresa::find($empresaId)->id;
        $datos = $request->validate([
            'email' => ['required', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/'],
            'horarioId' => ['required', 'exists:horarios,id']
        ]);
        try {
            $usuario = User::select()->where('email', $datos['email'])->firstOrFail();
            if ($usuario->empresas_id != $empresaId) {
                return response()->json(['error' => 'Empleado no existe'], 422);
            } else {
                $usuario->horarios_id = $datos['horarioId'];
                $usuario->save();
                return ['mensaje' => "Horario de empleado cambiado"];
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    }

    /**
     * Muestra formulario para reasignar el horario del empleado de la datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $empresaId
     * @param  int  $empleadoId
     * @return \Illuminate\Http\Response
     */
    public function cambiarHorario(Request $request, $empresaId, $empleadoId)
    {
        $datos = $request->validate([
            'horarioId' => ['required', 'exists:horarios,id']
        ]);
        $usuario = User::find($empleadoId);
        $usuario->horarios_id = $datos['horarioId'];
        $usuario->save();
        return ['mensaje' => "Horario de empleado cambiado"];
    }

    /**
     * Lista los empleados de la empresa.
     *
     * @param  int $id : ID de la empresa
     * @return \Illuminate\Http\Response
     */
    public function listarEmpleados($id)
    {
        $empleados = User::select('id', 'name', 'apellidos', 'email', 'fecha_alta', 'codpostal', 'empresas_id', 'tipo')
            ->where('empresas_id', $id)
            ->get();

        $empleadosData = $empleados->map(function ($empleado) {
            return [
                'id' => $empleado->id,
                'empresas_id' => $empleado->empresas_id,
                'tipo' => $empleado->tipo,
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

    /**
     * Devuelve la vista de horarios de la empresa.
     *
     * @return \Illuminate\Http\Response
     */
    public function verHorarios()
    {
        return view('admins.horarios');
    }

    /**
     * Devuelve la vista de fichajes de la empresa.
     *
     * @return \Illuminate\Http\Response
     */
    public function verFichajes()
    {
        return view('admins.fichajes');
    }

    /**
     * Devuelve la vista de ausencias de la empresa.
     *
     * @return \Illuminate\Http\Response
     */
    public function verAusencias()
    {
        return view('admins.ausencias');
    }

    /**
     * Devuelve la vista del horario del empleado.
     *
     * @return \Illuminate\Http\Response
     */
    public function miHorario()
    {
        return view('empleados.miHorario');
    }

    /**
     * Devuelve la vista del horario del empleado.
     *
     * @return \Illuminate\Http\Response
     */
    public function misFichajes()
    {
        return view('empleados.misFichajes');
    }

    /**
     * Devuelve la vista de las ausencias del empleado.
     *
     * @return \Illuminate\Http\Response
     */
    public function misAusencias()
    {
        return view('empleados.misAusencias');
    }
}
