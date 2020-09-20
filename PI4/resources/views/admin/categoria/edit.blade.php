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

                                <h2 class="text-center">Alterar Categoria</h2>

                                <form action="{{route('categories.update', $category->id)}}" class='p-3 bg-white' method="post">
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
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="name">Nome*</label>
                                        <input type="text" class='form-control' name="name" id="name" autofocus required placeholder="Digite o nome da categoria" value="{{$category->name}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="home">Aparecer no rodapé do site?</label>
                                        <select name="home" class="form-control" id="home">
                                            <option value="N" @if( $category->home == 'N') selected @endif >Não</option>
                                            <option value="S" @if( $category->home == 'S') selected @endif >Sim</option>
                                        </select>
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
