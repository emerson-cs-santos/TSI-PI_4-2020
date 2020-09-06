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

                            @if(!Str::contains(Request::path(), 'trashed-cliente'))
                                <h2 class="text-center">Cadastro de Clientes</h2>
                                <div class='d-flex mb-2 justify-content-center '>
                                    <a href="{{route('clientes.create')}}" class='btn btn-success'>Novo</a>
                                </div>
                            @else
                                <h2 class="text-center mb-5">Lixeira de Clientes</h2>
                            @endif

                            {{-- Tabela inicio --}}
                            <div class="table-responsive mt-3">
                                <table class="table table-striped bg-light text-center table-bordered">
                                    <thead class="text-dark">
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Usuário no Sistema</th>
                                    </thead>
                                    <tbody>
                                        @foreach($clientes as $cliente)
                                        <tr>
                                            <td>{{$cliente->id}}</td>
                                            <td>{{$cliente->name}}</td>
                                            <td> @if ( $cliente->user_id > 0 ) {{App\Cliente::withTrashed()->find($cliente->user_id)->usuario->name}} @else Sem usuário @endif</td>
                                            @if(!$cliente->trashed())
                                            <td>
                                                <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-xs btn-primary">Visualizar</a>
                                            </td>

                                            <td>
                                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-xs btn-warning">Editar</a>
                                            </td>
                                            @else
                                            <td>
                                                <form action="{{ route('restore-cliente.update', $cliente->id) }}" class="d-inline" method="POST" onsubmit="return confirm('Você tem certeza que quer reativar?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" href="#" class="btn btn-primary btn-xs float-center">Reativar</a>
                                                </form>
                                            </td>
                                            @endif
                                            <td>
                                                <form action="{{ route('clientes.destroy', $cliente->id) }}" class="d-inline" method="POST" onsubmit="return confirm('Você tem certeza que quer apagar?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" href="#" class="btn btn-danger btn-xs float-center">Enviar para Lixeira</a>
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
                                {{ $clientes->links() }}
                            </div>
                            <!---End of Pagination-->

                            @if( Request::path() == 'clientes' )
                            <a href="{{ route('trashed-cliente.index') }}" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" title="Acessar registros excluídos">Lixeira</a>
                            @else
                            <a href="{{route('clientes.index')}}" class='btn btn-info'>Voltar ao cadastro</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
