<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admink - Admin</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/favicon/favicon-16x16.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('vendor/favicon/favicon-96x96.png')}}">

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Bootstrap Styles -->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Toastr Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" />

    <!-- Child pages styles -->
    @yield('styles')

</head>

<body id="page-top">

    <!-- Loader -->
    <div class="loader-wrapper">
        <div class="spinner-border text-light" role="status">
            <span class="sr-only">Carregando...</span>
        </div>
    </div>

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-pencil-square" aria-hidden="true"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admink</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Agendamentos -->
            <li class="nav-item @if (request()->is('admin/agendamentos*')) active @endif">
                <a class="nav-link" href="{{ route('admin.agendamentos.index') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Agendamentos</span>
                </a>
            </li>

            <!-- Nav Item - Orçamentos -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.orcamentos.index') }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Orçamentos</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block my-0">

            <!-- Nav Item - Artistas -->
            <li class="nav-item @if (request()->is('admin/artistas*')) active @endif">
                <a class="nav-link" href="{{ route('admin.artistas.index') }}">
                    <i class="fas fa-user-tie"></i>
                    <span>Artistas</span>
                </a>
            </li>

            <!-- Nav Item - Clientes -->
            <li class="nav-item @if (request()->is('admin/clientes*')) active @endif">
                <a class="nav-link active" href="{{ route('admin.clientes.index') }}">
                    <i class="fas fa-user-friends"></i>
                    <span>Clientes</span>
                </a>
            </li>

            <!-- Nav Item - Estúdio -->
            <li class="nav-item @if (request()->is('admin/estacoes*')) active @endif">
                <a class="nav-link" href="{{ route('admin.estacoes.index') }}">
                    <i class="fas fa-briefcase"></i>
                    <span>Estações</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block my-0">

            <!-- Nav Item - Relatórios -->
            <li class="nav-item @if (request()->is('admin/relatorios*')) active @endif">
                <a class="nav-link" href="{{ route('admin.home') }}"> 
                    <i class="fas fa-chart-line"></i>
                    <span>Relatórios</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block mb-4">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    @php
                    $e = $estudios->find(session()->get('estudio'));
                    @endphp

                    <!-- Label para exibir o nome do estúdio -->
                    <div class="nav-item">
                        <span class="mr-2 d-none d-flex justify-content-center text-gray-600 ">Estúdio:
                            {{ $e->nome }}</span>
                    </div>

                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="/vendor/icons/user.svg">
                            </a>

                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <div class="dropdown-divider"></div>

                                <!-- Lista de estúdios do usuário -->
                                @foreach ($estudios as $e)
                                <a class="dropdown-item"
                                    href="{{ route('admin.home.estudio', ['id_estudio' => $e->id_estudio])}}">
                                    <i class="fa fa-home fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>
                                    <span>{{ $e->id_estudio }} - {{ $e->nome }}</span>
                                </a>
                                @endforeach

                                <!-- Divider -->
                                <div class="dropdown-divider"></div>

                                <!-- Botão de Logout -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- Child pages content -->
                @yield('content')

            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Made with &hearts; by Thiago Teixeira & João Vitor | 2021</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pronto para sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Clique em "Logout" abaixo para se desconectar.</div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="#" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- SB Admin Scripts-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/0268508860.js" crossorigin="anonymous"></script>

    <!-- Toastr CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous">
    </script>

    <!-- Loader Script -->
    <script>
        $(window).on("load", function(){
            $(".loader-wrapper").fadeOut("slow");
        })
    </script>

    <!-- Toastr Success -->
    @if (Session::has('success_toastr'))
    <script>
        toastr.options.positionClass = 'toast-top-center';
        toastr.options.showMethod = 'slideDown';
        toastr.success("{!!Session::get('success_toastr')!!}");
    </script>
    @endif

    <!-- Toastr Warning -->
    @if (Session::has('warning_toastr'))
    <script>
        toastr.options.positionClass = 'toast-top-center';
        toastr.options.showMethod = 'slideDown';
        toastr.warning("{!!Session::get('warning_toastr')!!}");
    </script>
    @endif

    <!-- Child pages scripts -->
    @yield('scripts')

</body>

</html>