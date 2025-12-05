<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Galeri Foto Saya') }}
            </h2>
            <a href="{{ route('photos.create') }}" class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-bold py-2 px-6 rounded-full shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Upload Foto Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- [MULAI] BAGIAN FILTER WARNA --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 p-6">
                <form method="GET" action="{{ route('photos.index') }}">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide">Filter Warna Dominan</h3>
                        
                        <div class="flex flex-wrap gap-3 items-center">
                            {{-- Helper function untuk class tombol warna --}}
                            @php
                                $colors = [
                                    '#FF0000' => 'bg-red-500',
                                    '#0000FF' => 'bg-blue-500',
                                    '#008000' => 'bg-green-500',
                                    '#FFFF00' => 'bg-yellow-400',
                                    '#000000' => 'bg-black',
                                    '#FFFFFF' => 'bg-white border border-gray-200'
                                ];
                            @endphp

                            @foreach($colors as $hex => $class)
                                <button type="submit" name="color" value="{{ $hex }}" 
                                    class="w-8 h-8 rounded-full {{ $class }} hover:scale-110 transition-transform duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm {{ request('color') == $hex ? 'ring-2 ring-offset-2 ring-green-500 scale-110' : '' }}"
                                    title="{{ $hex }}">
                                </button>
                            @endforeach

                            {{-- Tombol Reset --}}
                            @if(request('color'))
                                <a href="{{ route('photos.index') }}" 
                                   class="ml-2 px-4 py-1.5 bg-gray-100 text-gray-600 rounded-full hover:bg-gray-200 transition-colors text-xs font-bold uppercase tracking-wider">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            {{-- [SELESAI] BAGIAN FILTER WARNA --}}

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-green-50 border border-green-200 text-green-700 p-4 mb-6 rounded-xl shadow-sm flex justify-between items-center">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if($photos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($photos as $photo)
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                <a href="{{ route('photos.show', $photo) }}" class="block w-full h-full">
                                    <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->original_name }}"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </a>
                                
                                {{-- Overlay Actions --}}
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                                    <a href="{{ route('photos.show', $photo) }}" class="p-2 bg-white rounded-full text-gray-800 hover:text-green-600 transition-colors shadow-lg" title="Lihat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    
                                    <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-white rounded-full text-gray-800 hover:text-red-600 transition-colors shadow-lg" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 text-sm mb-1 truncate" title="{{ $photo->original_name }}">
                                    {{ $photo->original_name }}
                                </h3>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-xs font-medium px-2 py-1 bg-gray-100 text-gray-500 rounded-md">
                                        {{ $photo->size ? number_format($photo->size / 1024, 1) . ' KB' : 'N/A' }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $photo->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $photos->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
                    <div class="mb-6 inline-flex p-4 bg-green-50 rounded-full">
                        <svg class="w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada foto</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Galeri Anda masih kosong. Mulailah mengupload momen berharga Anda sekarang.</p>
                    <a href="{{ route('photos.create') }}"
                       class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-green-500/30 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Upload Foto Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>