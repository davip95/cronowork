<?php

namespace App\Http\Controllers;

use App\Models\Ausencia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AusenciaController extends Controller
{
    /**
     * Muestra las ausencias de una empresa.
     *
     * @param  int  $empresaId
     * @return \Illuminate\Http\Response
     */
    public function index($empresaId)
    {
        $faltas = Ausencia::select([
            'ausencias.*',
            DB::raw("IF(aceptada IS NULL, 'Pendiente', IF(aceptada = 0, 'Rechazada', 'Aceptada')) AS estado_aceptada")
        ])
            ->join('empleados', 'ausencias.empleados_id', '=', 'empleados.id')
            ->where('empleados.empresas_id', $empresaId)
            ->where('ausencias.tipo', 'Falta')
            ->with(['empleados' => function ($query) {
                $query->select('id', 'name', 'apellidos');
            }])
            ->selectRaw('empleados.id as empleadoId, empleados.name as empleado_nombre, empleados.apellidos as empleado_apellidos')
            ->get()
            ->map(function ($ausencia) {
                $ausencia->empleadoId = $ausencia->empleados->id;
                $ausencia->name = $ausencia->empleados->name;
                $ausencia->apellidos = $ausencia->empleados->apellidos;
                unset($ausencia->empleados);
                return $ausencia;
            });

        $permisos = Ausencia::select([
            'ausencias.*',
            DB::raw("IF(aceptada IS NULL, 'Pendiente', IF(aceptada = 0, 'Rechazada', 'Aceptada')) AS estado_aceptada")
        ])
            ->join('empleados', 'ausencias.empleados_id', '=', 'empleados.id')
            ->where('empleados.empresas_id', $empresaId)
            ->where('ausencias.tipo', 'Permiso')
            ->with(['empleados' => function ($query) {
                $query->select('id', 'name', 'apellidos');
            }])
            ->selectRaw('empleados.id as empleadoId, empleados.name as empleado_nombre, empleados.apellidos as empleado_apellidos')
            ->get()
            ->map(function ($ausencia) {
                $ausencia->empleadoId = $ausencia->empleados->id;
                $ausencia->name = $ausencia->empleados->name;
                $ausencia->apellidos = $ausencia->empleados->apellidos;
                unset($ausencia->empleados);
                return $ausencia;
            });

        $vacaciones = Ausencia::select([
            'ausencias.*',
            DB::raw("IF(aceptada IS NULL, 'Pendiente', IF(aceptada = 0, 'Rechazada', 'Aceptada')) AS estado_aceptada")
        ])
            ->join('empleados', 'ausencias.empleados_id', '=', 'empleados.id')
            ->where('empleados.empresas_id', $empresaId)
            ->where('ausencias.tipo', 'Vacaciones')
            ->with(['empleados' => function ($query) {
                $query->select('id', 'name', 'apellidos');
            }])
            ->selectRaw('empleados.id as empleadoId, empleados.name as empleado_nombre, empleados.apellidos as empleado_apellidos')
            ->get()
            ->map(function ($ausencia) {
                $ausencia->empleadoId = $ausencia->empleados->id;
                $ausencia->name = $ausencia->empleados->name;
                $ausencia->apellidos = $ausencia->empleados->apellidos;
                unset($ausencia->empleados);
                return $ausencia;
            });

        return response()->json([
            'faltas' => $faltas,
            'permisos' => $permisos,
            'vacaciones' => $vacaciones
        ]);
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
            'ausencias.*',
            DB::raw("IF(aceptada IS NULL, 'Pendiente', IF(aceptada = 0, 'Rechazada', 'Aceptada')) AS estado_aceptada"),
            'empleados.name',
            'empleados.apellidos'
        ])
            ->join('empleados', 'ausencias.empleados_id', '=', 'empleados.id')
            ->where('ausencias.empleados_id', $empleadoId)
            ->where('ausencias.tipo', $tipo)
            ->get();

        return response()->json($ausencias);
    }

    /**
     * Resuelve una solicitud de ausencia aceptándola o rechazándola.
     *
     * @param  int  $empresaId
     * @param  int  $ausenciaId
     * @param  string  $resolucion
     * @return \Illuminate\Http\Response
     */
    public function resolverSolicitud($empresaId, $ausenciaId, $resolucion)
    {
        if ($resolucion == 'aceptar') {
            $ausencia['aceptada'] = 1;
        } else if ($resolucion == 'rechazar') {
            $ausencia['aceptada'] = 0;
        }

        Ausencia::find($ausenciaId)->update($ausencia);
        return response("Solicitud de ausencia resuelta");
    }
}
