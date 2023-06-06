@extends('base')
@section('contenido')
<div class="container-fluid">
    <div class="main-body">
          <div id="app">
            <mis-fichajes :user="{{ Auth::user() }}"></mis-fichajes>
            <vue-progress-bar></vue-progress-bar>
          </div>
    </div>
</div>
@endsection