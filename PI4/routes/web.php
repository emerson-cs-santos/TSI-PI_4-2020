<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;

Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->group(function()
{
    // Index
    Route::get('/', [HomeController::class, 'index_home'])->name('admin');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/admin', [HomeController::class, 'index'])->name('admin');
    // Outra forma de chamar função:
        // Route::get('/', 'App\Http\Controllers\HomeController@index')->name('admin');

    // Usuarios
    Route::resource('Users',                    UsersController::class);
    Route::get('trashed-Users',                 [UsersController::class, 'trashed' ] )  ->name('trashed-Users.index');
    Route::put('restore-Users/{category}',      [UsersController::class, 'restore' ] )  ->name('restore-Users.update');
    Route::any('buscar-Users',                  [UsersController::class, 'buscar' ] )   ->name('buscar-Users');

    // Categorias
    Route::resource('categories',               CategoriesController::class);
    Route::get('trashed-categories',            [CategoriesController::class, 'trashed' ] )->name('trashed-categories.index');
    Route::put('restore-categories/{category}', [CategoriesController::class, 'restore' ] )->name('restore-categories.update');
    Route::any('buscar-categories',             [CategoriesController::class, 'buscar' ] )->name('buscar-categories');

    // Produtos
    Route::resource('products',                 ProductsController::class);
    Route::get('trashed-product',               [ProductsController::class, 'trashed' ] )->name('trashed-product.index');
    Route::put('restore-product/{product}',     [ProductsController::class, 'restore' ] )->name('restore-product.update');
    Route::any('buscar-products',               [ProductsController::class, 'buscar' ] )->name('buscar-products');    
});

Route::get('/visitante', [HomeController::class, 'visitante'])->name('visitante');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->get('/dashboard', function ()
{
    return view('dashboard');
})->name('dashboard');
