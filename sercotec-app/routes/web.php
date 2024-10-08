<?php

use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::view('login', 'login')->name('login');
Route::view('welcome', 'welcome')->name('welcome');
Route::view('empresa', 'empresa')->name('empresa');
Route::view('empleado', 'empleado')->name('empleado');
Route::get("empleado",[CrudController::class, "index"])->name("crud.index");