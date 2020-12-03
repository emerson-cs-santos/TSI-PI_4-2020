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

                                <h2 class="text-center">Cadastrar Produto</h2>

                                <form action="{{route('products.store')}}" class='p-3 bg-white' method="post" enctype="multipart/form-data">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="list-group">
                                                @foreach ($errors->all() as $error)
                                                <li class="list-group-item text-danger">{{ Str::replaceArray('2000 kilobytes', ['2 MegaBytes'], $error) }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Nome*</label>
                                        <input type="text" class='form-control' name="name" id="name" autofocus required placeholder="Digite o nome do produto" value="{{old('name')}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id">Categoria*:</label>
                                        <select name="category_id" class="form-control" id="category_id" >
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" @if( old('category_id') == $category->id ) selected @endif >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="descricao">Descrição*</label>
                                        <textarea name="descricao" class='form-control' id="descricao" rows=10 required placeholder="Digite uma descrição para o produto">{{old('descricao')}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Preço (R$)*</label>
                                        <input type="text" id="produtoPreco_create" class='form-control' name="preco" maxlength="10" required placeholder="Digite o preço" value="{{old('preco')}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Desconto (%)</label>
                                        <input type="text" id='produtoDesconto_create' class='form-control' name="discount" maxlength="5" placeholder="Digite o desconto" value="{{old('discount')}}">
                                    </div>

                                    <div class="form-group">
                                        <label>Estoque*</label>
                                        <input type="text" class='form-control' id="EstoqueCreate" name="stock" maxlength="9" autofocus required placeholder="Digite a quantidade" value="{{old('stock')}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="home">Aparecer na Home?</label>
                                        <select name="home" class="form-control" id="home" >
                                            <option value="N" @if( old('home') == 'N') selected @endif >Não</option>
                                            <option value="S" @if( old('home') == 'S') selected @endif >Sim</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="imagem">Definir imagem</label>
                                        <input class="form-control" type="file" name="imagem" id="imagem" accept="image/png" onchange="preview_image(event)" >

                                        <figure class="rounded mx-auto d-block mt-4 img_extra_small_prod img_small_prod img_normal_prod img_grande_prod text-center">
                                            <img id="ExibirIMG_inputfile" class="form-control img_extra_small_prod img_small_prod img_normal_prod img_grande_prod" alt="Imagem do Produto" src=" @if( empty(old('imagem')) )  {{asset('admin_assets/images/produto_sem_imagem.jpg')}} @endif" >
                                            <figcaption>Imagem do produto</figcaption>
                                        </figure>
                                    </div>

                                    <button type="submit" class="btn btn-success mt-3">Criar</button>
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

        // Máscara dos valores
        $(document).ready(function($)
        {
        $('#produtoPreco_create').mask("#.##0,00", {reverse: true});
        $('#produtoDesconto_create').mask("#.##0,00", {reverse: true});
        $('#EstoqueCreate').mask("#.##0", {reverse: true});
        })

    </script>
@endsection
