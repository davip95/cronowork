@extends('base')
@section('contenido')
<div class="container-fluid">
    <div class="main-body">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
              <li class="breadcrumb-item active" aria-current="page">Inicio Admin</li>
            </ol>
          </nav>

          <div id="app">
            <inicio-admin :user="{{ Auth::user() }}" :empresa="{{ Auth::user()->empresas }}"></inicio-admin>
            <vue-progress-bar></vue-progress-bar>
          </div>

    </div>
</div>
@endsection