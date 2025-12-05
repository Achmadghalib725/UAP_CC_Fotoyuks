<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('Selamat Datang') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">{{ __('Silakan masuk ke akun Anda') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" 
                          class="block mt-1 w-full focus:border-green-500 focus:ring-green-500" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required autofocus autocomplete="username" 
                          placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" 
                          class="block mt-1 w-full focus:border-green-500 focus:ring-green-500"
                          type="password"
                          name="password"
                          required autocomplete="current-password" 
                          placeholder="********" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" 
                       class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3 !bg-green-600 hover:!bg-green-700 focus:!ring-green-500 active:!bg-green-800">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            @if (Route::has('password.request'))
                <div class="mb-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" href="{{ route('password.request') }}">
                        {{ __('Lupa kata sandi Anda?') }}
                    </a>
                </div>
            @endif

            <div class="text-sm text-gray-600 border-t pt-4">
                {{ __('Belum punya akun?') }}
                <a class="font-bold text-green-600 hover:text-green-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 ms-1" href="{{ route('register') }}">
                    {{ __('Daftar Sekarang') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>