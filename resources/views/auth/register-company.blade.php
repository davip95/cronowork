<x-guest-layout>
    <style>
      @media (max-width: 768px) {
          .enlace-final{
              margin: 0 auto !important;
              margin-bottom: 1em !important;
          }
          .enlace-superior{
              margin-bottom: 1em;
          }
      }
    </style>
    <div class="container-fluid p-4 mb-0 pb-0">
        <div class="row align-items-center">
          <div class="col-md-6 d-flex flex-column justify-content-center flex-wrap justify-content-md-center">
            <div class="d-flex justify-content-center text-center">
              <h4>Cronowork</h4>
            </div>
          </div>
          <div class="col-md-6 d-flex flex-column justify-content-center flex-wrap justify-content-md-start">
            <div class="d-flex justify-content-center text-center flex-column flex-md-row">
              @if (Route::has('login'))
              <div class="mt-3 mt-md-0">
                <a href="{{ route('login') }}" class="text-decoration-underline text-dark d-block d-md-inline-block text-center mx-auto enlace-superior" style="width: fit-content">Entrar</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="mt-3 mt-md-0 ms-0 ms-md-4 text-decoration-underline text-dark d-block d-md-inline-block text-center enlace-final" style="width: fit-content;">Registro Empleado</a>
                @endif
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      
    <x-auth-card col_class="col-lg-10">
        
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <h3 class="card-title text-center mt-3">Registro Empresa</h3>

        <div class="card-body">
            <form method="POST" action="{{ route('company.register') }}">
                @csrf

                <div class="container">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-12">
                            <h5>Administrador</h5>
                            <hr>
                          </div>
                          <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <x-label for="name" :value="__('Name')" />
                                    <x-input id="name" type="text" name="name" :value="old('name')" required autofocus />
                                </div>
                                @error('name')
                                  <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                                <div class="col-6">
                                    <x-label for="apellidos" :value="__('Apellidos')" />
                                    <x-input id="apellidos" type="text" name="apellidos" :value="old('apellidos')" required autofocus />
                                </div>
                                @error('apellidos')
                                  <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                              </div>
                          </div>
                          <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <x-label for="email" :value="__('Email')" />
                                    <x-input id="email" type="email" name="email" :value="old('email')" required />
                                </div>
                                @error('email')
                                  <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                                <div class="col-6">
                                    <x-label for="telefono" :value="__('Teléfono')" />
                                    <x-input id="telefono" type="text" name="telefono" :value="old('telefono')" autofocus />
                                </div>
                                @error('telefono')
                                  <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                              </div>
                          </div>
                          <div class="col-12 mb-3">
                            <x-label for="password" :value="__('Password')" />
                            <x-input id="password" type="password"
                            name="password"
                            required autocomplete="new-password" />
                          </div>
                          @error('password')
                            <span class="text-danger"><strong>{{ $message }}</strong></span>
                          @enderror
                          <div class="col-12 mb-3">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-input id="password_confirmation" type="password"
                            name="password_confirmation" required />
                          </div>
                          @error('password_confirmation')
                            <span class="text-danger"><strong>{{ $message }}</strong></span>
                          @enderror
                          <div class="col-12 mb-3">
                            <x-label for="direccion" :value="__('Dirección')" />
                            <x-input id="direccion" type="text" name="direccion" :value="old('direccion')" autofocus />
                          </div>
                          @error('direccion')
                            <span class="text-danger"><strong>{{ $message }}</strong></span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="d-flex justify-content-end">Compañía</h5>
                                <hr>
                            </div>
                            <div class="col-12 mb-3">
                                <x-label for="nombre" :value="__('Nombre Empresa')" />
                                <x-input id="nombre" type="text" name="nombre" :value="old('nombre')" required autofocus />
                            </div>
                            @error('nombre')
                              <span class="text-danger"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div class="col-12 mb-3">
                                <x-label for="cif" :value="__('CIF')" />
                                <x-input id="cif" type="text" name="cif" :value="old('cif')" required autofocus />
                            </div>
                            @error('cif')
                              <span class="text-danger"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div class="col-12 mb-3">
                                <x-label for="correo" :value="__('Correo Empresa')" />
                                <x-input id="correo" type="email" name="correo" :value="old('correo')" required />
                            </div>
                            @error('correo')
                              <span class="text-danger"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div class="col-12 mb-3">
                                <x-label for="telefono_empresa" :value="__('Teléfono Empresa')" />
                                <x-input id="telefono_empresa" type="text" name="telefono_empresa" :value="old('telefono_empresa')" autofocus />
                              </div>
                              @error('telefono_empresa')
                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                              @enderror
                              <div class="col-12 mb-3">
                                <x-label for="direccion_empresa" :value="__('Dirección Empresa')" />
                                <x-input id="direccion_empresa" type="text" name="direccion_empresa" :value="old('direccion_empresa')" autofocus />
                              </div>
                              @error('direccion_empresa')
                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                              @enderror
                        </div>
                      </div>
                    </div>
                  </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        <a class="text-muted me-3 text-decoration-none" href="{{ route('login') }}">
                            {{ __('¿Ya registrada?') }}
                        </a>
                        <x-button>
                            {{ __('Registrar Compañía') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
