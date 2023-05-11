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
                @if (Route::has('company.register'))
                    <a href="{{ route('company.register') }}" class="mt-3 mt-md-0 ms-0 ms-md-4 text-decoration-underline text-dark d-block d-md-inline-block text-center enlace-final" style="width: fit-content;">Registro Compañía</a>
                @endif
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>

    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">
            <div class="mb-1">
                {{ __('¿Olvidó su contraseña? No hay problema. Sólo indíquenos su dirección de correo electrónico y le enviaremos un enlace para restaurar su contraseña que le permitirá escoger una nueva.') }}
            </div>

            <div class="card-body">
                <!-- Session Status -->
                <x-auth-session-status class="mb-3" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                    <div class="mb-3">
                        <x-label for="email" :value="__('Correo')" />
                        <x-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                    </div>
                    @error('email')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror

                    <div class="d-flex justify-content-end align-items-baseline mt-4">
                        <x-button>
                            {{ __('Restaurar Contraseña') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
