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

// usar se tiver problemas com cors
Route::middleware( ['Cors', 'TrustProxies'] )->group( function ()
{

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Retorna informações para a tela principal ( categorias, lançamentos e mais vendidos )
Route::get( '/main',                                [APIController::class, 'telaInicial'] );

// Retorna todas as categorias
Route::get( '/categorias',                          [APIController::class, 'categorias'] );

// Retorna produtos de 1 categoria
Route::get( '/categoria_produtos/{id_categoria}',   [APIController::class, 'categoriaProdutos'] );

// Retorna os lançamentos
Route::get( '/lancamentos',                         [APIController::class, 'lancamentos'] );

// Retorna os mais vendidos
Route::get( '/mais_vendidos',                       [APIController::class, 'maisVendidos'] );

// Busca de jogos ou categorias
Route::get( 'busca/{buscar}',                       [APIController::class, 'busca'] );

// Retorna todos os produtos
Route::get( 'produtos',                             [APIController::class, 'produtos'] );

// Retorna informações de 1 produto
Route::get( 'produto/{id}',                         [APIController::class, 'verProduto'] );

// Criar usuário
Route::post( '/registrar_usuario',                  [APIController::class, 'registrar'] );

// Login
Route::post( '/loginAPI',                           [APIController::class, 'login'] );


// Rotas abaixo precisam passar token válido
Route::middleware( ['ApiSecurity'] )->group( function ()
{
    // Retorna informações do usuario
    Route::get( 'usuario/{id}',                     [APIController::class, 'verUsuario'] );

    // Editar usuário
    Route::put( '/atualizar_usuario/{id}',          [APIController::class, 'atualizarUsuario'] );

    // Editar senha
    Route::put( '/atualizar_senha/{id}',            [APIController::class, 'atualizarSenha'] );

    // Carrinho - Retorna itens do carrinho
    Route::get( '/carrinho/{idUser}',               [APIController::class, 'carrinho'] );

    // Carrinho - Incluir item
    Route::post( '/carrinho_incluir',               [APIController::class, 'carrinhoIncluir'] );

    // Carrinho - Remover item
    Route::delete( '/carrinho_remover/{idUser}',    [APIController::class, 'carrinhoRemover'] );

    // Carrinho finalizar e gerar pedido
    Route::get( '/carrinho_finalizar/{idUser}',     [APIController::class, 'carrinhoFinalizar'] );

    // Retornar Pedidos do usuário
    Route::get( '/pedidos/{idUser}',                [APIController::class, 'pedidos'] );

    // Retornar Valor total do pedido
    Route::get( '/pedido_valor_total/{idPedido}',   [APIController::class, 'pedidoValorTotal'] );

    // Retornar itens do pedido
    Route::get( '/pedidos_itens/{idPedido}',        [APIController::class, 'pedidosItens'] );
});
