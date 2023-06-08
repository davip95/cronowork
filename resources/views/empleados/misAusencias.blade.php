@extends('base')
@section('contenido')
<div class="container-fluid">
    <div class="main-body">
          <div id="app">
            <mis-ausencias :user="{{ Auth::user() }}"></mis-ausencias>
            <vue-progress-bar></vue-progress-bar>
          </div>
    </div>
</div>
@endsection