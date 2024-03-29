<?php

namespace App\Http\Controllers;

use App\Models\Fichaje;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FichajeController extends Controller
{
    /**
     * Muestra los fichajes de una empresa
     *
     * @param  int  $empresaId
     * @return \Illuminate\Http\Response
     */
    public function index($empresaId)
    {
        $fichajes = Fichaje::select('fichajes.id', 'fichajes.tipo', 'fichajes.fecha_hora_fichaje')
            ->join('empleados', 'fichajes.empleados_id', '=', 'empleados.id')
            ->join('horarios', 'fichajes.horarios_id', '=', 'horarios.id')
            ->where('empleados.empresas_id', $empresaId)
            ->with(['empleados' => function ($query) {
                $query->select('id', 'name', 'apellidos');
            }])
            ->with(['horarios' => function ($query) {
                $query->select('id', 'descripcion');
            }])
            ->selectRaw('fichajes.*, empleados.name as empleado_nombre, empleados.apellidos as empleado_apellidos, horarios.descripcion as horario_descripcion')
            ->get()
            ->map(function ($fichaje) {
                $fechaHora = Carbon::parse($fichaje->fecha_hora_fichaje);
                $fichaje->fecha = $fechaHora->toDateString();
                $fichaje->hora = $fechaHora->toTimeString();
                $fichaje->empleado_nombre = $fichaje->empleados->name;
                $fichaje->empleado_apellidos = $fichaje->empleados->apellidos;
                $fichaje->horario_descripcion = $fichaje->horarios->descripcion;
                unset($fichaje->empleados);
                unset($fichaje->horarios);
                return $fichaje;
            });


        return response()->json($fichajes);
    }

    /**
     * Muestra los fichajes de un empleado de su empresa actual
     *
     * @param  int  $empresaId
     * @param  int  $empleadoId
     * @return \Illuminate\Http\Response
     */
    public function listarFichajes($empresaId, $empleadoId)
    {
        $fichajes = Fichaje::select('fichajes.id', 'fichajes.tipo', 'fichajes.fecha_hora_fichaje')
            ->join('empleados', 'fichajes.empleados_id', '=', 'empleados.id')
            ->join('horarios', 'fichajes.horarios_id', '=', 'horarios.id')
            ->where('empleados_id', $empleadoId)
            ->where('empleados.empresas_id', $empresaId)
            ->with(['empleados' => function ($query) {
                $query->select('id', 'name', 'apellidos');
            }])
            ->with(['horarios' => function ($query) {
                $query->select('id', 'descripcion');
            }])
            ->selectRaw('fichajes.*, empleados.name as empleado_nombre, empleados.apellidos as empleado_apellidos, horarios.descripcion as horario_descripcion')
            ->get()
            ->map(function ($fichaje) {
                $fechaHora = Carbon::parse($fichaje->fecha_hora_fichaje);
                $fichaje->fecha = $fechaHora->toDateString();
                $fichaje->hora = $fechaHora->toTimeString();
                $fichaje->empleado_nombre = $fichaje->empleados->name;
                $fichaje->empleado_apellidos = $fichaje->empleados->apellidos;
                $fichaje->horario_descripcion = $fichaje->horarios->descripcion;
                unset($fichaje->empleados);
                unset($fichaje->horarios);
                return $fichaje;
            });


        return response()->json($fichajes);
    }

    /**
     * Muestra los fichajes que ha hecho hoy
     *
     * @param  int  $empresaId
     * @param  int  $empleadoId
     * @return \Illuminate\Http\Response
     */
    public function infoFichaje($empresaId, $empleadoId)
    {
        $fechaHoy = Carbon::now()->format('Y-m-d');
        $fichajesHoy = Fichaje::where('empleados_id', $empleadoId)
            ->whereDate('fecha_hora_fichaje', $fechaHoy)
            ->count();

        return response()->json($fichajesHoy);
    }

    /**
     * Almacena el fichaje del empleado en la base de datos
     *
     * @param  int  $empresaId
     * @param  int  $empleadoId
     * @param  string  $tipo
     * @return \Illuminate\Http\Response
     */
    public function crearFichaje($empresaId, $empleadoId, $tipo)
    {
        $horariosId = User::find($empleadoId)->horarios_id;

        Fichaje::create([
            'tipo' => $tipo,
            'fecha_hora_fichaje' => Carbon::now(),
            'empleados_id' => $empleadoId,
            'horarios_id' => $horariosId,
        ]);

        return ['mensaje' => "Fichaje realizado"];
    }
}
