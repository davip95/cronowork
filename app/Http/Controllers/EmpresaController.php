<?php

namespace App\Http\Controllers;

use App\Models\Ausencia;
use App\Models\Empresa;
use App\Models\Fichaje;
use App\Models\Horario;
use App\Models\Jornada;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{
    /**
     * Muestra los datos de la empresa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa = Empresa::find($id);
        return response()->json($empresa);
    }

    /**
     * Actualiza los datos de la empresa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'nombre' => ['nullable', 'max:255', 'string'],
            'cif' => ['nullable', 'max:255', 'regex:/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/', Rule::unique('empresas')->ignore($id)],
            'correo' => ['nullable', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/'],
            'telefono' => ['nullable', 'max:45', 'regex:/(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/'],
            'direccion' => ['nullable', 'max:255', 'string'],
            'codigo_postal' => ['nullable', 'max:45', 'regex:/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'],
        ]);
        // Convertir los strings vacíos a null
        foreach ($datos as $key => $value) {
            if (is_string($value) && $value === '') {
                $data[$key] = null;
            }
        }
        // Elimino los campos nulos del array
        $datos = array_filter($datos);

        Empresa::find($id)->update($datos);
        return ['mensaje' => "actualizado"];
    }

    /**
     * Elimina (soft delete) la empresa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $empresa = Empresa::find($id);
        $horarios = Horario::select()->where('empresas_id', $id)->get();
        // Borro jornadas
        foreach ($horarios as $horario) {
            $jornadas = Jornada::select()->where('horarios_id', $horario->id)->get();
            foreach ($jornadas as $jornada) {
                $jornada->delete();
            }
        }
        $empleados = User::select()->where('empresas_id', $id)->get();
        // Borro ausencias y fichajes
        foreach ($empleados as $empleado) {
            $ausencias = Ausencia::select()->where('empleados_id', $empleado->id)->get();
            foreach ($ausencias as $ausencia) {
                $ausencia->delete();
            }
            $fichajes = Fichaje::select()->where('empleados_id', $empleado->id)->get();
            foreach ($fichajes as $fichaje) {
                $fichaje->delete();
            }
        }
        // Borro empleados
        foreach ($empleados as $empleado) {
            $empleado->delete();
        }
        // Borro horarios
        foreach ($horarios as $horario) {
            $horario->delete();
        }
        // Borro empresa
        $empresa->delete();

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return ['mensaje' => "Empresa borrada"];
    }
}
