<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Galeri Foto Saya') }}
            </h2>
            <a href="{{ route('photos.create') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Upload Foto Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- [MULAI] BAGIAN FILTER WARNA --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form method="GET" action="{{ route('photos.index') }}">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Cari Berdasarkan Warna Dominan</h3>
                    <div class="flex flex-wrap gap-4 items-center">
                        {{-- Merah --}}
                        <button type="submit" name="color" value="#FF0000" title="Merah" 
                            class="w-10 h-10 rounded-full bg-red-500 border-2 border-transparent hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-transform transform hover:scale-110 {{ request('color') == '#FF0000' ? 'ring-2 ring-offset-2 ring-gray-500 scale-110' : '' }}">
                        </button>
                        
                        {{-- Biru --}}
                        <button type="submit" name="color" value="#0000FF" title="Biru"
                            class="w-10 h-10 rounded-full bg-blue-500 border-2 border-transparent hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform transform hover:scale-110 {{ request('color') == '#0000FF' ? 'ring-2 ring-offset-2 ring-gray-500 scale-110' : '' }}">
                        </button>
                        
                        {{-- Hijau --}}
                        <button type="submit" name="color" value="#008000" title="Hijau"
                            class="w-10 h-10 rounded-full bg-green-500 border-2 border-transparent hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-transform transform hover:scale-110 {{ request('color') == '#008000' ? 'ring-2 ring-offset-2 ring-gray-500 scale-110' : '' }}">
                        </button>
                        
                        {{-- Kuning --}}
                        <button type="submit" name="color" value="#FFFF00" title="Kuning"
                            class="w-10 h-10 rounded-full bg-yellow-400 border-2 border-transparent hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition-transform transform hover:scale-110 {{ request('color') == '#FFFF00' ? 'ring-2 ring-offset-2 ring-gray-500 scale-110' : '' }}">
                        </button>

                        {{-- Hitam --}}
                        <button type="submit" name="color" value="#000000" title="Hitam"
                            class="w-10 h-10 rounded-full bg-black border-2 border-gray-600 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-transform transform hover:scale-110 {{ request('color') == '#000000' ? 'ring-2 ring-offset-2 ring-gray-500 scale-110' : '' }}">
                        </button>

                        {{-- Putih --}}
                        <button type="submit" name="color" value="#FFFFFF" title="Putih"
                            class="w-10 h-10 rounded-full bg-white border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-transform transform hover:scale-110 {{ request('color') == '#FFFFFF' ? 'ring-2 ring-offset-2 ring-gray-500 scale-110' : '' }}">
                        </button>

                        {{-- Tombol Reset (Hanya muncul jika sedang memfilter) --}}
                        @if(request('color'))
                            <a href="{{ route('photos.index') }}" 
                               class="ml-4 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            {{-- [SELESAI] BAGIAN FILTER WARNA --}}

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($photos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach($photos as $photo)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative group">
                                <a href="{{ route('photos.show', $photo) }}" class="block">
                                    <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->original_name }}"
                                         class="w-full h-48 object-cover">
                                </a>
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg transform hover:scale-110 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-1 truncate" title="{{ $photo->original_name }}">
                                    {{ $photo->original_name }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    @if($photo->size)
                                        {{ number_format($photo->size / 1024, 1) }} KB
                                    @else
                                        N/A
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    {{ $photo->created_at->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $photos->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-12 text-center">
                    <div class="mb-6">
                        <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Belum ada foto</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Mulai membangun galeri foto Anda dengan mengupload foto pertama</p>
                    <a href="{{ route('photos.create') }}"
                       class="inline-flex items-center bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Upload Foto Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>