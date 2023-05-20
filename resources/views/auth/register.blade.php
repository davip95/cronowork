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
                @if (Route::has('company.register'))
                    <a href="{{ route('company.register') }}" class="mt-3 mt-md-0 ms-0 ms-md-4 text-decoration-underline text-dark d-block d-md-inline-block text-center enlace-final" style="width: fit-content;">Registro Compañía</a>
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

        <h3 class="card-title text-center mt-3">Registro Empleado</h3>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="container">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-12 mb-3">
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" type="text" name="name" :value="old('name')" required autofocus />
                            @error('name')
                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                            @enderror
                          </div>
                          <div class="col-12 mb-3">
                            <x-label for="apellidos" :value="__('Apellidos')" />
                            <x-input id="apellidos" type="text" name="apellidos" :value="old('apellidos')" required autofocus />
                            @error('apellidos')
                              <span class="text-danger"><strong>{{ $message }}</strong></span>
                            @enderror
                          </div>
                          <div class="col-12 mb-3">
                            <x-label for="password" :value="__('Password')" />
                            <x-input id="password" type="password"
                            name="password"
                            required autocomplete="new-password" />
                            @error('password')
                              <span class="text-danger"><strong>{{ $message }}</strong></span>
                            @enderror
                          </div>
                          <div class="col-12 mb-3">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-input id="password_confirmation" type="password"
                            name="password_confirmation" required />
                            @error('password_confirmation')
                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" type="email" name="email" :value="old('email')" required />
                                @error('email')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>                            
                            <div class="col-12 mb-3">
                                <x-label for="direccion" :value="__('Dirección')" />
                                <x-input id="direccion" type="text" name="direccion" :value="old('direccion')" autofocus />
                                @error('direccion')
                                  <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                              <x-label for="codpostal" :value="__('Código Postal')" />
                              <x-input id="codpostal" type="text" name="codpostal" :value="old('codpostal')" autofocus />
                              @error('codpostal')
                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                              @enderror
                            </div>                         
                            <div class="col-12 mb-3">
                                <x-label for="telefono" :value="__('Teléfono')" />
                                <x-input id="telefono" type="text" name="telefono" :value="old('telefono')" autofocus />
                                @error('telefono')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>                            
                        </div>
                      </div>
                    </div>
                  </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        <a class="text-muted me-3 text-decoration-none" href="{{ route('login') }}">
                            {{ __('¿Ya registrado?') }}
                        </a>

                        <x-button>
                            {{ __('Registrarse') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
