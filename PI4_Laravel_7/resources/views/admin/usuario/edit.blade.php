@extends('layouts.Admin')

@section('content_Admin')
    <section class='mt-5'>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row align-items-center">

                        {{-- Conteiner final onde as informações são de fato exibidas --}}
                        <div class="container mt-5">
                            <div class="col-12">

                                <h2 class="text-center">Alterar Usuário</h2>

                                <form action="{{route('Users.update', $usuario->id)}}" class='p-3 bg-white' method="post" enctype="multipart/form-data">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="list-group">
                                                @foreach ($errors->all() as $error)
                                                    <li class="list-group-item text-danger"> {{ Str::replaceArray('2000 kilobytes', ['2 MegaBytes'], $error) }} </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group" hidden>
                                        <label for="id">ID</label>
                                        <input type="number" class='form-control' name="id" id="id" value="{{$usuario->id}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Nome*</label>
                                        <input type="text" class='form-control' name="name" id="name" required placeholder="Digite o nome do Usuário" autofocus value="{{$usuario->name}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">E-mail*</label>
                                        <input type="email" class='form-control' name="email" id="email" required placeholder="Digite o nome do E-mail" value="{{$usuario->email}}">
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="imagem">Definir imagem</label>
                                        <input class="form-control" type="file" name="imagem" id="imagem" accept="image/png, image/jpeg, image/jpg" onchange="preview_image(event)" >

                                        <figure class="rounded mx-auto d-block img_small_cli img_normal_cli mt-4 text-center">
                                            <img id="ExibirIMG_inputfile" class="form-control img_small_cli img_normal_cli" alt="Imagem do Usuário" src=" @if( empty($usuario->image) )  {{asset('admin_assets/images/produto_sem_imagem.jpg')}} @else {{$usuario->image}} @endif" data-placement="top" data-toggle="tooltip" title="Utilizado apenas aqui no Dashboard" >
                                            <figcaption>Imagem de usuário</figcaption>
                                        </figure>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="type">Nível de Acesso*</label>
                                        <select name="type" class="form-control" id="type" >
                                            <option value="padrao"  @if( $usuario->type == "padrao" ) selected @endif   >Padrão</option>
                                            <option value="adm"     @if( $usuario->type == "adm" )selected @endif       >Adminstrador</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Senha*</label>
                                            <input type="password" id='usuario_editar_senha' class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Digite a senha" required autocomplete="new-password" disabled >
                                        </div>

                                        <div class="form-group">
                                            <label>Confirme a senha*</label>
                                            <input type="password" id='usuario_editar_confirmarSenha' class='form-control' name="password_confirmation" placeholder="Digite a senha" required autocomplete="new-password" disabled>
                                        </div>

                                        <div class="form-group">
                                            <input id = 'usuario_editar_senha_checkbox' type="checkbox" value="" onchange='senhaHabilitar()' data-placement="top" data-toggle="tooltip" title="Ative essa opção para definir uma nova senha">
                                            <label>Alterar Senha</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-warning">Salvar</button>
                                    <a href="{{ url()->previous() }}" class='btn btn-primary'>Voltar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
