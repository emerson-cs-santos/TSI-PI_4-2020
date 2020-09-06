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

                                <h2 class="text-center">Carrinho {{$carrinho->id}}</h2>

                                <div class='form-group'>
                                    <div class="form-group">
                                        <label for="Produto">Produto ID</label>
                                        <input type="number" class='form-control' name="Produto" id="Produto" onkeydown="return event.keyCode !== 69" placeholder="Informe o produto" value="{{$carrinho->product_id}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="Usuario">Usuário ID</label>
                                        <input type="number" class='form-control' name="Usuario" id="Usuario" onkeydown="return event.keyCode !== 69" placeholder="Informe o usuário" value="{{$carrinho->user_id}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Quantidade</label>
                                        <input type="text" class='form-control' id="carrinhoQuantidade_show" name="Quantidade" maxlength="9" placeholder="Digite a quantidade" value="{{$carrinho->quantidade}}">
                                    </div>

                                    <div class="form-group">
                                        @php
                                            if ( $carrinho->updated_at == null )
                                            {
                                                $DataAlteracao = 'Sem data';
                                            }
                                            else
                                            {
                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $carrinho->updated_at );
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

@section('script')
    <script>

        // Máscara dos valores
        $(document).ready(function($)
        {
            $('#carrinhoQuantidade_show').mask("#.##0", {reverse: true});
        })

    </script>
@endsection
