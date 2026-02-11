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
    Route::get('/delete-editorial/{editorial_id}', [EditorialController::class, 'deleteEditorial'])->name('deleteEditorial')->middleware('auth');

    // Gestión de Autores
    Route::resource('autors', AutorController::class)->middleware('auth');
    Route::get('/delete-autor/{autor_id}', [AutorController::class, 'deleteAutor'])->name('deleteAutor')->middleware('auth');

    // Gestión de Libros
    Route::resource('libros', LibroController::class)->middleware('auth');
    Route::get('/delete-libro/{id}', [LibroController::class, 'deleteLibro'])->name('deleteLibro')->middleware('auth');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');