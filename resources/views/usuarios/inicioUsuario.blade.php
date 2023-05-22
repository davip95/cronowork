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

          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="card user-card">
                <div class="card-header">Usuario</div>
                <div class="user-card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="5rem" height="5rem" fill="currentColor" class="bi bi-person-circle text-black-50" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                      </svg>
                    <div class="my-3">
                        <h4 class="mb-4">{{Auth::user()->name}}</h4>
                        <a role="button" href="#" class="btn btn-danger btn-sm">
                            <i class="bi bi-person-x-fill me-2"></i><span class="fw-bold">Borrar Cuenta</span>
                        </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card user-card mb-3">
                <div class="card-header">Datos Personales</div>
                <div class="user-card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Nombre</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{Auth::user()->name}} {{Auth::user()->apellidos}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Correo</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{Auth::user()->email}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Rol</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{Auth::user()->tipo}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Teléfono</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        @if(!empty(trim(Auth::user()->telefono)))
                        {{Auth::user()->telefono}}
                        @else
                        -
                        @endif
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Dirección</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        @if(!empty(trim(Auth::user()->direccion)))
                        {{Auth::user()->direccion}}
                        @else
                        -
                        @endif
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Código Postal</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        @if(!empty(trim(Auth::user()->codpostal)))
                        {{Auth::user()->codpostal}}
                        @else
                        -
                        @endif
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12 text-center">
                        <a role="button" href="#" class="btn btn-outline-dark bg-warning btn-sm">
                            <i class="bi bi-pencil-fill me-2"></i><span class="fw-bold">Editar Datos</span>
                        </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection