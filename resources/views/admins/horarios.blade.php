@extends('base')
@section('contenido')
<div class="container-fluid">
    <div class="main-body">
          <div id="app">
            <horarios-empresa :user="{{ Auth::user() }}" :empresa="'{{ Auth::user()->empresas->nombre }}'"></horarios-empresa>
            <vue-progress-bar></vue-progress-bar>
          </div>
    </div>
</div>
@endsection