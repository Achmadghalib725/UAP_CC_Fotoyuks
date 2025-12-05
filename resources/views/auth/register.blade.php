<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('Buat Akun Baru') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">{{ __('Lengkapi data diri Anda untuk mendaftar') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" 
                          class="block mt-1 w-full focus:border-green-500 focus:ring-green-500" 
                          type="text" 
                          name="name" 
                          :value="old('name')" 
                          required autofocus autocomplete="name" 
                          placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" 
                          class="block mt-1 w-full focus:border-green-500 focus:ring-green-500" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required autocomplete="username" 
                          placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" 
                          class="block mt-1 w-full focus:border-green-500 focus:ring-green-500"
                          type="password"
                          name="password"
                          required autocomplete="new-password" 
                          placeholder="********" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

            <x-text-input id="password_confirmation" 
                          class="block mt-1 w-full focus:border-green-500 focus:ring-green-500"
                          type="password"
                          name="password_confirmation" 
                          required autocomplete="new-password" 
                          placeholder="********" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3 !bg-green-600 hover:!bg-green-700 focus:!ring-green-500 active:!bg-green-800">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>

        <div class="mt-4 text-center">
            <span class="text-sm text-gray-600">{{ __('Sudah punya akun?') }}</span>
            <a class="underline text-sm text-green-600 hover:text-green-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 ms-1" href="{{ route('login') }}">
                {{ __('Masuk disini') }}
            </a>
        </div>
    </form>
</x-guest-layout>