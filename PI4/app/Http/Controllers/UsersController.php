<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\CreateUsersRequest;
use App\Http\Requests\EditUserRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::selectRaw('users.*')->orderByDesc('id')->paginate(5);

        return view('admin.usuario.index', ['usuarios' => $users]);
    }


    public function create()
    {
        return view('admin.usuario.create');
    }


    public function store(CreateUsersRequest $request)
    {
        $file = $request->file('imagem');

        $imagem_convertida = "";

        if ( !empty($file) )
        {
             $data               = file_get_contents($file);
             $dataEncoded        = base64_encode($data);
             $imagem_convertida  = "data:image/jpeg;base64,$dataEncoded";
        }

        // Pegando Nivel de acesso enviado pela pagina de criar novo cadastro
        $nivel_acesso = "";
        if ($request->type == 'adm')
        {
            $nivel_acesso ='admin';
        }
        else
        {
            $nivel_acesso ='default';
        }

        User::create([
            'name'      => $request->name
            ,'email'    => $request->email
            ,'password' => Hash::make($request['password']) //$request->password
            ,'image'    => $imagem_convertida
            ,'type'     => $nivel_acesso
        ]);

        session()->flash('success', 'Usuário criado com sucesso!');

        return redirect(route('Users.index'));
    }


    public function show($id)
    {
        $usuario_visualizar = User::find($id);

        if ( empty($usuario_visualizar->image) )
        {
         $usuario_visualizar->image = asset('admin_assets/images/produto_sem_imagem.jpg');
        }

        // Real tipo que fica salvo no Banco não ser exibido na página
        if ($usuario_visualizar->type == 'admin')
        {
            $usuario_visualizar->type ='adm';
        }
        else
        {
            $usuario_visualizar->type ='padrao';
        }

         return view('admin.usuario.show')->with('usuario', $usuario_visualizar );
    }


    public function edit($id)
    {
        $usuario_editar =  User::find($id);

        // Real tipo que fica salvo no Banco não ser exibido na página
        if ($usuario_editar->type == 'admin')
        {
            $usuario_editar->type ='adm';
        }
        else
        {
            $usuario_editar->type ='padrao';
        }

        return view('admin.usuario.edit')->with('usuario',$usuario_editar);
    }


    public function update(EditUserRequest $request, $id)
    {
        $usuario = User::find($request->id);

        $usuario->name = $request->name;
        $usuario->email = $request->email;

        // Pegando Nivel de acesso enviado pela pagina de criar novo cadastro
        $nivel_acesso = "";
        if ($request->type == 'adm')
        {
            $nivel_acesso ='admin';
        }
        else
        {
            $nivel_acesso ='default';
        }
        $usuario->type = $nivel_acesso;

        if($usuario->email != $request->email){
            $usuario->email = $request->email;
            $usuario->email_verified_at = null;
        }

        // Apenas gravar nova senha se foi alterada na edição do cadastro.
        if ( !$request->password == '')
        {
            $usuario->password = Hash::make( $request['password'] );
        }

        // Apenas gravar imagem se foi alterada
        $file = $request->file('imagem');
       if ( !empty($file) )
       {
            $data               = file_get_contents($file);
            $dataEncoded        = base64_encode($data);
            $imagem_convertida  = "data:image/jpeg;base64,$dataEncoded";

            $usuario->image     = $imagem_convertida;
       }

       $usuario->save();

       session()->flash('success', 'Usuário alterado com sucesso!');

       return redirect(route('Users.index'));
    }


    public function destroy($id)
    {
        if ( auth()->user()->id  == intval($id) )
        {
            session()->flash('error', "Você não pode excluir seu próprio usuário!");
            return redirect()->back();
        }

        // $carrinhoQtd = Carrinho::withTrashed()->where('user_id',$id)->count();

        // if ( $carrinhoQtd > 0 )
        // {
        //     session()->flash('error', "Usuário possui produto(s) no carrinho!");
        //     return redirect()->back();
        // }

        // $pedidoQtd = Pedido::withTrashed()->where('user_id',$id)->count();

        // if ( $pedidoQtd > 0 )
        // {
        //     session()->flash('error', "Usuário possui pedido(s)!");
        //     return redirect()->back();
        // }

        $User = User::withTrashed()->where('id', $id)->firstOrFail();

        if($User->trashed())
        {
            $User->forceDelete();
            session()->flash('success', 'Usuário apagado com sucesso!');
        }
        else
        {
            $User->delete();
            session()->flash('success', 'Usuário movido para lixeira com sucesso!');
        }

        return redirect()->back();
    }

    public function trashed()
    {
        $users = User::selectRaw('users.*')->onlyTrashed()->orderByDesc('id')->paginate(5);
        return view('admin.usuario.index', ['usuarios' => $users]);
    }

    public function restore($id)
    {
        $user = User::withTrashed()->where('id', $id)->firstOrFail();
        $user->restore();
        session()->flash('success', 'Usuário ativado com sucesso!');
        return redirect()->back();
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('busca');

        if($buscar != "")
        {
            $users = User::selectRaw('users.*')
            ->where ( 'users.name', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'users.id', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'users.email', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'users.type', 'LIKE', '%' . $buscar . '%' )
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            $pagination = $users->appends ( array ('busca' => $request->input('busca')  ) );

            return view('admin.usuario.index')
            ->with('usuarios',$users )->withQuery ( $buscar )
            ->with('busca',$buscar);
        }
        else
        {
            $users = User::selectRaw('users.*')
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            return view('admin.usuario.index')
            ->with('usuarios', $users )
            ->with('busca','');
        }
    }
}
