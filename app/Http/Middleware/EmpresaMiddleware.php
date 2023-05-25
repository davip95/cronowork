<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpresaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Obtiene el ID de la empresa asociada al modelo User
            $empresaId = Auth::user()->empresas_id;

            // Verifica si el usuario tiene una empresa asignada y si coincide con la empresa de los datos de la ruta si es que existe en la ruta
            if ($empresaId != null && $request->route()->hasParameter('empresa') && $empresaId == $request->route('empresa')) {
                return $next($request);
            } else {
                return redirect()->action([AuthenticatedSessionController::class, 'destroy']);
            }
        }
        return redirect()->action([AuthenticatedSessionController::class, 'destroy']);
    }
}
