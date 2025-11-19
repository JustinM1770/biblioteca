<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\PrestamoController;
use Illuminate\Support\Facades\Route;

// Redirigir a login si no está autenticado
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard con estadísticas según rol
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // CRUD Libros - Solo visualización para todos, edición solo admin
    Route::get('/libros', [LibroController::class, 'index'])->name('libros.index');
    Route::get('/libros/{libro}', [LibroController::class, 'show'])->name('libros.show');
    
    Route::middleware('role:admin')->group(function () {
        Route::get('/libros/create', [LibroController::class, 'create'])->name('libros.create');
        Route::post('/libros', [LibroController::class, 'store'])->name('libros.store');
        Route::get('/libros/{libro}/edit', [LibroController::class, 'edit'])->name('libros.edit');
        Route::put('/libros/{libro}', [LibroController::class, 'update'])->name('libros.update');
        Route::delete('/libros/{libro}', [LibroController::class, 'destroy'])->name('libros.destroy');
    });
    
    // CRUD Autores - Solo admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('autores', AutorController::class);
        Route::resource('generos', GeneroController::class);
    });

    // Gestión de préstamos - Todos pueden ver y crear
    Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');
    Route::get('/prestamos/create', [PrestamoController::class, 'create'])->name('prestamos.create');
    Route::post('/prestamos', [PrestamoController::class, 'store'])->name('prestamos.store');
    Route::get('/prestamos/{prestamo}', [PrestamoController::class, 'show'])->name('prestamos.show');
    
    // Solo admin y bibliotecario pueden devolver y eliminar préstamos
    Route::middleware('role:admin,bibliotecario')->group(function () {
        Route::patch('/prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');
        Route::delete('/prestamos/{prestamo}', [PrestamoController::class, 'destroy'])->name('prestamos.destroy');
    });
    
    // API endpoints
    Route::prefix('api')->group(function () {
        Route::get('/libros', function() {
            return \App\Models\Libro::with(['autor', 'genero'])->disponibles()->get();
        })->name('api.libros');
        
        Route::get('/autores', function() {
            return \App\Models\Autor::orderBy('nombre')->get();
        })->name('api.autores');
        
        Route::get('/generos', function() {
            return \App\Models\Genero::orderBy('nombre')->get();
        })->name('api.generos');
    });
});

require __DIR__.'/auth.php';
