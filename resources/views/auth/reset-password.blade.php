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

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-3">
                    <x-label for="email" :value="__('Email')" />
                    <x-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                    @error('email')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-label for="password" :value="__('Password')" />
                    <x-input id="password" type="password" name="password" required />
                    @error('password')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-input id="password_confirmation" type="password"
                            name="password_confirmation" required />
                    @error('password_confirmation')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end">
                        <x-button>
                            {{ __('Cambiar Contraseña') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
