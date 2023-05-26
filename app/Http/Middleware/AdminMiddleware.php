<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::check() && Auth::user()->tipo == 'admin')
            return $next($request);
        else {
            if ($request->ajax()) {
                Auth::logout();
                return response()->json(['error' => 'Acceso prohibido'], 403);
            } else {
                //return redirect()->action([AuthenticatedSessionController::class, 'destroy']);
                return redirect()->route('exit');
            }
        }
    }
}
