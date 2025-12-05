<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="relative bg-gradient-to-r from-green-600 to-green-500 rounded-2xl shadow-xl overflow-hidden mb-10 mx-4 sm:mx-0">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                
                <div class="relative z-10 p-8 md:p-12 text-white flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-6 md:mb-0 text-center md:text-left">
                        <h1 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">
                            Halo, {{ Auth::user()->name }}! 
                        </h1>
                        <p class="text-green-100 text-lg opacity-90 max-w-xl">
                            Selamat datang kembali di <span class="font-bold text-white">FotoYuks</span>. Kelola dan bagikan momen terbaikmu sekarang.
                        </p>
                    </div>
                    
                    <div>
                        <a href="{{ route('photos.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-green-700 font-bold rounded-full shadow-lg hover:bg-green-50 hover:scale-105 transition transform duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Upload Foto Baru
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 sm:px-0 mb-10">
                
                <a href="{{ route('photos.index') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded-full">
                            Galeri
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Kelola Foto</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Lihat seluruh koleksi foto Anda, edit detail, atau hapus yang sudah tidak diperlukan.</p>
                </a>

                <a href="{{ route('photos.create') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded-full">
                            Aksi
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">Upload Cepat</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Tambahkan foto baru ke dalam album Anda dengan mudah dan cepat.</p>
                </a>

                <a href="{{ route('profile.edit') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="bg-purple-100 text-purple-800 text-xs font-bold px-2.5 py-1 rounded-full">
                            Akun
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors">Pengaturan Profil</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Update informasi akun, email, dan ganti password Anda di sini.</p>
                </a>

            </div>

            <div class="text-center text-gray-400 text-sm mt-8 border-t border-gray-200 pt-6">
                &copy; {{ date('Y') }} FotoYuks. All rights reserved.
            </div>
            
        </div>
    </div>
</x-app-layout>