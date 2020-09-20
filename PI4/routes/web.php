<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;

Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->group(function()
{
    // Index
    Route::get('/', [HomeController::class, 'index_home'])->name('admin');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/admin', [HomeController::class, 'index'])->name('admin');
    // Outra forma de chamar função:
        // Route::get('/', 'App\Http\Controllers\HomeController@index')->name('admin');

    // Usuarios
    Route::resource('Users',                UsersController::class);
    Route::get('trashed-Users',             [UsersController::class, 'trashed'])  ->name('trashed-Users.index');
    Route::put('restore-Users/{category}',  [UsersController::class, 'restore'])  ->name('restore-Users.update');
    Route::any('buscar-Users',              [UsersController::class, 'buscar'])   ->name('buscar-Users');
});

Route::get('/visitante', [HomeController::class, 'visitante'])->name('visitante');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->get('/dashboard', function ()
{
    return view('dashboard');
})->name('dashboard');
