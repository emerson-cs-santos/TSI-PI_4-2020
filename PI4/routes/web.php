<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\PedidoController;

Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->group(function()
{
    // Index
    Route::get('/',                             [HomeController::class, 'index_home'])              ->name('admin');
    Route::get('/home',                         [HomeController::class, 'index'])                   ->name('home');
    Route::get('/admin',                        [HomeController::class, 'index'])                   ->name('admin');
    // Outra forma de chamar função:
        // Route::get('/', 'App\Http\Controllers\HomeController@index')->name('admin');

    // Usuarios
    Route::resource('Users',                    UsersController::class);
    Route::get('trashed-Users',                 [UsersController::class, 'trashed' ] )              ->name('trashed-Users.index');
    Route::put('restore-Users/{category}',      [UsersController::class, 'restore' ] )              ->name('restore-Users.update');
    Route::any('buscar-Users',                  [UsersController::class, 'buscar' ] )               ->name('buscar-Users');

    // Categorias
    Route::resource('categories',               CategoriesController::class);
    Route::get('trashed-categories',            [CategoriesController::class, 'trashed' ] )         ->name('trashed-categories.index');
    Route::put('restore-categories/{category}', [CategoriesController::class, 'restore' ] )         ->name('restore-categories.update');
    Route::any('buscar-categories',             [CategoriesController::class, 'buscar' ] )          ->name('buscar-categories');

    // Produtos
    Route::resource('products',                 ProductsController::class);
    Route::get('trashed-product',               [ProductsController::class, 'trashed' ] )           ->name('trashed-product.index');
    Route::put('restore-product/{product}',     [ProductsController::class, 'restore' ] )           ->name('restore-product.update');
    Route::any('buscar-products',               [ProductsController::class, 'buscar' ] )            ->name('buscar-products');

    // Carrinho
    Route::resource('carrinho',                 CarrinhoController::class);
    Route::get('trashed-carrinho',              [CarrinhoController::class, 'trashed' ] )           ->name('trashed-carrinho.index');
    Route::put('restore-carrinho/{category}',   [CarrinhoController::class, 'restore' ] )           ->name('restore-carrinho.update');
    Route::any('buscar-carrinho',               [CarrinhoController::class, 'buscar' ] )            ->name('buscar-carrinho');

    // Pedido e item
    Route::get('/index-pedido',                 [PedidoController::class, 'index_pedido' ] )        ->name('index-pedido');
    Route::delete('pedido-destroy/{id}',        [PedidoController::class, 'destroy'] )              ->name('pedido.destroy');
    Route::get('trashed-pedido',                [PedidoController::class, 'trashed'] )              ->name('trashed-pedido.index');
    Route::put('restore-pedido/{id}',           [PedidoController::class, 'restore'] )              ->name('restore-pedido.update');
    Route::any('buscar-index-pedido',           [PedidoController::class, 'buscar'] )               ->name('buscar-index-pedido');
    Route::get('/item-pedido/{idPedido}',       [PedidoController::class, 'index_itensPedido'] )    ->name('item-pedido');

    // Sobre
    Route::get('/sobre', [HomeController::class, 'sobre'] )                                          ->name('sobre');
});

Route::get('/visitante', [HomeController::class, 'visitante'])->name('visitante');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->get('/dashboard', function ()
{
    return view('dashboard');
})->name('dashboard');
