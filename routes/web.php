<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\JornadaController;
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


// USER CONTROLLER

Route::controller(UserController::class)->group(function () {
    Route::put('/empresas/{empresa}/admin', 'updateAdmin')->middleware(['auth', 'admin', 'empresa'])->name('admin.cambiarAdmin');
    Route::get('/empresas/{empresa}/empleados/admin/listar', 'listarEmpleados')->middleware(['auth', 'admin', 'empresa'])->name('admin.listarEmpleados');
    Route::get('/empresas/{empresa}/empleados', 'verEmpleados')->middleware(['auth', 'admin', 'empresa'])->name('admin.verEmpleados');
    Route::post('/empresas/{empresa}/empleados/{empleado}/admin/horario', 'asignarHorario')->middleware(['auth', 'admin', 'empresa'])->name('admin.asignarHorario');
    Route::put('/empresas/{empresa}/empleados/{empleado}/admin/horario', 'cambiarHorario')->middleware(['auth', 'admin', 'empresa'])->name('admin.cambiarHorario');
    Route::put('/empresas/{empresa}/empleados/admin/horario', 'reasignarHorario')->middleware(['auth', 'admin', 'empresa'])->name('admin.reasignarHorario');
    Route::post('/empresas/admin/alta', 'guardarAlta')->middleware(['auth', 'admin'])->name('admin.guardarAlta');
    Route::get('/empresas/admin/alta', 'crearAlta')->middleware(['auth', 'admin'])->name('admin.crearAlta');
    Route::get('/empresas/admin/baja/empleado/{empleado}', 'guardarBajaDatatable')->middleware(['auth', 'admin'])->name('admin.guardarBajaDatatable');
    Route::post('/empresas/admin/baja', 'guardarBaja')->middleware(['auth', 'admin'])->name('admin.guardarBaja');
    Route::get('/empresas/admin/baja', 'crearBaja')->middleware(['auth', 'admin'])->name('admin.crearBaja');
});
Route::resource('usuarios', UserController::class)->only(['show', 'update', 'destroy'])->middleware(['auth', 'usuario']);

// EMPRESA CONTROLLER

Route::resource('empresas', EmpresaController::class)->only(['show', 'update', 'destroy'])->middleware(['auth', 'admin', 'empresa']);

// HORARIO CONTROLLER

Route::controller(HorarioController::class)->group(function () {
    Route::get('empresas/{empresa}/horarios/{horario}/empleado/{usuario}/jornada', 'verJornadaPropia')->middleware(['auth', 'usuario', 'empleado', 'empresa'])->name('empleado.verJornadaPropia');
    Route::get('empresas/{empresa}/horarios/{horario}/jornada', 'verJornada')->middleware(['auth', 'admin', 'empresa'])->name('admin.verJornada');
    Route::get('empresas/{empresa}/horarios/{horario}/empleado/{usuario}', 'verHorario')->middleware(['auth', 'usuario', 'empleado', 'empresa'])->name('empleado.verHorario');
});
Route::resource('empresas.horarios', HorarioController::class)->only(['index', 'show', 'update', 'destroy'])->middleware(['auth', 'admin', 'empresa']);

// JORNADA CONTROLLER

Route::resource('empresas.horarios.jornadas', HorarioController::class)->only(['show', 'update', 'destroy'])->middleware(['auth', 'admin', 'empresa']);
