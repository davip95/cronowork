@extends('base')
@section('contenido')
<div class="container-fluid">
    <div class="main-body">
          <div id="app">
            <inicio-empleado :user="{{ Auth::user() }}"></inicio-empleado>
            <vue-progress-bar></vue-progress-bar>
          </div>
    </div>
</div>
@endsection