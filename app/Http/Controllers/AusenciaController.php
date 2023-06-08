<?php

namespace App\Http\Controllers;

use App\Models\Ausencia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AusenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
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
     * Crea la ausencia del empleado para almacenarla en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $empresaId
     * @param  int  $empleadoId
     * @param  string  $tipo
     * @return \Illuminate\Http\Response
     */
    public function crearAusencia(Request $request, $empresaId, $empleadoId, $tipo)
    {
        $datos = $request->validate([
            'fecha_inicio' => ['required', 'date_format:Y-m-d'],
            'fecha_fin' => ['required', 'date_format:Y-m-d', 'after_or_equal:fecha_inicio'],
            'motivos' => ['nullable', 'string', 'max:255']
        ]);
        $datos['tipo'] = $tipo;
        if ($datos['tipo'] == 'Falta') {
            $datos['aceptada'] = 1;
        }
        $datos['empleados_id'] = $empleadoId;
        Ausencia::create($datos);
        return ['mensaje' => "Ausencia creada"];
    }

    /**
     * Muestra la ausencia de hoy si es que hay.
     *
     * @param  int  $empresaId
     * @param  int  $empleadoId
     * @return \Illuminate\Http\Response
     */
    public function infoAusencia($empresaId, $empleadoId)
    {
        $fechaHoy = Carbon::now()->format('Y-m-d');
        $ausenciaHoy = Ausencia::where('empleados_id', $empleadoId)
            ->whereDate('fecha_inicio', '<=', $fechaHoy)
            ->whereDate('fecha_fin', '>=', $fechaHoy)
            ->where('aceptada', 1)
            ->first();

        if ($ausenciaHoy) {
            // Hay ausencia para el día de hoy
            return response()->json($ausenciaHoy->tipo);
        } else {
            return response()->json([], 204);
        }
    }

    /**
     * Lista las ausencias de un tipo concreto de un empleado.
     *
     * @param  int  $empresaId
     * @param  int  $empleadoId
     * @param  string  $tipo
     * @return \Illuminate\Http\Response
     */
    public function listarAusencias($empresaId, $empleadoId, $tipo)
    {
        $ausencias = Ausencia::select([
            '*',
            DB::raw("IF(aceptada IS NULL, 'Pendiente', IF(aceptada = 0, 'Rechazada', 'Aceptada')) AS estado_aceptada")
        ])
            ->where('empleados_id', $empleadoId)
            ->where('tipo', $tipo)
            ->get();

        return response()->json($ausencias);
    }
}
