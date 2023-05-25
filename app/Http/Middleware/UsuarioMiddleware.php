<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioMiddleware
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
        if (Auth::check() && $request->route()->hasParameter('usuario')) {
            // Obtiene el ID del usuario autenticado
            $userId = Auth::id();
            // Obtén el ID del usuario de la ruta
            $routeUsertId = $request->route('usuario');

            // Verifica si el usuario autenticado está intentando acceder a sus propios datos
            if ($userId == $routeUsertId) {
                return $next($request);
            } else {
                Auth::logout(); // Cierra la sesión
                return redirect()->route('login'); // Redirige al login
                // return redirect()->action([AuthenticatedSessionController::class, 'destroy']);
            }
        }
        Auth::logout(); // Cierra la sesión
        return redirect()->route('login'); // Redirige al login
        // return redirect()->action([AuthenticatedSessionController::class, 'destroy']);
    }
}
