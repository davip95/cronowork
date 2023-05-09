<x-guest-layout>
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

                <!-- Validation Errors -->
                {{-- <x-auth-validation-errors class="mb-3" :errors="$errors" /> --}}

                <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                    <div class="mb-3">
                        <x-label for="email" :value="__('Correo')" />
                        <x-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                    </div>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="d-flex justify-content-end align-items-baseline mt-4">
                        <div class="mx-auto">
                            <a href="{{ route('login') }}" class="text-muted">Volver a Login</a>
                        </div>
                        <x-button>
                            {{ __('Restaurar Contraseña') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
