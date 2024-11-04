<?php

use App\Http\Controllers\AmbitoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\FormulariosController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AsesoriasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});
Route::view('login', 'login')->name('login');
Route::view('olvide', 'olvide')->name('olvide');
Route::view('welcome', 'welcome')->name('welcome');//->middleware('auth');
Route::get('welcome', [EmpresaController::class, 'welcome']);
//ruta para ingresar al sistema
Route::post('login', [LoginController::class,'login']);
Route::post('logout', [LoginController::class,'logout'])->middleware('auth');


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
Route::get('welcome', [WelcomeController::class, 'index']);


// Ruta para mostrar empresas
Route::get('forms', [AmbitoController::class, 'index'])->name('forms.index');

// Rutas para Ambitos
Route::post('forms/ambito', [AmbitoController::class, 'store'])->name('forms.storeAmbito');
Route::post('forms/ambito/{id}', [AmbitoController::class, 'update'])->name('forms.updateAmbito');
Route::delete('forms/ambito/{id}', [AmbitoController::class, 'destroy'])->name('forms.destroyAmbito');

// Rutas para Preguntas
Route::post('forms/pregunta', [PreguntasController::class, 'store'])->name('forms.storePregunta');
Route::post('forms/pregunta/{id}', [PreguntasController::class, 'update'])->name('forms.updatePregunta');
Route::delete('forms/pregunta/{id}', [PreguntasController::class, 'destroy'])->name('forms.destroyPregunta');

// Rutas para Formularios
Route::post('forms/formu', [FormulariosController::class, 'store'])->name('forms.storeFormulario');
Route::post('forms/formu/{id}', [FormulariosController::class, 'update'])->name('forms.updateFormulario');
Route::delete('forms/formu/{id}', [FormulariosController::class, 'destroy'])->name('forms.destroyFormulario');

//ruta para mostrar Asesorias
Route::get('asesorias', [AsesoriasController::class, 'index'])->name('asesorias.index');



use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

Route::get('/olvide', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/olvide', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/recuperar/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/recuperar', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');


