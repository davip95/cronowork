<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\FichajeController;
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
    // Rutas de navegación
    Route::get('/empresas/{empresa}/fichajes/listar', 'verFichajes')->middleware(['auth', 'admin', 'empresa'])->name('admin.verFichajes');
    Route::get('/empresas/{empresa}/empleados', 'verEmpleados')->middleware(['auth', 'admin', 'empresa'])->name('admin.verEmpleados');
    Route::get('/empresas/{empresa}/horarios/ver', 'verHorarios')->middleware(['auth', 'admin', 'empresa'])->name('admin.verHorarios');
    Route::get('/empresas/{empresa}/empleados/{usuario}/mis-fichajes', 'misFichajes')->middleware(['auth', 'usuario', 'empresa'])->name('empleado.misFichajes');
    Route::get('/empresas/{empresa}/empleados/{usuario}/mi-horario', 'miHorario')->middleware(['auth', 'usuario', 'empresa'])->name('empleado.miHorario');
    // Fin rutas de navegación
    Route::put('/empresas/{empresa}/empleados/{empleado}/admin/horario', 'cambiarHorario')->middleware(['auth', 'admin', 'empresa'])->name('admin.cambiarHorario');
    Route::put('/empresas/{empresa}/empleados/admin/horario', 'reasignarHorario')->middleware(['auth', 'admin', 'empresa'])->name('admin.reasignarHorario');
    Route::post('/empresas/admin/alta', 'guardarAlta')->middleware(['auth', 'admin'])->name('admin.guardarAlta');
    Route::get('/empresas/admin/baja/empleado/{empleado}', 'guardarBajaDatatable')->middleware(['auth', 'admin'])->name('admin.guardarBajaDatatable');
    Route::post('/empresas/admin/baja', 'guardarBaja')->middleware(['auth', 'admin'])->name('admin.guardarBaja');
    Route::get('/empresas/{empresa}/empleados/{empleado}', 'verDetalles')->middleware(['auth', 'admin', 'empresa'])->name('admin.verDetalles');
});
Route::resource('usuarios', UserController::class)->only(['show', 'update', 'destroy'])->middleware(['auth', 'usuario']);

// EMPRESA CONTROLLER

Route::resource('empresas', EmpresaController::class)->only(['show', 'update', 'destroy'])->middleware(['auth', 'admin', 'empresa']);

// HORARIO CONTROLLER

Route::controller(HorarioController::class)->group(function () {
    Route::post('/empresas/{empresa}/empleados/{empleado}/admin/horario/{dt?}', 'crearHorario')->middleware(['auth', 'admin', 'empresa'])->name('admin.crearHorario');
    Route::get('empresas/{empresa}/horarios/{horario}/empleado/{usuario}/jornada', 'verJornadaPropia')->middleware(['auth', 'usuario', 'empresa'])->name('empleado.verJornadaPropia');
    Route::get('empresas/{empresa}/horarios/{horario}/jornadas/detalles', 'verJornadas')->middleware(['auth', 'admin', 'empresa'])->name('admin.verJornadas');
    Route::get('empresas/{empresa}/horarios/{horario}/empleado/{usuario}/jornadas', 'verJornadas')->middleware(['auth', 'usuario', 'empresa'])->name('empleado.verJornadas');
    Route::get('empresas/{empresa}/horarios/{horario}/jornada', 'verJornada')->middleware(['auth', 'admin', 'empresa'])->name('admin.verJornada');
    Route::get('empresas/{empresa}/horarios/{horario}/empleado/{usuario}', 'verHorario')->middleware(['auth', 'usuario', 'empresa'])->name('empleado.verHorario');
});
Route::resource('empresas.horarios', HorarioController::class)->only(['index', 'show', 'destroy'])->middleware(['auth', 'admin', 'empresa']);

// FICHAJE CONTROLLER

Route::controller(FichajeController::class)->group(function () {
    //Route::post('empresas/{empresa}/empleados/{usuario}/fichajes/crear', 'crearFichaje')->middleware(['auth', 'usuario', 'empresa'])->name('empleado.crearFichaje');
    //Route::get('empresas/{empresa}/empleados/{usuario}/fichajes/{fichaje}', 'verFichaje')->middleware(['auth', 'usuario', 'empresa'])->name('empleado.verFichaje');
    //Route::get('empresas/{empresa}/empleados/{usuario}/fichajes/listar', 'listarFichajes')->middleware(['auth', 'usuario', 'empresa'])->name('empleado.listarFichajes');
});
Route::resource('empresas.fichajes', FichajeController::class)->only(['index', 'show'])->middleware(['auth', 'admin', 'empresa']);
