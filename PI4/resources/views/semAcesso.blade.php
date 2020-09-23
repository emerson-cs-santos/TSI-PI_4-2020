<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Admin - Gamer Shopping</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="{{ asset('admin_assets/images/admin.png') }}" type="image/x-icon" >

        <script src="https://kit.fontawesome.com/c0fc838bea.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        {{-- Referenciar javascript local --}}
        <script src="{{ asset('admin_assets/js/geral.js') }}"></script>
        {{-- <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script> --}}

        {{-- Referenciar javascript na Web --}}
        {{-- <script type="text/javascript" src="{{ URL::asset('js/custom.js') }}"></script> --}}

        <!-- Manual de uso referente aos alerts customizados "swal": https://sweetalert.js.org/guides/ -->
        <script src="{{ URL::asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js') }}" ></script>

        <!-- JQUERY -->
        <script src="{{ URL::asset('https://code.jquery.com/jquery-3.3.1.js') }}"></script>

        <!-- Utilizado para formatar valores decimais -->
        <script src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js') }}" ></script>

        {{-- Referenciar CSS local --}}
        <link href="{{ asset('admin_assets/css/admin.css') }}" rel="stylesheet" type="text/css" >

        {{-- Referenciar CSS na web --}}
        {{-- <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css" > --}}
    </head>

    <body>
        <header>
            <!---Nav bar-->
            <nav class="navbar navbar-expand-md navbar-light">
                <button class="navbar-toggler ml-auto mb-2 bg-light" type="button" data-toggle="collapse" data-target="#navbar"> <span class="navbar-toggler-icon"></span> </button>

                <div class="collapse navbar-collapse" id="navbar">
                    <div class="container-fluid">
                        <div class="row">
                            <!---Sidebar-->
                            <div class=" col-xl-2 col-lg-3 col-md-4 sidebar fixed-top">

                                <a href="/home" class="navbar-brand text-white d-block  mx-auto text-center py-3 mb-4"><i class="fas fa-gamepad text-light fa-3x"></i></a>
                            </div>
                            <!---end of side bar-->
                            <!---Top Nav-->

                            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto top-bar fixed-top py-2 top-nav">
                                <div class="row align-item-center">

                                    <div class="col-md-4">
                                        <h1 class="text-light text-uppercase mb-0 h4">Gamer Shopping</h1>
                                    </div>

                                    <div class="col-md-7">
                                        <form>
                                            <div class="input-group">
                                                {{-- <input type="search" class="form-control search-input" placeholder="Procurar no site">
                                                <button type="button" class="btn btn-white search-button">
                                                    <i class="fas fa-search text-dark"></i>
                                                </button> --}}
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-md-1">
                                        <ul class="navbar-nav">
                                            <li class="nav-item ml-md-auto" data-placement="top" data-toggle="tooltip" title="Sair"><a href="#" class="nav-link" data-toggle="modal" data-target="#sign-out"> <i class="fas fa-sign-out-alt text-danger fa-lg"></i></a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--End of Top Nav-->
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!--End of Navbar-->

      <main>
        <section>
            <header class="container-fluid">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto row pt-md-5 mt-2 text-dark">
                    <h2 class="">Acesso Negado!</h2>
                </div>
            </header>
        </section>
      </main>

      @yield('script')

        <!---Modal-->
        <div id="sign-out" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body text-center">
                        <span class="font-weight-bold">Encerrar sessão?</span>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <a href=" {{ route('logout') }} " onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class='btn btn-warning' data-dismiss="modal" data-placement="top" data-toggle="tooltip" title="Encerrar acesso">Sim</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                        <input type="button" value="Não" class="btn btn-primary" data-dismiss="modal" data-placement="top" data-toggle="tooltip" title="Voltar para o dashboard">
                    </div>
                </div>
            </div>
        </div>
        <!---End of Modal-->

        <footer class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto mt-3 bd-bottom">
                    <div class="row border-top pt-3">
                    </div>
                    <div class="col-12 text-center text-dark font-weight-bold">
                        <p>&copy; Copyright. Senac 2020 - Sistemas para Internet - Projeto integrador 4</p>
                    </div>
                </div>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
