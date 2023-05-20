<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalMiddleware
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
            $userId = Auth::id(); // Obtiene el ID del usuario autenticado

            // Obtén el ID del usuario de la ruta
            $routeUsertId = $request->route('empleado');

            // Verifica si el usuario autenticado está intentando acceder a sus propios datos
            if ($userId == $routeUsertId) {
                return $next($request);
            } else {
                return redirect()->action([AuthenticatedSessionController::class, 'destroy']);
            }
        }
        return redirect()->action([AuthenticatedSessionController::class, 'destroy']);
    }
}
