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

                                <h2 class="text-center"> {{ Request::path() == 'trashed-product' ? 'Lixeira de produtos' : 'Cadastro de Produtos'  }} </h2>

                                @if( Request::path() !== 'trashed-product' )
                                    <div class='d-flex mb-2 justify-content-center'>
                                        <a href="{{route('products.create')}}" class='btn btn-success'>Novo</a>
                                    </div>
                                @endif

                                @if( Request::path() !== 'trashed-product')
                                    <form action="/buscar-products" method="POST" role="search">
                                    {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-11 mt-2">
                                                <input type="search" name="busca" class="form-control" placeholder="O que está buscando?" data-placement="top" data-toggle="tooltip" title="Essa busca não considera o estoque"
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
                                                <th>Preview</th>
                                                <th>Estoque</th>
                                                <th>Preço</th>
                                                <th>Desconto</th>
                                                @if( count($products) > 0 )
                                                    <th class="text-center" @if( Request::path() == 'trashed-product' ) colspan="2" @else colspan="3" @endif  >Ações</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $product)
                                            <tr>
                                                <td>{{$product->id}}</td>
                                                <td>{{$product->name}}</td>
                                                <td> <img src="@if ( empty($product->image) ) {{asset('admin_assets/images/produto_sem_imagem.jpg')}} @else {{$product->image}} @endif" alt="Preview do produto" class='img_preview'> </td>
                                                <td> {{ number_format($product->stock,0,',','.') }} </td>
                                                <td>{{$product->price()}}</td>
                                                <td>{{$product->descontoExibir()}}</td>

                                                @if(!$product->trashed())
                                                    <td>
                                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-xs btn-primary">Visualizar</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-xs btn-warning">Editar</a>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form action="{{ route('restore-product.update', $product->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" onclick="confirmar('Reativar registro','Você tem certeza?', this.form)" class="btn btn-primary btn-xs float-center ml-1">Reativar</button>
                                                        </form>
                                                    </td>
                                                @endif

                                                <td>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        @php
                                                            $acaoDeletar = $product->trashed() ? 'Apagar' : 'Mover para Lixeira';
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
                                <div class="pagination justify-content-center">
                                    {{ $products->links() }}
                                </div>
                                <!---End of Pagination-->

                                @if( Request::path() == 'trashed-product' )
                                    <a href="{{route('products.index')}}" class='btn btn-info'>Voltar ao cadastro</a>
                                @else
                                    <a href="{{ route('trashed-product.index') }}" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" title="Acessar registros excluídos">Lixeira</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
