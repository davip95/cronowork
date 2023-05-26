@extends('base')
@section('contenido')
<div class="container">
    <div class="main-body">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
              <li class="breadcrumb-item active" aria-current="page">Inicio Usuario</li>
            </ol>
          </nav>

          <div class="row">
            <div class="col-12 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                  </svg>
                  <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                    <div>
                        <strong>No está dado de alta en su empresa.</strong> Espere a recibir el alta para utilizar todas las funcionalidades del control de jornada.
                    </div>
                  </div>
            </div>
          </div>

          <div id="app">
            <edit-modal :user="{{ Auth::user() }}"></edit-modal>
          </div>

    </div>
</div>
{{-- <script src="{{ mix('js/app.js') }}" type="text/javascript"></script> --}}
@endsection