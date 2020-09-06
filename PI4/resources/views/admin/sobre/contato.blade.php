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

                                <h2 class="text-center">Atualizar "Contato"</h2>

                                <form action="{{route('sobre-contato-atualizar')}}" class='p-3 bg-white' method="post" enctype="multipart/form-data">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="list-group">
                                                @foreach ($errors->all() as $error)
                                                <li class="list-group-item text-danger">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="Titulo">Titulo*</label>
                                        <input type="text" class='form-control' name="Titulo" id="Titulo" autofocus required placeholder="Digite um título" value="{{$contato->titulo}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="Texto">Texto*</label>
                                        <textarea name="Texto" class='form-control' rows=15 id="Texto" required placeholder="Digite as informações para contato">{{$contato->texto}}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-success mt-3">Atualizar</button>
                                    <a href="{{ url()->previous() }}" class='btn btn-primary mt-3'>Voltar</a>
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

    </script>
@endsection
