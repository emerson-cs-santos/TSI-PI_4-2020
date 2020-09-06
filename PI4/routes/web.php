<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Auth::routes();

Route::middleware('auth', 'is_admin')->group(function()
{
    // Index
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

    // Usuarios
    Route::resource('Users','UsersController');
    Route::get('trashed-Users','UsersController@trashed')->name('trashed-Users.index');
    Route::put('restore-Users/{category}','UsersController@restore')->name('restore-Users.update');
    Route::any('buscar-Users','UsersController@buscar')->name('buscar-Users');

    // Categorias
    Route::resource('categories','CategoriesController');
    Route::get('trashed-categories','CategoriesController@trashed')->name('trashed-categories.index');
    Route::put('restore-categories/{category}','CategoriesController@restore')->name('restore-categories.update');
    Route::any('buscar-categories','CategoriesController@buscar')->name('buscar-categories');

    // Produtos
    Route::resource('products','ProductsController');
    Route::get('trashed-product','ProductsController@trashed')->name('trashed-product.index');
    Route::put('restore-product/{product}','ProductsController@restore')->name('restore-product.update');
    Route::any('buscar-products','ProductsController@buscar')->name('buscar-products');

    // Carrinho
    Route::resource('carrinho','CarrinhoController');
    Route::get('trashed-carrinho','CarrinhoController@trashed')->name('trashed-carrinho.index');
    Route::put('restore-carrinho/{category}','CarrinhoController@restore')->name('restore-carrinho.update');
    Route::any('buscar-carrinho','CarrinhoController@buscar')->name('buscar-carrinho');

    // Pedido e item
    Route::get('/index-pedido', 'PedidoController@index_pedido')->name('index-pedido');
    Route::delete('pedido-destroy/{id}', 'PedidoController@destroy')->name('pedido.destroy');
    Route::get('trashed-pedido', 'PedidoController@trashed')->name('trashed-pedido.index');
    Route::put('restore-pedido/{id}', 'PedidoController@restore')->name('restore-pedido.update');
    Route::any('buscar-index-pedido','PedidoController@buscar')->name('buscar-index-pedido');
    Route::get('/item-pedido/{idPedido}','PedidoController@index_itensPedido')->name('item-pedido');

    // Sobre a loja
    Route::get('/sobre-index', 'SobreNosController@sobre_index')                              ->name('sobre-index');
    Route::get('/sobre-quem-somos', 'SobreNosController@sobre_quem_somos')                    ->name('sobre-quem-somos');
    Route::get('/sobre-contato', 'SobreNosController@sobre_contato')                          ->name('sobre-contato');
    Route::put('sobre-quem-somos-atualizar', 'SobreNosController@sobre_quem_somos_atualizar') ->name('sobre-quem-somos-atualizar');
    Route::put('sobre-contato-atualizar', 'SobreNosController@sobre_contato_atualizar')       ->name('sobre-contato-atualizar');

});

