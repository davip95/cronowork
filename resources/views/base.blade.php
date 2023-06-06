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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/rr-1.3.3/datatables.min.css" rel="stylesheet"/>
        <style>
            .fichar:hover {
              color: var(--bs-gray-200) !important;
            }
            </style>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/rr-1.3.3/datatables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-light">
        {{-- SCROLL TOP BUTTON --}}
        <button
        type="button"
        class="btn btn-dark btn-sm"
        id="btn-back-to-top"
        >
        <i class="bi bi-arrow-up"></i>
        </button>
        <div class="d-flex" id="wrapper">
            {{-- SIDEBAR MENU --}}
            <div class="bg-light" id="sidebar-wrapper">
                <div class="sidebar-heading text-center py-4 fs-5 fw-bold text-uppercase border-bottom">
                    <x-application-icon /> <span>Cronowork</span> <i class="bi bi-layout-sidebar-inset-reverse fs-4" id="menu-toggle-sidebar"></i>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house-fill me-2"></i>Inicio</a>
                    @if(Auth::user()->tipo != 'usuario')
                    <a href="{{ route('empleado.misFichajes', [Auth::user()->empresas_id, Auth::user()->id]) }}" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold {{ request()->routeIs('empleado.misFichajes') ? 'active' : '' }}">
                        <i class="bi bi-ui-checks me-2"></i>Mis Fichajes</a>
                    @endif
                    @if(Auth::user()->tipo != 'usuario')
                    <a href="#" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold {{ request()->routeIs('empleado.ausencias') ? 'active' : '' }}">
                        <i class="bi bi-calendar2-x-fill me-2"></i></i>Mis Ausencias</a>
                    @endif
                    @if(Auth::user()->tipo != 'usuario')
                    <a href="{{ route('empleado.miHorario', [Auth::user()->empresas_id, Auth::user()->id]) }}" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold {{ request()->routeIs('empleado.miHorario') ? 'active' : '' }}">
                        <i class="bi bi-calendar-heart me-2"></i></i>Mi Horario</a>
                    @endif
                    <hr>
                    @if(Auth::user()->tipo == 'admin')
                    <a href="{{ route('admin.verEmpleados', Auth::user()->empresas_id) }}" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold {{ request()->routeIs('admin.verEmpleados') ? 'active' : '' }}">
                    <i class="bi bi-people-fill me-2"></i></i>Empleados</a>    
                    <a href="{{ route('admin.verFichajes', Auth::user()->empresas_id) }}" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold {{ request()->routeIs('admin.verFichajes') ? 'active' : '' }}">
                    <i class="bi bi-list-check me-2" style="-webkit-text-stroke: 1px;"></i></i>Fichajes Empresa</a>
                    <a href="#" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold {{ request()->routeIs('empresa.ausencias') ? 'active' : '' }}">
                    <i class="bi bi-building-fill-dash me-2"></i>Ausencias Empresa</a>
                    <a href="{{ route('admin.verHorarios', Auth::user()->empresas_id) }}" class="list-group-item list-group-item-action bg-transparent text-black-50 fw-bold {{ request()->routeIs('admin.verHorarios') ? 'active' : '' }}">
                    <i class="bi bi-calendar3 me-2" style="-webkit-text-stroke: 1px;"></i></i>Horarios Empresa</a>
                    <hr>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold salir">
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
                            $formatoFecha = '%A, %d de %B de %Y';
                            $fechaActual = iconv('ISO-8859-1', 'UTF-8', strftime($formatoFecha));
                            $fechaActual = ucfirst($fechaActual);
                        @endphp
                        <h2 class="fs-6 m-0 d-none d-lg-block me-4">{{ $fechaActual }}</h2>
                        {{-- AQUÍ LÓGICA PARA PONER EL FICHAJE DE ENTRADA O DE SALIDA --}}
                        @if(!is_null(auth()->user()->empresas_id))
                        <a role="button" href="#" class="btn btn-outline-success bg-dark btn-sm fichar">
                            <i class="bi bi-box-arrow-in-right me-2"></i><span class="fw-bold">Fichar Entrada</span>
                        </a>
                        @endif
                        {{-- AQUI EL ELSE DE LA LÓGICA (DESCOMENTAR BOTON DE ABAJO) --}}
                        {{-- <a role="button" href="#"  class="btn btn-outline-success bg-dark btn-sm fichar">
                            <i class="bi bi-box-arrow-left me-2"></i> <span class="fw-bold">Fichar Salida</span>
                        </a> --}}
                    </div>

                    <div class="btn-group ms-auto mb-0 mt-1">
                    <button type="button" class="btn btn-outline-dark btn-sm fw-bold dropdown-toggle mb-1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1" style="-webkit-text-stroke: 0.6px;"></i> <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end m-0">
                        <li><h6 class="dropdown-header text-center d-none d-md-block">{{ strtoupper(Auth::user()->tipo) }}</h6></li>
                        <li><h6 class="dropdown-header text-center d-md-none">{{ strtoupper(Auth::user()->name) }}</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        @if(Auth::user()->tipo != 'usuario')
                        <li><a href="{{ route('home') }}" class="dropdown-item fw-bold text-center">
                            <i class="bi bi-house-fill me-3"></i>Inicio</a></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item text-danger fw-bold text-center">
                                    <i class="bi bi-power me-3" style="-webkit-text-stroke: 1px;"></i>Salir
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
            // Toggle sidebar menu
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");
            var toggleButtonSidebar = document.getElementById("menu-toggle-sidebar");
    
            toggleButton.onclick = function () {
                el.classList.toggle("toggled");
            };
            toggleButtonSidebar.onclick = function () {
                el.classList.toggle("toggled");
            };

            // Scroll top button
            let mybutton = document.getElementById("btn-back-to-top");

            window.onscroll = function () {
            scrollFunction();
            };

            function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
            }

            mybutton.addEventListener("click", backToTop);

            function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
            }
        </script>
    </body>
</html>