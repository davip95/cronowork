<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <!-- Validation Errors -->
            {{-- <x-auth-validation-errors class="mb-3" :errors="$errors" /> --}}

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-1">
                    <x-label for="email" :value="__('Correo')" />
                    <x-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                </div>
                @error('email')
                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                @enderror

                <!-- Password -->
                <div class="mt-3 mb-1">
                    <x-label for="password" :value="__('Password')" />
                    <x-input id="password" type="password"
                             name="password"
                             required autocomplete="current-password" />
                </div>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <!-- Remember Me -->
                <div class="mb-3 mt-3">
                    <div class="form-check">
                        <x-checkbox id="remember_me" name="remember" />

                        <label class="form-check-label" for="remember_me">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        @if (Route::has('password.request'))
                            <a class="text-muted me-3" href="{{ route('password.request') }}">
                                {{ __('¿Olvidó su contraseña?') }}
                            </a>
                        @endif

                        <x-button>
                            {{ __('Entrar') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
