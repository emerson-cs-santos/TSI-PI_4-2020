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

                            <h2 class="text-center">Usuário {{$usuario->name}}</h2>

                                <div class='p-3 bg-white'>

                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input type="text" class='form-control' name="name" id="name" placeholder="Digite o nome do Usuário" value="{{$usuario->name}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class='form-control' name="email" id="email" placeholder="Digite o nome do E-mail" value="{{$usuario->email}}">
                                    </div>

                                    <div class="form-group text-center mt-2">
                                        <figure class="rounded mx-auto d-block img_small_cli img_normal_cli">
                                            <img class="form-control img_small_cli img_normal_cli" alt="Imagem do Usuário" src="{{$usuario->image}}" data-placement="top" data-toggle="tooltip" title="Utilizado apenas aqui no Dashboard" >
                                            <figcaption>Imagem de usuário</figcaption>
                                        </figure>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="type">Nível de Acesso</label>
                                        <select name="type" class="form-control" id="type">
                                            <option value="padrao"  @if( $usuario->type == "padrao" ) selected @endif   >Padrão</option>
                                            <option value="adm"     @if( $usuario->type == "adm" )selected @endif       >Adminstrador</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        @php
                                            if ( $usuario->updated_at == null )
                                            {
                                                $DataAlteracao = 'Sem data';
                                            }
                                            else
                                            {
                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $usuario->updated_at );
                                                $DataAlteracao = $date->format('d/m/Y');
                                            }
                                        @endphp

                                        <div>
                                            <span>Última Alteração:</span>
                                        </div>
                                        <input type="text" value="{{ $DataAlteracao }}" class="form-control">
                                    </div>

                                    <a href="{{ url()->previous() }}" class='btn btn-success'>Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
