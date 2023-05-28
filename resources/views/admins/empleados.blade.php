@extends('base')
@section('contenido')
<div class="container-fluid">
    <div class="main-body">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
              <li class="breadcrumb-item active" aria-current="page">Empleados</li>
            </ol>
          </nav>

          <div id="app">
            <empleados-empresa :user="{{ Auth::user() }}" :empresa="'{{ Auth::user()->empresas->nombre }}'"></empleados-empresa>
            <vue-progress-bar></vue-progress-bar>
          </div>

    </div>
</div>
@endsection