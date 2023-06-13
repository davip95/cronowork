<?php

namespace Tests\Feature;

use App\Models\Ausencia;
use App\Models\Empresa;
use App\Models\Fichaje;
use App\Models\Horario;
use App\Models\Jornada;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RutasTest extends TestCase
{
    public function test_home()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_ver_usuario()
    {
        $usuario = User::first();
        $response = $this->actingAs($usuario)
            ->get('usuarios/' . $usuario->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'horario',
            ]);
    }

    public function test_admin_ver_jornadas()
    {
        $usuario = User::where('tipo', 'admin')->first();
        $horarioId = $usuario->horarios_id;

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/horarios/' . $usuario->horarios_id . '/jornadas/detalles');

        $response->assertStatus(200)
            ->assertJson(Jornada::where("horarios_id", $horarioId)->get()->toArray());
    }

    public function test_admin_ver_empresa()
    {
        $usuario = User::where('tipo', 'admin')->first();
        $empresaId = $usuario->empresas_id;

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id);

        $response->assertStatus(200)
            ->assertJson(Empresa::where("id", $empresaId)->first()->toArray());
    }

    public function test_admin_ver_ausencias_empresa()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/ausencias');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'faltas',
                'permisos',
                'vacaciones',
            ]);
    }

    public function test_admin_ver_ausencias_vista()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/ausencias/listar');

        if ($response->status() == 302) {
            $response = $this->followRedirects($response);
        }
        $response->assertViewIs('admins.ausencias');
    }

    public function test_admin_ver_empleados_vista()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados');

        if ($response->status() == 302) {
            $response = $this->followRedirects($response);
        }
        $response->assertViewIs('admins.empleados');
    }

    public function test_admin_ver_empleados_empresa()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados/admin/listar');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function test_admin_ver_detalles_empleado()
    {
        $usuario = User::where('tipo', 'admin')->first();
        $empleado = User::where('tipo', 'empleado')->where('empresas_id', $usuario->empresas_id)->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados/' . $empleado->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'horario',
            ]);
    }

    public function test_empleado_info_ausencia()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        // Simulo una fecha para hoy
        $fechaHoy = Carbon::now()->format('Y-m-d');

        $ausenciaHoy = Ausencia::where('empleados_id', $usuario->id)
            ->whereDate('fecha_inicio', '<=', $fechaHoy)
            ->whereDate('fecha_fin', '>=', $fechaHoy)
            ->where('aceptada', 1)
            ->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados/' . $usuario->id . '/ausencias/info');

        if ($ausenciaHoy) {
            // Comprobamos que se devuelva la respuesta esperada cuando hay una ausencia para el día de hoy
            $response->assertStatus(200)
                ->assertExactJson($ausenciaHoy->tipo);
        } else {
            // Comprobamos que se devuelva la respuesta esperada cuando no hay ausencia para el día de hoy
            $response->assertStatus(204);
        }
    }

    public function test_empleado_ver_ausencias()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        $ausencias = Ausencia::select([
            'ausencias.*',
            DB::raw("IF(aceptada IS NULL, 'Pendiente', IF(aceptada = 0, 'Rechazada', 'Aceptada')) AS estado_aceptada"),
            'empleados.name',
            'empleados.apellidos'
        ])
            ->join('empleados', 'ausencias.empleados_id', '=', 'empleados.id')
            ->where('ausencias.empleados_id', $usuario->id)
            ->where('ausencias.tipo', 'Falta')
            ->get();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados/' . $usuario->id . '/ausencias/Falta');

        $response->assertStatus(200)
            ->assertJson($ausencias->toArray());
    }

    public function test_empleado_ver_fichajes_hoy()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        $fechaHoy = Carbon::now()->format('Y-m-d');
        $fichajesHoy = Fichaje::where('empleados_id', $usuario->id)
            ->whereDate('fecha_hora_fichaje', $fechaHoy)
            ->count();
        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados/' . $usuario->id . '/fichajes/info');

        $response->assertStatus(200)
            ->assertExactJson([$fichajesHoy]);
    }

    public function test_empleado_listar_fichajes()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        $fichajes = Fichaje::select('fichajes.id', 'fichajes.tipo', 'fichajes.fecha_hora_fichaje')
            ->join('empleados', 'fichajes.empleados_id', '=', 'empleados.id')
            ->join('horarios', 'fichajes.horarios_id', '=', 'horarios.id')
            ->where('empleados_id', $usuario->id)
            ->where('empleados.empresas_id', $usuario->empresas_id)
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

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados/' . $usuario->id . '/fichajes/listar');

        $response->assertStatus(200)
            ->assertJson($fichajes->toArray());
    }

    public function test_empleado_ver_horario_vista()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados/' . $usuario->id . '/mi-horario');

        if ($response->status() == 302) {
            $response = $this->followRedirects($response);
        }
        $response->assertViewIs('empleados.miHorario');
    }

    public function test_empleado_ver_ausencias_vista()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados/' . $usuario->id . '/mis-ausencias');

        if ($response->status() == 302) {
            $response = $this->followRedirects($response);
        }
        $response->assertViewIs('empleados.misAusencias');
    }

    public function test_empleado_ver_fichajes_vista()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/empleados/' . $usuario->id . '/mis-fichajes');

        if ($response->status() == 302) {
            $response = $this->followRedirects($response);
        }
        $response->assertViewIs('empleados.misFichajes');
    }

    public function test_admin_ver_fichajes_empresa()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $fichajes = Fichaje::select('fichajes.id', 'fichajes.tipo', 'fichajes.fecha_hora_fichaje')
            ->join('empleados', 'fichajes.empleados_id', '=', 'empleados.id')
            ->join('horarios', 'fichajes.horarios_id', '=', 'horarios.id')
            ->where('empleados.empresas_id', $usuario->empresas_id)
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

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/fichajes');

        $response->assertStatus(200)
            ->assertJson($fichajes->toArray());
    }

    public function test_admin_ver_fichajes_empresa_vista()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/fichajes/listar');

        if ($response->status() == 302) {
            $response = $this->followRedirects($response);
        }
        $response->assertViewIs('admins.fichajes');
    }

    public function test_admin_ver_horarios_empresa()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $horarios = Horario::select()->where('empresas_id', $usuario->empresas_id)->get();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/horarios');

        $response->assertStatus(200)
            ->assertJson($horarios->toArray());
    }

    public function test_admin_ver_horarios_empresa_vista()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/horarios/ver');

        if ($response->status() == 302) {
            $response = $this->followRedirects($response);
        }
        $response->assertViewIs('admins.horarios');
    }

    public function test_admin_ver_horario()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/horarios/' . $usuario->horarios_id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'horario',
                'intensivo',
                'asignado'
            ]);
    }

    public function test_empleado_ver_horario()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/horarios/' . $usuario->horarios_id . '/empleado/' . $usuario->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'horario',
                'intensivo'
            ]);
    }

    public function test_empleado_ver_jornada()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        $numDia = date("N");
        $jornadaHoy = Jornada::select()->where("horarios_id", $usuario->horarios_id)->where("dia", $numDia)->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/horarios/' . $usuario->horarios_id . '/empleado/' . $usuario->id . '/jornada');

        if ($jornadaHoy) {
            // Comprobamos que se devuelva la respuesta esperada cuando hay una jornada para el día de hoy
            $response->assertStatus(200)
                ->assertExactJson($jornadaHoy->toArray());
        } else {
            // Comprobamos que se devuelva la respuesta esperada cuando no hay jornada para el día de hoy
            $response->assertStatus(204);
        }
    }

    public function test_empleado_ver_jornadas()
    {
        $usuario = User::where('tipo', 'empleado')->first();

        $jornadas = Jornada::select()->where("horarios_id", $usuario->horarios_id)->get();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/horarios/' . $usuario->horarios_id . '/empleado/' . $usuario->id . '/jornadas');

        $response->assertStatus(200)
            ->assertExactJson($jornadas->toArray());
    }

    public function test_admin_ver_jornada()
    {
        $usuario = User::where('tipo', 'admin')->first();

        $numDia = date("N");
        $jornadaHoy = Jornada::select()->where("horarios_id", $usuario->horarios_id)->where("dia", $numDia)->first();

        $response = $this->actingAs($usuario)
            ->get('empresas/' . $usuario->empresas_id . '/horarios/' . $usuario->horarios_id . '/empleado/' . $usuario->id . '/jornada');

        if ($jornadaHoy) {
            // Comprobamos que se devuelva la respuesta esperada cuando hay una jornada para el día de hoy
            $response->assertStatus(200)
                ->assertExactJson($jornadaHoy->toArray());
        } else {
            // Comprobamos que se devuelva la respuesta esperada cuando no hay jornada para el día de hoy
            $response->assertStatus(204);
        }
    }
}
