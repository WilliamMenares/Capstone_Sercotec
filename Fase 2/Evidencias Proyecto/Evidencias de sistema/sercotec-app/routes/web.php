<?php

use App\Http\Controllers\AmbitoController;
use App\Http\Controllers\AsesoriaController;
use App\Http\Controllers\DiagnosticoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\FormulariosController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\WelcomeController;






Route::get('/', function () {
    return view('login');
});

//Ruta Inicial
Route::post('login', [LoginController::class, 'login']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

//Vistas Protegidas
Route::middleware(['auth'])->group(function () {

    //Rutas para Apis
    Route::get('/api/emp', [EmpresaController::class, 'getemps']);
    Route::get('/api/user', [UserController::class, 'getusers']);
    Route::get('/api/ambi', [AmbitoController::class, 'getambis']);
    Route::get('/api/pregu', [PreguntasController::class, 'getpregu']);
    Route::get('/api/formu', [FormulariosController::class, 'getformu']);
    Route::get('/api/ase', [AsesoriaController::class, 'getase']);


    // Rutas para usuarios
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    //Rutas Individuales
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');


    //Rutas Empresas
    Route::get('/empresa', [EmpresaController::class, 'index'])->name('empresa.index');
    Route::put('/empresa/{id}', [EmpresaController::class, 'update'])->name('empresa.update');
    Route::post('/empresa', [EmpresaController::class, 'store'])->name('empresa.store');
    Route::delete('/empresa/{id}', [EmpresaController::class, 'destroy'])->name('empresa.destroy');

    //Rutas para Importar datos Excel
    Route::get('/importar-excel', [ExcelController::class, 'index'])->name('excel.index');
    Route::post('/import', [ExcelController::class, 'import'])->name('excel.import');
    Route::get('/import/progress', [ExcelController::class, 'getProgress'])->name('excel.progress');

    // Ruta para Welcome
    Route::get('/welcome', [welcomeController::class, 'index'])->name('dashboard');

    // Ruta para mostrar formularios
    Route::get('forms', [AmbitoController::class, 'index'])->name('forms.index');

    // Rutas para Ambitos
    Route::post('forms/ambito', [AmbitoController::class, 'store'])->name('forms.storeAmbito');
    Route::put('forms/ambito/{id}', [AmbitoController::class, 'update'])->name('forms.updateAmbito');
    Route::delete('forms/ambito/{id}', [AmbitoController::class, 'destroy'])->name('forms.destroyAmbito');

    // Rutas para Preguntas
    Route::post('forms/pregunta', [PreguntasController::class, 'store'])->name('forms.storePregunta');
    Route::put('forms/pregunta/{id}', [PreguntasController::class, 'update'])->name('forms.updatePregunta');
    Route::delete('forms/pregunta/{id}', [PreguntasController::class, 'destroy'])->name('forms.destroyPregunta');

    // Rutas para Formularios
    Route::post('forms/formu', [FormulariosController::class, 'store'])->name('forms.storeFormulario');
    Route::put('forms/formu/{id}', [FormulariosController::class, 'update'])->name('forms.updateFormulario');
    Route::delete('forms/formu/{id}', [FormulariosController::class, 'destroy'])->name('forms.destroyFormulario');

    //ruta para mostrar Asesorias
    Route::get('/diagnostico', [DiagnosticoController::class, 'index'])->name('diagnostico.index');
    Route::post('/diagnostico', [DiagnosticoController::class, 'store'])->name('diagnostico.store');
    Route::post('/diagnostico/verificar', [DiagnosticoController::class, 'verificar'])->name('diagnostico.verificar');


    //Ruta para diagnostico
    Route::get('/asesorias', [AsesoriaController::class, 'index'])->name('asesorias.index');
    Route::delete('asesorias/{id}', [AsesoriaController::class, 'destroy'])->name('asesorias.destroy');

    //ruta para pdf
    Route::get('/asesorias/pdf/{id}', [AsesoriaController::class, 'generarPDF'])
    ->name('asesorias.pdf');

    

});

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













