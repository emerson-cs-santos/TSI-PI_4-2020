@extends('layouts.Admin')

@section('content_Admin')

    <section class='mt-5'>
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row align-items-center">

                        {{-- Conteiner final onde as informações são de fato exibidas --}}
                        <div class="container mt-2">
                            <div class="col-12">

                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif

                                @if(session()->has('error'))
                                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                                @endif

                                <h2 class="text-center"> {{ Request::path() !== 'trashed-pedido' ? 'Controle de pedidos' : 'Pedidos Cancelados' }} </h2>

                                {{-- @if( Request::path() == 'index-pedido' )
                                    <div class='d-flex mb-2 justify-content-center'>
                                        <a href="{{route('pedido.create')}}" class='btn btn-success'>Novo</a>
                                    </div>
                                @endif --}}

                                @if( Request::path() !== 'trashed-pedido')
                                    <form action="/buscar-index-pedido" method="POST" role="search">
                                    {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-11 mt-2">
                                                <input type="search" name="busca" class="form-control" placeholder="O que está buscando?" data-placement="top" data-toggle="tooltip" title="Essa busca não considera o valor total"
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
                                                <th>Nro Pedido(ID)</th>
                                                <th>Usuário</th>
                                                <th>Data</th>
                                                <th>Valor Total</th>
                                                @if( count($pedidos) > 0 )
                                                    <th class="text-center" @if( Request::path() == 'trashed-pedido' ) colspan="1" @else colspan="2" @endif  >Ações</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pedidos as $pedido)
                                                <tr>
                                                    <td>{{$pedido->id}}</td>
                                                    <td> @if ( $pedido->user_id > 0 ) {{App\Models\Pedido::withTrashed()->find($pedido->id)->usuario->name}} @else Sem usuário @endif</td>
                                                    @php
                                                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $pedido->created_at );
                                                    @endphp

                                                    <td>{{$date->format('d/m/Y')}}</td>

                                                    <td>{{ $pedido->valorTotal() }}</td>

                                                    <td>
                                                        <a href="{{ route('item-pedido', $pedido->id) }}" class="btn btn-xs btn-secondary">Ver Pedido</a>
                                                    </td>

                                                    {{-- @if($pedido->trashed())
                                                        <td>
                                                            <form action="{{ route('restore-pedido.update', $pedido->id) }}"  method="POST" onsubmit="return confirm('Você tem certeza que quer reativar?')">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" href="#" class="btn btn-primary btn-sm float-center ml-1">Descancelar Pedido</button>
                                                            </form>
                                                        </td>
                                                    @endif --}}

                                                    @if ( !$pedido->trashed() )
                                                        <td>
                                                            <form  action="{{ route('pedido.destroy', $pedido->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" onclick="confirmar('Cancelar pedido','Você tem certeza?', this.form)" class="btn btn-danger btn-xs float-center"> Cancelar Pedido </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- Tabela fim --}}

                                <!---Pagination-->
                                <div class="pagination justify-content-center mt-3">

                                    @if ($pedidos->hasPages())
                                        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                                            {{-- Previous Page Link --}}
                                            @if ($pedidos->onFirstPage())
                                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                                    {!! __('pagination.previous') !!}
                                                </span>
                                            @else
                                                <a href="{{ $pedidos->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                                    {!! __('pagination.previous') !!}
                                                </a>
                                            @endif

                                            {{-- Next Page Link --}}
                                            @if ($pedidos->hasMorePages())
                                                <a href="{{ $pedidos->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
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

                                @if( Request::path() !== 'trashed-pedido' )
                                    <a href="{{ route('trashed-pedido.index') }}" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" title="Acessar pedidos cancelados">Pedidos cancelados</a>
                                @else
                                    <a href="{{route('index-pedido')}}" class='btn btn-info'>Voltar aos pedidos</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
