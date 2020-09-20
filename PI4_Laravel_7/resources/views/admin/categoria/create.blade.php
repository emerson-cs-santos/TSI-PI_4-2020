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

                                <h2 class="text-center">Cadastrar Categoria</h2>

                                {{-- Mostra mensagem que precisa cadastrar uma categoria antes de cadastrar um produto --}}
                                @if ( session()->has('error') )
                                    <div class="alert alert-danger"> {{ session()->get('error') }}</div>
                                @endif

                                <form action="{{route('categories.store')}}" class='p-3 bg-white' method="post">
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
                                        <label for="name">Nome*</label>
                                        <input type="text" class='form-control' name="name" id="name" autofocus required placeholder="Digite o nome da categoria" value="{{old('name')}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="home">Aparecer no rodapé do site?</label>
                                        <select name="home" class="form-control" id="home" >
                                            <option value="N" @if( old('home') == 'N') selected @endif >Não</option>
                                            <option value="S" @if( old('home') == 'S') selected @endif >Sim</option>
                                        </select>
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
