<x-guest-layout>
    <div class="container-fluid p-4 mb-0 pb-0">
        <div class="row align-items-center">
          <div class="col-md-6 d-flex flex-column justify-content-center flex-wrap justify-content-md-center">
            <div class="d-flex justify-content-center text-center">
              <h4>Cronowork</h4>
            </div>
          </div>
          <div class="col-md-6 d-flex flex-column justify-content-center flex-wrap justify-content-md-start">
            <div class="d-flex justify-content-center text-center">
              @if (Route::has('login'))
              <div class="">
                <a href="{{ route('login') }}" class="text-decoration-underline text-dark">Entrar</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ms-4 text-decoration-underline text-dark">Registro Empleado</a>
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

        <h3 class="card-title text-center mt-3">Registro Empresa</h3>

        <div class="card-body">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('company.register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <x-label for="name" :value="__('Name')" />

                    <x-input id="name" type="text" name="name" :value="old('name')" required autofocus />
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <x-label for="email" :value="__('Email')" />

                    <x-input id="email" type="email" name="email" :value="old('email')" required />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-input id="password_confirmation" type="password"
                                    name="password_confirmation" required />
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
