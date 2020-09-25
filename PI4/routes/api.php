<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Retorna informações para a tela principal ( categorias, lançamentos e mais vendidos )
Route::get( '/main', [APIController::class, 'telaInicial'] );

// Retorna todas as categorias
Route::get( '/categorias', [APIController::class, 'categorias'] );

// Retorna produtos de 1 categoria
Route::get( '/categoria_produtos/{id_categoria}', [APIController::class, 'categoriaProdutos'] );

// Retorna os lançamentos
Route::get( '/lancamentos', [APIController::class, 'lancamentos'] );

// Retorna os mais vendidos
Route::get( '/mais_vendidos', [APIController::class, 'maisVendidos'] );
