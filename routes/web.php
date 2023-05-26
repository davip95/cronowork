<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'redireccionaInicio'])->middleware(['auth'])->name('home');

require __DIR__ . '/auth.php';

Route::controller(UserController::class)->group(function () {
    Route::get('/empresas/{empresa}/empleados/admin/listar', 'listarEmpleados')->middleware(['auth', 'admin', 'empresa'])->name('admin.listarEmpleados');
    Route::post('/empresas/{empresa}/empleados/{empleado}/admin/horario', 'asignarHorario')->middleware(['auth', 'admin', 'empresa'])->name('admin.asignarHorario');
    Route::get('/empresas/{empresa}/empleados/{empleado}/admin/horario', 'cambiarHorario')->middleware(['auth', 'admin', 'empresa'])->name('admin.cambiarHorario');
    Route::post('/empresas/admin/alta', 'guardarAlta')->middleware(['auth', 'admin'])->name('admin.guardarAlta');
    Route::get('/empresas/admin/alta', 'crearAlta')->middleware(['auth', 'admin'])->name('admin.crearAlta');
    Route::post('/empresas/admin/baja', 'guardarBaja')->middleware(['auth', 'admin'])->name('admin.guardarBaja');
    Route::get('/empresas/admin/baja', 'crearBaja')->middleware(['auth', 'admin'])->name('admin.crearBaja');
});
Route::resource('usuarios', UserController::class)->only(['edit', 'update', 'destroy'])->middleware(['auth', 'usuario']);
