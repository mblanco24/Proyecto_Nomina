<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
<div style="display: flex; justify-content: center; align-items: center; height: auto;">
  <img
    src="{{ asset('images/Logo-INHRR-01-vectorizado-1.png') }}"
    alt="Logo"
    style="width: 200px; height: auto; border: 0px solid #ccc;">
</div>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->


        <div class="flex items-center justify-end mt-4">


            <x-primary-button class="ms-3" id='btn_iniciar'>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
<script src="{{ asset('js/login.js') }}"></script>