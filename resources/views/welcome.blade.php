<x-guest-layout>

<style>
    body {
        background: linear-gradient(135deg, #EDEAFF, #E4EEFF);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    .auth-card {
        width: 480px;
        background: #FFFFFF;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0px 8px 25px rgba(0,0,0,0.08);
    }

    input {
        border-radius: 10px;
        border: 2px solid #D3D0FF;
    }

    input:focus {
        border-color: #7C3AED !important;
        box-shadow: 0 0 0 3px rgba(124,58,237,0.25);
    }

    .btn-primary {
        background: linear-gradient(to right, #8B5CF6, #3B82F6);
        color: #fff;
        padding: 12px;
        width: 100%;
        font-weight: bold;
        border-radius: 10px;
        transition: 0.25s;
    }

    .btn-primary:hover {
        opacity: .85;
    }

    .title {
        font-size: 32px;
        font-weight: 700;
        color: #2D2D2D;
    }

    .subtitle {
        margin-top: -8px;
        margin-bottom: 25px;
        color: #6A6A6A;
    }
</style>

<div class="text-center mb-6">
    <div class="bg-white shadow-md p-4 rounded-full mx-auto" style="width: 75px; height: 75px;">
        <x-application-logo class="w-10 h-10 mx-auto text-purple-600" />
    </div>

    <h1 class="title mt-4">Selamat Datang</h1>
    <p class="subtitle">Masuk ke akun <strong>FotoYuks Cloud</strong> Anda</p>
</div>

<div class="auth-card">
    <!-- Email -->
    <div class="mb-4">
        <label class="font-semibold">Alamat Email</label>
        <input id="email" type="email" name="email" class="w-full p-3 mt-1" required />
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label class="font-semibold">Kata Sandi</label>
        <input id="password" type="password" name="password" class="w-full p-3 mt-1" required />
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between mt-2 mb-4 text-sm">
        <label class="flex items-center gap-1">
            <input type="checkbox" class="rounded"> Ingat saya
        </label>
        <a href="#" class="underline text-purple-600 hover:text-purple-800">Lupa kata sandi?</a>
    </div>

    <button class="btn-primary mb-4">Masuk</button>

    <div class="text-center text-sm text-gray-600 mt-3">
        Belum punya akun? <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:underline">Daftar di sini</a>
    </div>
</div>

<p class="text-center text-xs mt-6 text-gray-700">
   © 2025 FotoYuks Cloud. Semua hak dilindungi.
</p>

</x-guest-layout>
