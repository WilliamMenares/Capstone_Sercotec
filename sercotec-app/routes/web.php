<?php

use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::view('login', 'login')->name('login');
Route::view('welcome', 'welcome')->name('welcome');
Route::view('empleado', 'empleado')->name('empleado');
Route::get('empresa', [EmpresaController::class, "index"])->name("empresa.index");
//ruta para agregar empresa
Route::post('empresa', [EmpresaController::class, 'store'])->name('empresa.store');
//ruta para modificar empresa
Route::post('empresa/{id}', [EmpresaController::class, 'update'])->name('empresa.update');
//ruta para eliminar empresa
Route::delete('empresa/{id}', [EmpresaController::class, 'destroy'])->name('empresa.destroy');


