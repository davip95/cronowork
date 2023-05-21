<?php

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

Route::get('/', function () {
    return view('usuarios.inicio');
})->middleware(['auth'])->name('home');

require __DIR__ . '/auth.php';

// Route::controller(UserController::class)->group(function () {

// });
Route::resource('usuarios', UserController::class)->only(['show', 'edit', 'update', 'destroy']);
