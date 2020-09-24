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

                            <h2 class="text-center">Produto {{$product->name}}</h2>

                                <div class='form-group'>

                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input type="text" class='form-control' name="name" id="name" placeholder="Digite o nome do produto" value="{{$product->name}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id">Categoria:</label>
                                        <select name="category_id" class="form-control" id="category_id" >
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if($category->id == $product->category_id) selected @endif>
                                                {{$category->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="desc">Descrição</label>
                                        <textarea name="desc" class='form-control' rows=10  id="desc" placeholder="Digite uma descrição para o produto">{{$product->desc}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Preço (R$)</label>
                                        <input type="text" class='form-control' id='produtoPreco_show' name="price" maxlength="10" placeholder="" value="{{$product->price}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Desconto (%)</label>
                                        <input type="text" class='form-control' id='produtoDesconto_show' name="discount" maxlength="5" placeholder="" value="{{$product->discount}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Estoque</label>
                                        <input type="text" class='form-control' id="EstoqueShow" name="stock" maxlength="9" placeholder="" value="{{$product->stock}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Vendido</label>
                                        <input type="text" class='form-control' id="VendidoShow" name="sold" maxlength="9" placeholder="" value="{{$product->sold}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="home">Aparecer na Home?</label>
                                        <select name="home" class="form-control" id="home" >
                                            <option value="N" @if( $product->home == 'N') selected @endif >Não</option>
                                            <option value="S" @if( $product->home == 'S') selected @endif >Sim</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-4">
                                        <figure class="rounded mx-auto d-block mt-4 img_extra_small_prod img_small_prod img_normal_prod img_grande_prod text-center">
                                            <img id="ExibirIMG_inputfile" class="form-control img_extra_small_prod img_small_prod img_normal_prod img_grande_prod" alt="Imagem do Produto" src=" @if( empty($product->image) )  {{asset('admin_assets/images/produto_sem_imagem.jpg')}} @else {{$product->image}} @endif" >
                                            <figcaption>Imagem do produto</figcaption>
                                        </figure>
                                    </div>

                                    <div class="form-group mt-5">
                                        @php
                                            if ( $product->updated_at == null )
                                            {
                                                $DataAlteracao = 'Sem data';
                                            }
                                            else
                                            {
                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $product->updated_at );
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
            $('#produtoPreco_show').mask("#.##0,00", {reverse: true});
            $('#produtoDesconto_show').mask("#.##0,00", {reverse: true});
            $('#EstoqueShow').mask("#.##0", {reverse: true});
            $('#VendidoShow').mask("#.##0", {reverse: true});
        })

    </script>
@endsection
