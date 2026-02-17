<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Grupo de rutas protegidas por login
Route::middleware(['auth'])->group(function () {
    // Gestión de Usuarios
    Route::resource('users', UserController::class)->middleware('auth');

    // Gestión de Editoriales
    Route::resource('editorials', EditorialController::class)->middleware('auth');
    Route::delete('/editorial/{id}', [EditorialController::class, 'deleteEditorial'])->name('editorials.delete')->middleware('auth');

    // Gestión de Autores
    Route::resource('autors', AutorController::class)->middleware('auth');
    Route::delete('/autors/{id}', [AutorController::class, 'autorDelete'])->name('autors.delete')->middleware('auth');
    // Gestión de Libros
    Route::resource('libros', LibroController::class)->middleware('auth');
    Route::delete('/libros/{id}', [LibroController::class, 'deleteLibro'])->name('libros.delete')->middleware('auth');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');