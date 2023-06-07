<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Horario;
use App\Models\Jornada;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Comprueba si algun empleado tiene asignado ese horario
        $empleadosHorario = User::select()->where('horarios_id', $horarioId)->get();
        if ($empleadosHorario->isEmpty()) {
            // La colección está vacía
            $asignado = false;
        } else {
            // La colección no está vacía
            $asignado = true;
        }

        $response = [
            'horario' => $horario,
            'intensivo' => $intensivo,
            'asignado' => $asignado
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
     * Muestra los datos de todas las jornadas de un horario.
     *
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @return \Illuminate\Http\Response
     */
    public function verJornadas($empresaId, $horarioId)
    {
        $jornadas = Jornada::select()->where("horarios_id", $horarioId)->get();
        return response()->json($jornadas);
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
            return response()->json([], 204);
        }
    }

    /**
     * Elimina (soft delete) el horario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $empresaId, $horarioId)
    {
        $jornadas = Jornada::select()->where('horarios_id', $horarioId)->get();
        foreach ($jornadas as $jornada) {
            $jornada->delete();
        }
        Horario::find($horarioId)->delete();
        return ['mensaje' => "borrado"];
    }

    /**
     * Crea el nuevo horario de la empresa y lo asigna al admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $empresaId
     * @param  int  $empleadoId
     * @param  string  $empleadoId
     * @return \Illuminate\Http\Response
     */
    public function crearHorario(Request $request, $empresaId, $empleadoId, $dt = 'false')
    {
        $empresaId = Empresa::find($empresaId)->id;
        $esIntensivo = $request->intensivo;
        // Si es intensivo, valido los campos correspondientes a la jornada intensiva
        if ($esIntensivo === "true") {
            $fechaIniInt = $request->fecha_inicio_intensivo;
            $datos = $request->validate([
                'descripcion' => ['required', 'max:255', 'string'],
                'fecha_inicio_intensivo' => ['required', 'date_format:Y-m-d'],
                'fecha_fin_intensivo' => ['required', 'date_format:Y-m-d', function ($attribute, $value, $fail) use ($fechaIniInt) {
                    if ($value <= $fechaIniInt) {
                        $fail('La fecha final debe ser posterior a la inicial.');
                    }
                }],
                'dias' => ['required', 'array', function ($attribute, $value, $fail) {
                    if (count($value) == 0) {
                        $fail('Debe seleccionar al menos un día de jornada laboral.');
                    }
                }],
                'minutos_descanso' => ['required', 'numeric', 'integer', 'min:0', 'max:720'],
                'minutos_descanso_intensiva' => ['required', 'numeric', 'integer', 'min:0', 'max:720'],
                'hora_inicio' => ['required', 'date_format:H:i'],
                'hora_inicio_intensiva' => ['required', 'date_format:H:i'],
                'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
                'hora_fin_intensiva' => ['required', 'date_format:H:i', 'after:hora_inicio_intensiva'],
            ]);
        } else {
            $datos = $request->validate([
                'descripcion' => ['required', 'max:255', 'string'],
                'dias' => ['required', 'array', function ($attribute, $value, $fail) {
                    if (count($value) == 0) {
                        $fail('Debe seleccionar al menos un día de jornada laboral.');
                    }
                }],
                'minutos_descanso' => ['required', 'numeric', 'integer', 'min:0', 'max:720'],
                'hora_inicio' => ['required', 'date_format:H:i'],
                'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            ]);
        }
        if ($esIntensivo === "true") {
            // Creo el array para la creacion del registro horario en la bd
            $datosHorario['descripcion'] = $datos['descripcion'];
            $datosHorario['fecha_inicio_intensivo'] = $datos['fecha_inicio_intensivo'];
            $datosHorario['fecha_fin_intensivo'] = $datos['fecha_fin_intensivo'];
            $datosHorario['empresas_id'] = $empresaId;

            // Creo el horario
            $horario = Horario::create($datosHorario);

            // Creo el array para la creacion del registro jornada en la bd
            $datosJornada = [];
            foreach ($datos['dias'] as $indice => $valor) {
                $datosJornada = [
                    'dia' => $valor,
                    'minutos_descanso' => $datos['minutos_descanso'],
                    'minutos_descanso_intensiva' => $datos['minutos_descanso_intensiva'],
                    'hora_inicio' => $datos['hora_inicio'],
                    'hora_inicio_intensiva' => $datos['hora_inicio_intensiva'],
                    'hora_fin' => $datos['hora_fin'],
                    'hora_fin_intensiva' => $datos['hora_fin_intensiva'],
                    'horarios_id' => $horario->id
                ];
                // Creo la jornada
                Jornada::create($datosJornada);
            }
        } else {
            // Creo el horario
            $datosHorario['descripcion'] = $datos['descripcion'];
            $datosHorario['empresas_id'] = $empresaId;
            $horario = Horario::create($datosHorario);

            // Creo los datos de la jornada y luego creo la jornada
            $datosJornada = [];
            foreach ($datos['dias'] as $indice => $valor) {
                $datosJornada = [
                    'dia' => $valor,
                    'minutos_descanso' => $datos['minutos_descanso'],
                    'hora_inicio' => $datos['hora_inicio'],
                    'hora_fin' => $datos['hora_fin'],
                    'horarios_id' => $horario->id
                ];

                // Creo la jornada
                Jornada::create($datosJornada);
            }
        }
        // Aquí compruebo si solo tengo que crear horario (la opcion en la datatable de horario) o si además debo asignarlo al admin (el primer horario de la empresa)
        if ($dt === 'false') {
            // Asigno horario al admin
            $usuario = User::find($empleadoId);
            $usuario->horarios_id = $horario->id;
            $usuario->save();
        }
        return ['nuevo_horario' => $horario->id];
    }
}
