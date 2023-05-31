<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Jornada;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Muestra los datos del horario.
     *
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @return \Illuminate\Http\Response
     */
    public function show($empresaId, $horarioId)
    {
        $horario = Horario::find($horarioId);
        return response()->json($horario);
    }

    /**
     * Muestra los datos del horario del empleado.
     *
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @param  int  $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function verHorario($empresaId, $horarioId, $usuarioId)
    {
        $horario = Horario::find($horarioId);
        return response()->json($horario);
    }

    /**
     * Muestra los datos de la jornada.
     *
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @return \Illuminate\Http\Response
     */
    public function verJornada($empresaId, $horarioId)
    {
        $numDia = date("N");
        $jornadaHoy = Jornada::select()->where("horarios_id", $horarioId)->where("dia", $numDia)->first();
        if ($jornadaHoy) {
            // Hay jornada para el día de hoy
            return response()->json($jornadaHoy);
        } else {
            return response()->json(['error' => 'No tiene jornada hoy'], 404);
        }
    }

    /**
     * Muestra los datos de la jornada del empleado.
     *
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @param  int  $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function verJornadaPropia($empresaId, $horarioId, $usuarioId)
    {
        $numDia = date("N");
        $jornadaHoy = Jornada::select()->where("horarios_id", $horarioId)->where("dia", $numDia)->first();
        if ($jornadaHoy) {
            // Hay jornada para el día de hoy
            return response()->json($jornadaHoy);
        } else {
            return response()->json(['error' => 'No tiene jornada hoy'], 404);
        }
    }


    /**
     * Actualiza los datos del horario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $empresaId, $horarioId)
    {
        //
    }

    /**
     * Elimina (soft delete) el horario.
     *
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @return \Illuminate\Http\Response
     */
    public function destroy($empresaId, $horarioId)
    {
        //
    }
}
