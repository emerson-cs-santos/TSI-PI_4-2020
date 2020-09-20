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

                                <h2 class="text-center">Sobre a Loja</h2>

                                <div class="col-md-12">

                                    <div class="card rounded">
                                        <div class="card-body">
                                            <h3 class='card-title h4 text-center'>Alterar páginas:</h3>

                                            <div class="row align-items-center mb-2">

                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                    <div class="card bg-light">
                                                        <i class="fa fa-group fa-8x text-info d-block m-auto py-3"></i>

                                                        <div class="card-body text-center">
                                                            <p class="card-text font-weight-bold">Quem somos</p>
                                                            <a href="{{route('sobre-quem-somos')}}" class='btn btn-primary'>Alterar</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-sm-12 col-md-6 mt-3">
                                                    <div class="card bg-light">
                                                        <i class="fa fa-envelope-o fa-8x text-danger d-block m-auto py-3"></i>

                                                        <div class="card-body text-center">
                                                            <p class="card-text font-weight-bold">Contato</p>
                                                            <a href="{{route('sobre-contato')}}" class='btn btn-primary'>Alterar</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
