<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Carrinho;
use App\Models\Pedido;
use App\Models\ItemPedido;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Boolean;
use ReallySimpleJWT\Token;

class APIController extends Controller
{
    private $secretToken    = 'sec!ReT423*&';

    // A função abaixo tira do resultado da select a ordenação gerada.
    // Exemplo de como vem uma query ordenada pelo laravel (uma collection), neste caso foi ordenado order by id desc:
        // [
        //     "1":
        //         {
        //             "id": 8,
        //             "name": "Teste 85"
        //         },

        //     "2":
        //         {
        //             "id": 5,
        //             "name": "Teste 85"
        //         },

        //     "3":
        //         {
        //             "id": 3,
        //             "name": "Teste 85"
        //         }
        // ]

    // Por conta desses numeros, cada resposta ficou dentro deles, ficou uma reposta de jsons de numeros com outro json dentro.-bottom-0
    // Essa função faz um for na reposta atribuindo em outro array ignorando esses numeros, ficando a resposta assim:
        // [
        //     {
        //         "id": 8,
        //         "name": "teste 8"
        //     },
        //     {
        //         "id": 5,
        //         "name": "Playstation"
        //     },
        //     {
        //         "id": 3,
        //         "name": "teste 5"
        //     }
        // ]
    private function tirarIndicadorOrdenacao( $SelectResultados ): array
    {
        $Resposta = [];

        foreach ($SelectResultados as $SelectResultado)
        {
             array_push( $Resposta, $SelectResultado );
        }

        return $Resposta;
    }

    public function telaInicial()
    {
        $categorias     = Category::all()->sortByDesc('id')->take(3);
        $lancamentos    = Product::all()->sortByDesc('id')->take(4);
        $maisVendidos   = Product::all()->sortByDesc('sold')->take(4);

         // $categorias = Category::all()->where('home', '=' , 'S')->sortByDesc('id')->take(3);
        // $maisVendidos   = Product::all()->where('sold', '>' , 0)->sortByDesc('sold')->take(4);

      //  return response()->json( $categorias );

        return response()->json( array (
            'categorias'    => $categorias,
            'lancamentos'   => $lancamentos,
            'maisVendidos'  => $maisVendidos,
        ));

       // $carrossel      = Product::all()->where('home','S');
    }


    public function categoriasMain()
    {
        $categorias = Category::all()->sortByDesc('id')->take(5);

        return response()->json( $this->tirarIndicadorOrdenacao( $categorias ) );
    }


    public function lancamentosMain()
    {
     //   $lancamentos    = Product::all()->sortByDesc('id')->take(5);

        $lancamentos = Product::selectRaw('products.*, categories.name as categoryName')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->orderBy('id', 'desc')
        ->take(5)
        ->get();

        //return response()->json( $this->tirarIndicadorOrdenacao( $lancamentos ) );
        return response()->json( $lancamentos );
    }


    public function maisVendidosMain()
    {
      //  $maisVendidos   = Product::all()->sortByDesc('sold')->take(5);

        $maisVendidos = Product::selectRaw('products.*, categories.name as categoryName')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->orderBy('sold', 'desc')
        ->take(5)
        ->get();

      //  return response()->json( $this->tirarIndicadorOrdenacao( $maisVendidos ) );
      return response()->json( $maisVendidos );
    }


    public function categorias()
    {
        $categorias = Category::all()->sortBy('name');

        return response()->json( $this->tirarIndicadorOrdenacao( $categorias ) );
    }


    // Produtos da categoria
    public function categoriaProdutos( $id_categoria )
    {
        $produtos = Product::selectRaw('products.*, categories.name as categoryName')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->where('category_id', '=' , $id_categoria)
        ->orderBy('id', 'desc')
        ->get();

        return response()->json( $produtos );
    }


    public function lancamentos()
    {
        $lancamentos = Product::selectRaw('products.*, categories.name as categoryName')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->orderBy('id', 'desc')
        ->get();

        return response()->json( $lancamentos );
    }


    public function maisVendidos()
    {
      $maisVendidos = Product::selectRaw('products.*, categories.name as categoryName')
      ->join('categories', 'categories.id', '=', 'products.category_id')
      ->orderBy('sold', 'desc')
      ->get();

        return response()->json( $maisVendidos );
    }


    public function busca( $buscar )
    {
        $products = "";

        if($buscar != "")
        {
            $products = Product::selectRaw('products.*, categories.name as categoryName')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where ( 'products.name', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'categories.name', 'LIKE', '%' . $buscar . '%' )
            ->orderBy('name')
            ->get();
        }
        else
        {
            $products = Product::selectRaw('products.*, categories.name as categoryName')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->orderBy('name')
            ->get();
        }

        return response()->json( $products );
    }


    public function produtos( )
    {
        $products = Product::selectRaw('products.*, categories.name as categoryName')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->orderBy('name')
        ->get();

        return response()->json( $products );
    }


    public function verProduto( $idProduto )
    {
        $produto = Product::selectRaw('products.*, categories.name as categoryName')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->where('products.id', '=' , $idProduto)
        ->get();

        // Calculando preco com desconto
        foreach ($produto as $item)
        {
            if ( $item->discount > 0 )
            {
                $item->discount = strval( $item->price * ( 1-$item->discount/100 ) );
            }
            else
            {
                $item->discount = "";
            }

        }

        return response()->json( $produto );
    }


    public function registrar(Request $request)
    {
        $nome               = $request->name;
        $email              = $request->email;
        $senha              = $request->password;
        $senhaConfirmacao   = $request->password_confirmar;

        $retorno            = "ok";

        // Validações de Nome
        if ( $nome == "" )
        {
            $retorno = "Nome não informado!";
        }

        if ( strlen($nome) < 3 )
        {
            $retorno = "Nome precisa de pelo menos 3 caracteres!";
        }

        $usersName = User::withTrashed()->where('name', '=' , $nome)->get();
        foreach ($usersName as $userName)
        {
            if ( $nome == $userName->name )
            {
                $retorno = "Nome ja utilizado!";
            }
        }

        // Validações de E-mail
        $emails = User::withTrashed()->where('email', '=' , $email)->get();
        foreach ($emails as $emailsItem)
        {
            if ( $email == $emailsItem->email )
            {
                $retorno = "E-mail ja utilizado!";
            }
        }

        if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
        {
            $retorno = "E-mail invalido!";
        }

        // Validações da senha
        if ( strlen($senha) < 8 )
        {
            $retorno = "Senha invalida";
        }

        if ($senha !== $senhaConfirmacao)
        {
            $retorno = "Senhas diferentes!";
        }

        $status = 'true';
        $message = "Usuario criado";
        $statusHttp = 200;

        // Gravando usuário se não foi encontrado problemas
        if ( $retorno == 'ok' )
        {
            $nivel_acesso ='default';

            User::create([
                'name'      => $nome
                ,'email'    => $email
                ,'password' => Hash::make( $senha )
                ,'type'     => $nivel_acesso
            ]);
        }
        else
        {
            $status = 'false';
            $message = $retorno;
          //  $statusHttp = 401;
        }

        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
    }


    public function verUsuario( $idUsuario )
    {
        $usuario = User::selectRaw('users.name, users.email')
        ->where ( 'users.id', '=', $idUsuario)
        ->get();

        return response()->json( $usuario );
    }


    public function atualizarUsuario( Request $request, $id )
    {
        $nome               = $request->name;
        $email              = $request->email;

        $retorno            = "ok";

        $userAtualizar = User::find($id);

        // Validações de Nome, apenas valida se foi informado um nome diferente do atual
        if ( $nome !=  $userAtualizar->name )
        {

            if ( $nome == "" )
            {
                $retorno = "Nome não informado!";
            }

            if ( strlen($nome) < 3 )
            {
                $retorno = "Nome precisa de pelo menos 3 caracteres!";
            }

            $usersName = User::withTrashed()->where('name', '=' , $nome)->get();
            foreach ($usersName as $userName)
            {
                if ( $nome == $userName->name )
                {
                    $retorno = "Nome ja utilizado!";
                }
            }

        }

        // Validações de E-mai, apenas valida se foi informado um e-mail diferente do atual
        if ( $email != $userAtualizar->email )
        {
            $emails = User::withTrashed()->where('email', '=' , $email)->get();
            foreach ($emails as $emailsItem)
            {
                if ( $email == $emailsItem->email )
                {
                    $retorno = "E-mail ja utilizado!";
                }
            }

            if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
            {
                $retorno = "E-mail invalido!";
            }

        }

        $status = 'true';
        $message = "Usuario atualizado";
        $statusHttp = 200;

        // Gravando atualizações do usuário se não foi encontrado problemas
        if ( $retorno == 'ok' )
        {
            $userAtualizar->name = $nome;
            $userAtualizar->email = $email;

            $userAtualizar->save();
        }
        else
        {
            $status = 'false';
            $message = $retorno;
        }

        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
    }


    public function atualizarSenha( Request $request, $id )
    {
        $senhaAtual         = $request->senhaAtual;
        $senha              = $request->senhaNova;
        $senhaConfirmacao   = $request->senhaConfirmar;

        $retorno            = "ok";

        $atualizarSenhaUsuario = User::find($id);

        // valida senha atual
        if ( !Hash::check($senhaAtual, $atualizarSenhaUsuario->password)  )
        {
            $retorno = "Senha atual invalida";
        }

        // Validações da nova senha
        if ( strlen($senha) < 8 )
        {
            $retorno = "Senha nova invalida";
        }

        if ($senha !== $senhaConfirmacao)
        {
            $retorno = "Senha nova diferente da confirmacao!";
        }

        $status = 'true';
        $message = "Senha atualizada";
        $statusHttp = 200;

        // Gravando nova senha se não foi encontrado problemas
        if ( $retorno == 'ok' )
        {
            $atualizarSenhaUsuario->password = Hash::make( $senha );
            $atualizarSenhaUsuario->save();
        }
        else
        {
            $status = 'false';
            $message = $retorno;
          //  $statusHttp = 401;
        }

        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
    }


    public function login(Request $request)
    {
        $email  = $request->email;
        $senha  = $request->senha;

        $status = true;
        $message = "Usuario autorizado / Token gerado";
        $retorno = "";
        $userIDreturn = 0;
        $statusHttp = 200;

        $users = User::selectRaw('users.id, users.name, users.email, users.password')
        ->where ( 'users.email', '=', $email)
        ->get();

        $user = null;

        foreach ($users as $userAtual) // Sempre vai retornar apenas 1 registro (cada pedido só tem 1 valor total), mas é preciso fazer um foreach para acessar o valor
        {
            $user = $userAtual;
        }

        if ( is_null($user) )
        {
            $status = false;
            $message = 'Usuario nao encontrado!';
            $statusHttp = 401;
        }

        if ( !is_null($user) )
        {
            if ( !Hash::check($senha, $user->password)  )
            {
                $status = false;
                $message = "Senha invalida";
                $statusHttp = 401;
            }
        }

        // Criando token se não foi encontrado problemas
        if ( $status )
        {
            $userId     = $user->id;
            $secret     = $this->secretToken;
            $expiration = time() + 3600;
            $issuer     = $request->ip(); // ip do usuário

            $retorno = Token::create( $userId, $secret, $expiration, $issuer );

            // Gravando token
            $user->token = $retorno;
            $user->save();

            $userIDreturn = $user->id;
            $message = $user->name;
            $status = $user->email;
        }

        // Retorno do que foi feito
        return response()->json( [ 'success' => $status, 'message' => $message, 'token' => $retorno, 'user_id' => $userIDreturn ], $statusHttp );
    }

    public function logout(Request $request)
    {
        $user_id  = $request->user_id;

        $status = true;
        $message = "Usuario deslogado";
        $statusHttp = 200;

        $user = User::find($user_id);

        if ( is_null($user) )
        {
            $status = false;
            $message = 'Usuario nao encontrado!';
            $statusHttp = 404;
        }

        if ( $status )
        {
            $user->token = '';
            $user->save();
        }

        // Retorno do que foi feito
        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
    }

    public function carrinho( $idUser )
    {
     //   $status = true;
    //    $message = "";
    //    $statusHttp = 200;

        // if ( is_null( User::find( $idUser ) ) )
        // {
        //     $message = "Usuario nao encontrado";
        //     $status = false;
        //     $statusHttp = 401;
        // }

        // if ( $status )
        // {
            $retornoFinal = [];

            $itens = Carrinho::selectRaw('carrinhos.product_id, products.name, sum(carrinhos.quantidade) as qtd_total')
            ->join('products', 'products.id', '=', 'carrinhos.product_id')
            ->where('user_id', '=', $idUser )
            ->groupBy('carrinhos.product_id','products.name')
            ->orderBy('products.name')
            ->get();

            foreach ($itens as $item)
            {
                $produto    = Product::withTrashed()->find($item->product_id);
                $categoria  = Category::withTrashed()->find($produto->category_id);

                $imagem     = $produto->image;
                $titulo     = $produto->name;
                $produtoID  = $produto->id;
                $plataforma = $categoria->name;
                $preco      = $produto->price;
                $subTotal   = $item->qtd_total * $produto->price;
                $qtd        = $item->qtd_total;

                $retorno = [
                    "imagem"        => $imagem
                    ,"titulo"       => $titulo
                    ,'produto_id'   => $produtoID
                    ,"plataforma"   => $plataforma
                    ,"preco"        => 'R$'. str_replace(".", ",", $preco)
                    ,"subtotal"     => 'R$'. number_format($subTotal, 2,',','.')
                    ,"quantidade"   => $qtd
                ];

                array_push( $retornoFinal, $retorno );
            }

            return response()->json( $retornoFinal );
   //     }
   //     else
  //      {
    //        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
     //   }
    }

    public function carrinhoValorTotal( $idUser )
    {
        $status = true;
        $message = "";
        $statusHttp = 200;

        if ( is_null( User::find( $idUser ) ) )
        {
            $message = "Usuario nao encontrado";
            $status = false;
            $statusHttp = 404;
        }

        // if ( $status )
        // {
            $total = 0;
            $retornoFinal = [
                "total" => 'R$'. number_format($total, 2,',','.')
            ];

            $itens = Carrinho::selectRaw('carrinhos.product_id, products.name, sum(carrinhos.quantidade) as qtd_total')
            ->join('products', 'products.id', '=', 'carrinhos.product_id')
            ->where('user_id', '=', $idUser )
            ->groupBy('carrinhos.product_id','products.name')
            ->orderBy('products.name')
            ->get();



            foreach ($itens as $item)
            {
                $produto    = Product::withTrashed()->find($item->product_id);
                $subTotal   = $item->qtd_total * $produto->price;
                $total      = $total + $subTotal;

                $retornoFinal = [
                    "total" => 'R$'. number_format($total, 2,',','.')
                ];
            }

            return response()->json( $retornoFinal );
      //  }
   //     else
    //    {
    //        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
      //  }
    }

    public function carrinhoItem( $userid, $produtoid )
    {
        $status = true;
        $message = "";
        $statusHttp = 200;

        if ( is_null( User::find( $userid ) ) )
        {
            $message = "Usuario nao encontrado";
            $status = false;
            $statusHttp = 404;
        }

        if ( is_null( Product::find( $produtoid ) ) )
        {
            $message = "Produto nao encontrado";
            $status = false;
            $statusHttp = 404;
        }

        if ( $status )
        {
            $retornoFinal = [];

            $itens = Carrinho::selectRaw('carrinhos.product_id, products.name, sum(carrinhos.quantidade) as qtd_total')
            ->join('products', 'products.id', '=', 'carrinhos.product_id')
            ->where('user_id', '=', $userid )
            ->where('product_id', '=', $produtoid)
            ->groupBy('carrinhos.product_id','products.name')
            ->orderBy('products.name')
            ->get();

            foreach ($itens as $item)
            {
                $produto    = Product::withTrashed()->find($item->product_id);
                $categoria  = Category::withTrashed()->find($produto->category_id);

                $imagem     = $produto->image;
                $titulo     = $produto->name;
                $produtoID  = $produto->id;
                $plataforma = $categoria->name;
                $preco      = $produto->price;
                $subTotal   = $item->qtd_total * $produto->price;
                $qtd        = $item->qtd_total;

                $retorno = [
                    "imagem"        => $imagem
                    ,"titulo"       => $titulo
                    ,'produto_id'   => $produtoID
                    ,"plataforma"   => $plataforma
                    ,"preco"        => $preco
                    ,"subtotal"     => $subTotal
                    ,"quantidade"   => $qtd
                ];

                array_push( $retornoFinal, $retorno );
            }

            return response()->json( $retornoFinal );
        }
        else
        {
            return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
        }
    }


    public function carrinhoIncluir(Request $request)
    {
        $userID     = $request->user_id;
        $produtoID  = $request->produto_id;

        $status = 'true';
        $message = "Produto adicionado";
        $statusHttp = 200;

        if ( is_null( Product::find( $produtoID ) ) )
        {
            $message = "Produto nao encontrado";
            $status = 'false';
        //    $statusHttp = 404;
        }

        if ( is_null( User::find( $userID ) ) )
        {
            $message = "Usuario nao encontrado";
            $status = 'false';
         //   $statusHttp = 404;
        }

        if ( $status == 'true' )
        {
            $produtoNome    = Product::find( $produtoID )->name;
            $estoqueAtual   = Product::find( $produtoID )->stock;
            $quantidade     = 1;

            if ( $quantidade > $estoqueAtual )
            {
                $message = "Jogo ($produtoNome) nao possui estoque disponivel!";
                $status = 'false';
          //      $statusHttp = 401;
            }
        }

        // Gravando carrinho se não foi encontrado problemas
        if ( $status == 'true' )
        {
            Carrinho::create([
                'product_id'    => $produtoID
                ,'user_id'      => $userID
                ,'quantidade'   => 1
            ]);
        }

        // Retorno do que foi feito
        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
    }


    public function carrinhoRemover( Request $request, $idUser )
    {
        $produtoID = $request->produto_id;

        $status = 'true';
        $message = "Produto removido do carrinho";
        $statusHttp = 200;

        if ( is_null( User::find( $idUser ) ) )
        {
            $message = "Usuario nao encontrado";
            $status = 'false';
          //  $statusHttp = 404;
        }

        if ( is_null( Product::find( $produtoID ) ) )
        {
            $message = "Produto nao encontrado";
            $status = 'false';
          //  $statusHttp = 404;
        }

        if ( $status == 'true' )
        {
            // Verificar se produto existe no carrinho
            $carrinhoProdutos = Carrinho::all()
            ->where('user_id', '=' , $idUser)
            ->where('product_id', $produtoID);

            if ( count($carrinhoProdutos) == 0 )
            {
                $message = "Produto nao encontrado no carrinho desse usuario";
                $status = 'false';
               // $statusHttp = 404;
            }
        }

        // Deletando todos os registros desse produto do carrinho desse usuario se não foi encontrado problemas
        if ( $status == 'true' )
        {
            $Itens = Carrinho::withTrashed()
                ->where('user_id', $idUser )
                ->where('product_id', $produtoID)
                ->get();

            foreach ($Itens as $item)
            {
                $item->forceDelete();
            }
        }

        // Retorno do que foi feito
        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
    }


    public function carrinhoRemoverQuantidade( Request $request, $idUser )
    {
        $produtoID = $request->produto_id;

        $status = true;
        $message = "Quantidade removida";
        $statusHttp = 200;

        if ( is_null( User::find( $idUser ) ) )
        {
            $message = "Usuario nao encontrado";
            $statusHttp = 404;
            $status = false;
        }

        if ( is_null( Product::find( $produtoID ) ) )
        {
            $message = "Produto nao encontrado";
            $statusHttp = 404;
            $status = false;
        }

        if ( $status )
        {
            // Verificar se produto existe no carrinho
            $carrinhoProdutos = Carrinho::all()
            ->where('user_id', '=' , $idUser)
            ->where('product_id', $produtoID);

            if ( count($carrinhoProdutos) == 0 )
            {
                $message = "Produto nao encontrado no carrinho desse usuario";
                $statusHttp = 404;
                $status = false;
            }
        }

        if ( $status )
        {
            $Item = Carrinho::withTrashed()
                ->where('user_id', $idUser )
                ->where('product_id', $produtoID)
                ->first();

            $Item->forceDelete();
        }

        // Retorno do que foi feito
        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
    }


    public function carrinhoFinalizar( $idUser )
    {
        $status = 'true';
        $message = "Pedido gerado";
        $statusHttp = 200;

        if ( is_null( User::find( $idUser ) ) )
        {
            $message = "Usuario nao encontrado";
            $status = 'false';
          //  $statusHttp = 404;
        }

        // Verificando se existe produtos no carrinho do usuario
        $carrinhoQtd = Carrinho::all()->where('user_id', '=', $idUser )->count();

        if ( $carrinhoQtd == 0 )
        {
            $message = "Nao ha produtos no carrinho desse usuario";
            $status = 'false';
          //  $statusHttp = 404;
        }

        // Checar o estoque de cada produto no carrinho, essa select agrupa e soma a qtd dos mesmos produtos
        if ( $status == 'true' )
        {
            $Itens = Carrinho::selectRaw('carrinhos.product_id, sum(carrinhos.quantidade) as quantidade')
            ->where('user_id', '=', $idUser )
            ->groupBy('carrinhos.product_id')
            ->get();

            // Checar estoque de cada produto
            foreach ($Itens as $item)
            {
                $produtoID    = $item->product_id;

                if ( is_null( Product::find( $produtoID ) ) )
                {
                    $message = "Produto de ID $produtoID nao foi encontrado no sistema";
                    $status = 'false';
                   // $statusHttp = 404;
                }

                $produtoNome    = Product::find( $produtoID )->name;
                $estoqueAtual   = Product::find( $produtoID )->stock;
                $quantidade     = $item->quantidade;

                if ( $quantidade > $estoqueAtual )
                {
                    $message = "Produto ID $produtoID nao possui estoque disponivel!";
                    $status = 'false';
                   // $statusHttp = 401;
                }
            }
        }

        // Se não foi encontrado problemas, gerar pedido e remover itens do carrinho
        if ( $status == 'true' )
        {
            // Gerar pedido
            $pedido = Pedido::create([ 'user_id' => $idUser ]);

            // Gerar itens do pedido
            foreach ($Itens as $item)
            {
                $produto = Product::find( $item->product_id );

                // Gerar item do pedido de venda
                ItemPedido::create([
                    'fk_pedido'    => $pedido->id
                    ,'product_id'  => $produto->id
                    ,'quantidade'  => $item->quantidade
                    ,'preco'       => $produto->price
                ]);

                // Atualizando quantidade vendida do produto
                $produto->sold = $produto->sold + $item->quantidade;
                $produto->stock = $produto->stock - $item->quantidade;
                $produto->save();
            }

            // Deletar itens do carrinho do usuário
            $ItensApagar = Carrinho::withTrashed()
                ->where('user_id', $idUser )
                ->get();

            foreach ($ItensApagar as $itemApagar)
            {
                $itemApagar->forceDelete();
            }

            $pedido = $pedido->id;
            $message = $pedido;
        }

        return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
    }

    public function pedidos( $idUser )
    {
        $status = true;
        $message = "";
        $statusHttp = 200;

        if ( is_null( User::find( $idUser ) ) )
        {
            $message = "Usuario nao encontrado";
            $status = false;
          //  $statusHttp = 404;
        }

        // if ( $status )
        // {
            $retornoFinal = [];

            $pedidos = Pedido::withTrashed()->selectRaw('pedidos.*')
            ->where('user_id', '=', $idUser )
            ->orderByDesc('pedidos.id')
            ->get();

            foreach ($pedidos as $pedido)
            {
                // Valor total
                $valores = ItemPedido::selectRaw('sum(item_pedidos.quantidade * item_pedidos.preco) as total')
                ->where('fk_pedido', '=', $pedido->id)
                ->groupBy('fk_pedido')
                ->get();

                $valorTotal = '0';
                foreach ($valores as $valor) // Sempre vai retornar apenas 1 registro (cada pedido só tem 1 valor total), mas é preciso fazer um foreach para acessar o valor
                {
                     $valorTotal = floatval($valor->total);
                }
                $valortotal = 'R$'.number_format($valorTotal, 2,',','.');

                $retorno = [
                    "id"        => $pedido->id
                    ,"data"     => date('d/m/Y', strtotime( $pedido->created_at )   )
                    ,'total'    => $valortotal
                ];
                array_push( $retornoFinal, $retorno );
            }

            return response()->json( $retornoFinal );
        // }
        // else
        // {
        //     return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
        // }
    }

    public function pedidoValorTotal( $idPedido )
    {
        $retorno = "";
        $status = true;
        $message = "";
        $statusHttp = 200;

        $pedido = Pedido::withTrashed( $idPedido ) ;

        if ( is_null( $pedido  ) )
        {
            $message = "Pedido nao encontrado";
            $status = false;
         //   $statusHttp = 404;
        }

        $valorTotal = '0';

        if ( $status )
        {
            $valores = ItemPedido::selectRaw('sum(item_pedidos.quantidade * item_pedidos.preco) as total')
            ->where('fk_pedido', '=', $idPedido)
            ->groupBy('fk_pedido')
            ->get();


            foreach ($valores as $valor)
            {
                 $valorTotal = floatval($valor->total);
            }
            $retorno = 'R$'.number_format($valorTotal, 2,',','.');
        }

        return response()->json( $retorno );

        // else
        // {
        //     return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
        // }
    }

    public function pedidosItens( $idPedido )
    {
        $retorno = "ok";
        $status = true;
        $message = "";
        $statusHttp = 200;

        $pedido = Pedido::withTrashed( $idPedido ) ;

        if ( is_null( $pedido  ) )
        {
            $message = "Pedido nao encontrado";
            $status = false;
          //  $statusHttp = 404;
        }

        $retornoFinal = [];

        if ( $status )
        {
            $itens = ItemPedido::selectRaw('item_pedidos.*')->where('fk_pedido', '=', $idPedido)->orderByDesc('id')->get();

            foreach ($itens as $item)
            {
                $produto    = Product::withTrashed()->find($item->product_id);

                $preco      = $produto->price;
                $subTotal   = $item->quantidade * $produto->price;

                $retorno = [
                    "product_id"    =>  $item->product_id
                    ,"produto"      =>  $produto->name
                    ,"quantidade"   =>  $item->quantidade
                    ,'valor'        =>  'R$'. str_replace(".", ",", $preco)
                    ,'sutotal'      =>  'R$'. number_format($subTotal, 2,',','.')
                ];

                array_push( $retornoFinal, $retorno );
            }
        }

        return response()->json( $retornoFinal );

        // if ( $status )
        // {
        //     $retorno = ItemPedido::selectRaw('item_pedidos.*')->where('fk_pedido', '=', $idPedido)->orderByDesc('id')->get();
        //     return response()->json( $retorno );
        // }
        // else
        // {
        //     return response()->json( [ 'success' => $status, 'message' => $message ], $statusHttp );
        // }
    }
}
