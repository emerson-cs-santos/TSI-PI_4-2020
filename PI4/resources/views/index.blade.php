@extends('layouts.Admin')

@section('content_Admin')

    <!---Cards-->
    <section>
        <header class="container-fluid">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto row pt-md-5 mt-2 text-dark">
                @php
                    date_default_timezone_set('America/Sao_Paulo');
                @endphp
                <h2 class="">Status: ( Atualizado em {{ date('d/m/Y \à\s H:i:s',time())}} )</h2>
            </div>
        </header>

@endsection
