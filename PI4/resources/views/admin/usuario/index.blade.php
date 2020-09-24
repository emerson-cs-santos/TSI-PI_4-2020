@extends('layouts.Admin')

@section('content_Admin')

    <section class='mt-2'>

        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row align-items-center">

                        {{-- Conteiner final onde as informações são de fato exibidas --}}
                        <div class="container mt-5">
                            <div class="col-12">

                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif

                                @if(session()->has('error'))
                                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                                @endif

                                <h2 class="text-center"> {{ Request::path() == 'trashed-Users' ? 'Lixeira de Usuários' : 'Cadastro de Usuários' }} </h2>

                                @if( Request::path() !== 'trashed-Users' )
                                    <div class='d-flex mb-2 justify-content-center'>
                                        <a href="{{route('Users.create')}}" class='btn btn-success'>Novo</a>
                                    </div>
                                @endif

                                @if( Request::path() !== 'trashed-Users')
                                    <form action="/buscar-Users" method="POST" role="search">
                                    {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-11 mt-2">
                                                <input type="search" name="busca" class="form-control" placeholder="O que está buscando?"
                                                    @if( isset($busca) )  value="{{$busca}}"  @endif >
                                            </div>

                                            <div class="col-12 col-sm-12 col-md-1 mt-2">
                                                <button type="submit" class="btn btn-secondary" data-placement="top" data-toggle="tooltip" title="Fazer busca">
                                                    <span class="fa fa-search"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                {{-- Tabela inicio --}}
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped bg-light text-center table-bordered table-hover">
                                        <thead class="text-dark">
                                            <tr>
                                                <th>Código</th>
                                                <th>Nome</th>
                                                <th>E-mail</th>
                                                <th>Nível</th>
                                                @if( count($usuarios) > 0 )
                                                    <th class="text-center" @if( Request::path() == 'trashed-Users' ) colspan="2" @else colspan="3" @endif  >Ações</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($usuarios as $usuario)
                                            <tr>
                                                <td>{{$usuario->id}}</td>
                                                <td>{{$usuario->name}}</td>
                                                <td>{{$usuario->email}}</td>
                                                <td>{{ $usuario->type == 'admin' ? ' Administrador' : 'Padrão' }}</td>

                                                @if(!$usuario->trashed())
                                                    <td>
                                                        <a href="{{ route('Users.show', $usuario->id) }}" class="btn btn-xs btn-primary">Visualizar</a>
                                                    </td>

                                                    <td>
                                                        <a href="{{ route('Users.edit', $usuario->id) }}" class="btn btn-xs btn-warning">Editar</a>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form action="{{ route('restore-Users.update', $usuario->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" onclick="confirmar('Reativar registro','Você tem certeza?', this.form)" class="btn btn-primary btn-xs float-center ml-1">Reativar</button>
                                                        </form>
                                                    </td>
                                                @endif

                                                <td>
                                                    <form action="{{ route('Users.destroy', $usuario->id) }}" class="d-inline" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        @php
                                                            $acaoDeletar = $usuario->trashed() ? 'Apagar' : 'Mover para Lixeira';
                                                        @endphp
                                                        <button type="button" onclick="confirmar('{{ $acaoDeletar }}','Você tem certeza?', this.form)" class="btn btn-danger btn-xs float-center"> {{ $acaoDeletar}} </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- Tabela fim --}}

                                <!---Pagination-->
                                <div class="pagination justify-content-center mt-3">
                                   
                                    @if ($usuarios->hasPages())
                                        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                                            {{-- Previous Page Link --}}
                                            @if ($usuarios->onFirstPage())
                                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                                    {!! __('pagination.previous') !!}
                                                </span>
                                            @else
                                                <a href="{{ $usuarios->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                                    {!! __('pagination.previous') !!}
                                                </a>
                                            @endif
                                    
                                            {{-- Next Page Link --}}
                                            @if ($usuarios->hasMorePages())
                                                <a href="{{ $usuarios->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                                    {!! __('pagination.next') !!}
                                                </a>
                                            @else
                                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                                    {!! __('pagination.next') !!}
                                                </span>
                                            @endif
                                        </nav>
                                    @endif

                                </div>
                                <!---End of Pagination-->                                

                                @if( Request::path() == 'trashed-Users' )
                                    <a href="{{route('Users.index')}}" class='btn btn-info'>Voltar ao cadastro</a>
                                @else
                                    <a href="{{ route('trashed-Users.index') }}" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" title="Acessar registros excluídos">Lixeira</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
