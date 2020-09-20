@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header MenuLogin">{{ __('Verique se endereço de e-mail') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Uma nova mensagem de verificação foi enviado ao seu e-mail.') }}
                        </div>
                    @endif

                    {{ __('Antes de prosseguir, por favor verifique a mensagem de verificação envidada ao seu e-mail.') }}
                    {{ __('Se você não recebeu o e-mail') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Clique aqui para receber outro') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection