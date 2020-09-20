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

                                <h2 class="text-center">Criar cadastro manual de carrinho</h2>

                                {{-- Mostra mensagem que precisa cadastrar uma categoria antes de cadastrar um produto --}}
                                @if ( session()->has('error') )
                                    <div class="alert alert-danger"> {{ session()->get('error') }}</div>
                                @endif

                                <form action="{{route('carrinho.store')}}" class='p-3 bg-white' method="post">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="list-group">
                                                @foreach ($errors->all() as $error)
                                                    <li class="list-group-item text-danger">{{$error}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @csrf

                                    <div class="form-group">
                                        <label for="Produto">Produto ID*</label>
                                        <input type="number" class='form-control' name="Produto" id="Produto" onkeydown="return event.keyCode !== 69" autofocus required placeholder="Informe o produto" value="{{old('Produto')}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="Usuario">Usuário ID*</label>
                                        <input type="number" class='form-control' name="Usuario" id="Usuario" onkeydown="return event.keyCode !== 69" required placeholder="Informe o usuário" value="{{old('Usuario')}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Quantidade*</label>
                                        <input type="text" class='form-control' id='carrinhoQuantidade_create' name="Quantidade" maxlength="9" required placeholder="Digite a quantidade" value="{{old('Quantidade')}}">
                                    </div>

                                    <button type="submit" class="btn btn-success">Criar</button>
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

@section('script')
    <script>

        // Máscara dos valores
        $(document).ready(function($)
        {
            $('#carrinhoQuantidade_create').mask("#.##0", {reverse: true});
        })

    </script>
@endsection

