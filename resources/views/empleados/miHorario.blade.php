@extends('base')
@section('contenido')
<div class="container-fluid">
    <div class="main-body">
          <div id="app">
            <mi-horario :user="{{ Auth::user() }}"></mi-horario>
            <vue-progress-bar></vue-progress-bar>
          </div>
    </div>
</div>
@endsection