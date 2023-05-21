<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/base.css') }}">
        <link rel="stylesheet" href="{{ asset('css/scroll.css') }}">
        <link rel="stylesheet" href="{{ asset('css/usuarios/inicio.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased bg-light">
        <div class="d-flex" id="wrapper">
            {{-- SIDEBAR MENU --}}
            <div class="bg-light" id="sidebar-wrapper">
                <div class="sidebar-heading text-center py-4 fs-5 fw-bold text-uppercase border-bottom">
                    <x-application-icon /> <span>Cronowork</span> <i class="bi bi-layout-sidebar-inset-reverse fs-4" id="menu-toggle-sidebar"></i>
                </div>
                <div class="list-group list-group-flush my-3">
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house-fill me-2"></i>Inicio</a>
                    @if(Auth::user()->tipo != 'usuario')
                    <a href="#" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold">
                        <i class="bi bi-calendar3 me-2"></i>Fichajes</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">
                        <i class="bi bi-power me-2" style="-webkit-text-stroke: 1px;"></i>Salir</a>
                    </form>
                </div>
            </div>

            <div id="page-content-wrapper">
                {{-- CABECERA --}}
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-items-center mr-2">
                        <i class="bi bi-layout-sidebar-inset primary-text fs-4 me-2" id="menu-toggle"></i>
                        @if(Auth::user()->empresas_id)
                            <h2 class="fs-4 m-0 d-none d-lg-block me-4">{{Auth::user()->empresas->nombre}}</h2>
                        @endif
                    </div>

                    <div class="d-flex align-items-center mr-2 ms-auto">
                        @php
                            setlocale(LC_TIME, config('app.locale')); 
                        @endphp 
                        <h2 class="fs-6 m-0 d-none d-lg-block me-4">{{ now()->formatLocalized('%d de %B de %Y') }}</h2>
                        {{-- AQUÍ LÓGICA PARA PONER EL FICHAJE DE ENTRADA O DE SALIDA --}}
                        @if(!is_null(auth()->user()->empresas_id))
                        <a role="button" href="#" class="btn btn-outline-dark bg-success btn-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i><span class="fw-bold">Fichar Entrada</span>
                        </a>
                        @endif
                        {{-- AQUI EL ELSE DE LA LÓGICA (DESCOMENTAR BOTON DE ABAJO) --}}
                        {{-- <a role="button" href="#"  class="btn btn-outline-dark bg-danger btn-sm ml-2">
                            <i class="bi bi-box-arrow-left me-2"></i> <span class="fw-bold">Fichar Salida</span>
                        </a> --}}
                    </div>

                    <div class="btn-group ms-auto mb-0 mt-1">
                    <button type="button" class="btn btn-outline-dark btn-sm fw-bold dropdown-toggle mb-1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1" style="-webkit-text-stroke: 0.6px;"></i> <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end m-0">
                        <li><h6 class="dropdown-header">{{ strtoupper(Auth::user()->tipo) }}</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item text-danger fw-bold">
                                    <i class="bi bi-power me-2" style="-webkit-text-stroke: 1px;"></i>Salir
                                </a>
                            </form>
                        </li>
                    </ul>
                    </div>
                </nav>

                {{-- CONTENIDO --}}
                <div class="container-fluid px-4">
                    @yield('contenido')
                </div>
            </div>
        </div>

        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");
            var toggleButtonSidebar = document.getElementById("menu-toggle-sidebar");
    
            toggleButton.onclick = function () {
                el.classList.toggle("toggled");
            };
            toggleButtonSidebar.onclick = function () {
                el.classList.toggle("toggled");
            };
        </script>
    </body>
</html>