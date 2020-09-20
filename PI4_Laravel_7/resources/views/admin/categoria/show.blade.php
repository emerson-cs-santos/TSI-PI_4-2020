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

                                <h2 class="text-center">Categoria {{$category->name}}</h2>

                                <div class='form-group'>
                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input type="text" class='form-control' name="name" id="name" placeholder="Digite o nome da categoria" value="{{$category->name}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="home">Aparecer no rodapé do site?</label>
                                        <select name="home" class="form-control" id="home" >
                                            <option value="N" @if( $category->home == 'N') selected @endif >Não</option>
                                            <option value="S" @if( $category->home == 'S') selected @endif >Sim</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        @php
                                            if ( $category->updated_at == null )
                                            {
                                                $DataAlteracao = 'Sem data';
                                            }
                                            else
                                            {
                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $category->updated_at );
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
