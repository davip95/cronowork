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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased bg-light">
        <div class="d-flex" id="wrapper">
            {{-- SIDEBAR MENU --}}
            <div class="bg-light" id="sidebar-wrapper">
                <div class="sidebar-heading text-center py-4 fs-5 fw-bold text-uppercase border-bottom">
                    <x-application-icon /> Cronowork
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
                    <div class="d-flex align-items-center">
                        <i class="bi bi-layout-sidebar-inset primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0">Panel</h2>
                    </div>

                    <div class="btn-group ms-auto mb-0">
                    <button type="button" class="btn btn-outline-dark dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2" style="-webkit-text-stroke: 0.6px;"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">{{ strtoupper(Auth::user()->tipo) }}</h6></li>
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
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
    
            toggleButton.onclick = function () {
                el.classList.toggle("toggled");
            };
        </script>
    </body>
</html>