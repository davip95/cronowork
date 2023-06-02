<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Jornada;
use DateTime;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Muestra los horarios de la empresa.
     *
     * @param  int  $empresaId
     * @return \Illuminate\Http\Response
     */
    public function index($empresaId)
    {
        $horarios = Horario::select()->where('empresas_id', $empresaId)->get();

        return response()->json($horarios);
    }

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
        $intensivo = $this->isIntensivo($horario);

        $response = [
            'horario' => $horario,
            'intensivo' => $intensivo
        ];

        return response()->json($response);
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
        $intensivo = $this->isIntensivo($horario);

        $response = [
            'horario' => $horario,
            'intensivo' => $intensivo
        ];

        return response()->json($response);
    }

    /**
     * Comprueba si un horario es intensivo o no
     *
     * @param  Horario $horario
     * @return Boolean
     */
    private function isIntensivo($horario)
    {
        $fechaActual = new DateTime();
        $fechaInicioIntensivo = $horario->fecha_inicio_intensivo
            ? new DateTime($horario->fecha_inicio_intensivo)
            : null;
        $fechaFinIntensivo = $horario->fecha_fin_intensivo
            ? new DateTime($horario->fecha_fin_intensivo)
            : null;
        $inicioIntensivo = $this->getFechaSinAnio($fechaInicioIntensivo);
        $finIntensivo = $this->getFechaSinAnio($fechaFinIntensivo);
        $actualSinAnio = $this->getFechaSinAnio($fechaActual);

        return $actualSinAnio >= $inicioIntensivo && $actualSinAnio <= $finIntensivo;
    }

    /**
     * Obtiene la fecha con un año fijo para comparar fechas almacenadas con fechas actuales
     *
     * @param  mixed $fecha
     * @return void
     */
    private function getFechaSinAnio($fecha)
    {
        if (!$fecha) return null;
        return new DateTime('2000-' . $fecha->format('m-d'));
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
            return response()->json([], 204);
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
