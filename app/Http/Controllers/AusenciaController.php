<?php

namespace App\Http\Controllers;

use App\Models\Ausencia;
use Illuminate\Http\Request;

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
}
