<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <div class="hidden lg:flex w-1/2 bg-green-800 justify-center items-center relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1505330622279-bf7d7fc918f4?q=80&w=1920&auto=format&fit=crop" 
                     alt="Background" 
                     class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-multiply">
                
                <div class="relative z-10 text-white text-center px-12">
                    <h1 class="text-5xl font-extrabold mb-4 tracking-tight">FotoYuks</h1>
                    <p class="text-xl font-light text-green-100">Abadikan dan bagikan momen terbaikmu dengan dunia.</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white px-8 py-12">
                
                <div class="w-full sm:max-w-md">
                    <div class="flex justify-center mb-8 lg:hidden">
                        <a href="/">
                            <x-application-logo class="w-20 h-20 fill-current text-green-600" />
                        </a>
                    </div>

                    {{ $slot }}
                </div>
                
                <div class="mt-10 text-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} FotoYuks. All rights reserved.
                </div>
            </div>
        </div>
    </body>
</html>