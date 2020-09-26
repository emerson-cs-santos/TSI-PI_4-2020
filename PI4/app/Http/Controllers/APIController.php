<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Carrinho;
use Illuminate\Support\Facades\Hash;

class APIController extends Controller
{
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

    public function categorias()
    {
        $categorias = Category::all()->sortByDesc('id');

        return response()->json( $categorias );
    }

    // Produtos da categoria
    public function categoriaProdutos( $id_categoria )
    {
        $produtos = Product::all()->where('category_id', '=' , $id_categoria)->sortByDesc('id');

        return response()->json( $produtos );
    }

    public function lancamentos()
    {
        $lancamentos    = Product::all()->sortByDesc('id');

        return response()->json( $lancamentos );
    }

    public function maisVendidos()
    {
        $maisVendidos   = Product::all()->sortByDesc('sold');

        return response()->json( $maisVendidos );
    }

    public function busca( $buscar )
    {
        $products = "";

        if($buscar != "")
        {
            $products = Product::selectRaw('products.*')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where ( 'products.name', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'categories.name', 'LIKE', '%' . $buscar . '%' )
            ->orderBy('name')
            ->get();
        }
        else
        {
            $products = Product::selectRaw('products.*')
            ->orderBy('name')
            ->get();
        }

        return response()->json( $products );
    }

    public function produtos( )
    {
        $products = Product::selectRaw('products.*')
        ->orderBy('name')
        ->get();

        return response()->json( $products );
    }

    public function verProduto( $idProduto )
    {
        $produto = Product::find( $idProduto );

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

        // Retorno do que foi feito
        return response()->json( $retorno );
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

        // Gravando atualizações do usuário se não foi encontrado problemas
        if ( $retorno == 'ok' )
        {
            $userAtualizar->name = $nome;
            $userAtualizar->email = $email;

            $userAtualizar->save();
        }

        // Retorno do que foi feito
        return response()->json( $retorno );
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

        // Gravando nova senha se não foi encontrado problemas
        if ( $retorno == 'ok' )
        {
            $atualizarSenhaUsuario->password = Hash::make( $senha );
            $atualizarSenhaUsuario->save();
        }

        // Retorno do que foi feito
        return response()->json( $retorno );
    }


    public function login(Request $request)
    {
        $id     = $request->id;
        $senha  = $request->senha;

        $retorno            = "ok";

        $user = User::find($id);

        if ( is_null($user) )
        {
            $retorno = 'Usuario nao encontrado!';
        }

        if ( !is_null($user) )
        {
            if ( !Hash::check($senha, $user->password)  )
            {
                $retorno = "Senha invalida";
            }
        }

        // Gravando usuário se não foi encontrado problemas
        if ( $retorno == 'ok' )
        {
            // Retornar token?
        }

        // Retorno do que foi feito
        return response()->json( $retorno );
    }

    public function carrinho( $idUser )
    {
        $retorno = "ok";

        if ( is_null( User::find( $idUser ) ) )
        {
            $retorno = "Usuario nao encontrado";
        }

        if ( $retorno == 'ok' )
        {
            $itens = Carrinho::selectRaw('carrinhos.product_id, products.name, sum(carrinhos.quantidade) as qtd_total')
            ->join('products', 'products.id', '=', 'carrinhos.product_id')
            ->where('user_id', '=', $idUser )
            ->groupBy('carrinhos.product_id','products.name')
            ->orderBy('products.name')
            ->get();
        }

        return response()->json( $itens );
    }

    public function carrinhoIncluir(Request $request)
    {
        $userID     = $request->user_id;
        $produtoID  = $request->produto_id;

        $retorno            = "ok";

        if ( is_null( Product::find( $produtoID ) ) )
        {
            $retorno = "Produto nao encontrado";
        }

        if ( is_null( User::find( $userID ) ) )
        {
            $retorno = "Usuario nao encontrado";
        }

        if ( $retorno == 'ok' )
        {
            $produtoNome    = Product::find( $produtoID )->name;
            $estoqueAtual   = Product::find( $produtoID )->stock;
            $quantidade     = 1;

            if ( $quantidade > $estoqueAtual )
            {
                $retorno = "Jogo ($produtoNome) nao possui estoque disponivel!";
            }
        }

        // Gravando carrinho se não foi encontrado problemas
        if ( $retorno == 'ok' )
        {
            Carrinho::create([
                'product_id'    => $produtoID
                ,'user_id'      => $userID
                ,'quantidade'   => 1
            ]);
        }

        // Retorno do que foi feito
        return response()->json( $retorno );
    }
}
