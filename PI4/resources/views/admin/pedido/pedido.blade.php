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

                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif

                                @if(session()->has('error'))
                                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                                @endif

                                <h2 class="text-center"> Pedido {{$pedido->id}} @if ( $pedido->trashed() ) (CANCELADO) @endif </h2>

                                <div class="row">
                                    <span class="h3 col-md-2" >Usuário: </span>
                                    <span class="h3 col-md-10 font-weight-bold" >{{ $pedido->usuario->name }} </span>
                                </div>

                                <div class="row">
                                    <span class="h3 col-md-2" >Valor Total: </span>
                                    <span class="h3 col-md-10 font-weight-bold" >{{ $pedido->valorTotal() }} </span>
                                </div>

                                <div class="row">
                                    <span class="h3 col-md-2" >Data: </span>
                                    @php
                                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $pedido->created_at );
                                    @endphp
                                    <span class="h3 col-md-10 font-weight-bold" >{{ $date->format('d/m/Y') }} </span>
                                </div>

                                <div class="row">
                                    <span class="h3 col-md-2" >Status: </span>
                                    <span class="h3 col-md-10 font-weight-bold" >Pagamento aprovado </span>
                                </div>

                                <div class="row">
                                    <span class="h3 col-md-2" >Entrega: </span>
                                    <span class="h3 col-md-10 font-weight-bold" >Pendente </span>
                                </div>


                                {{-- Tabela inicio --}}
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped bg-light text-center table-bordered">
                                        <thead class="text-dark">
                                            <tr>
                                                <th>Código</th>
                                                <th>Produto</th>
                                                <th>Quantidade</th>
                                                <th>Valor</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($itensPedido as $itemPedido)
                                            <tr>
                                                <td>{{$itemPedido->id}}</td>
                                                <td> @if ( $itemPedido->product_id > 0 ) {{App\Models\ItemPedido::find($itemPedido->id)->produto->name}} @else Sem produto @endif</td>
                                                <td>{{number_format($itemPedido->quantidade,0,',','.')}}</td>
                                                <td>{{'R$'.number_format($itemPedido->preco, 2) }}</td>
                                                <td>{{'R$'.number_format($itemPedido->quantidade * $itemPedido->preco, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- Tabela fim --}}

                                <!---Pagination-->
                                <div class="pagination justify-content-center mt-3">

                                    @if ($itensPedido->hasPages())
                                        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                                            {{-- Previous Page Link --}}
                                            @if ($itensPedido->onFirstPage())
                                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                                    {!! __('pagination.previous') !!}
                                                </span>
                                            @else
                                                <a href="{{ $itensPedido->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                                    {!! __('pagination.previous') !!}
                                                </a>
                                            @endif

                                            {{-- Next Page Link --}}
                                            @if ($itensPedido->hasMorePages())
                                                <a href="{{ $itensPedido->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
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

                                @if( $pedido->trashed() )
                                    <a href="{{ url()->previous() }}" class='btn btn-info'>Voltar aos pedidos cancelados</a>
                                @else
                                    <a href="{{ url()->previous() }}" class='btn btn-info'>Voltar aos pedidos</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
