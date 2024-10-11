<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::view('login', 'login')->name('login');
Route::view('welcome', 'welcome')->name('welcome');//->middleware('auth');



//ruta para ingresar al sistema
Route::post('login', [LoginController::class,'login']);
Route::post('logout', [LoginController::class,'logout'])->middleware('auth');


// Ruta para mostrar empleados
// Rutas para usuarios
Route::get('user', [UserController::class, 'index'])->name('user.index');


// Ruta para agregar empleado
Route::post('/user', [UserController::class, 'store'])->name('user.store');


// Ruta para modificar empleado
Route::post('user/{id}', [UserController::class, 'update'])->name('user.update');

// Ruta para eliminar empleado
Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');



//ruta para mostrar empresa
Route::get('empresa', [EmpresaController::class, 'index'])->name('empresa.index');
//ruta para agregar empresa
Route::post('empresa', [EmpresaController::class, 'store'])->name('empresa.store');
//ruta para modificar empresa
Route::post('empresa/{id}', [EmpresaController::class, 'update'])->name('empresa.update');
//ruta para eliminar empresa
Route::delete('empresa/{id}', [EmpresaController::class, 'destroy'])->name('empresa.destroy');


