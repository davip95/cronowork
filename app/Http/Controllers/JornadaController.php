<?php

namespace App\Http\Controllers;

use App\Models\Jornada;
use Illuminate\Http\Request;

class JornadaController extends Controller
{
    /**
     * Muestra los datos de la jornada.
     *
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @param  int  $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function show($empresaId, $horarioId, $usuarioId)
    {
        //
    }

    /**
     * Actualiza los datos de la jornada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @param  int  $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $empresaId, $horarioId, $usuarioId)
    {
        //
    }

    /**
     * Elimina (soft delete) la jornada.
     *
     * @param  int  $empresaId
     * @param  int  $horarioId
     * @param  int  $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function destroy($empresaId, $horarioId, $usuarioId)
    {
        //
    }
}
