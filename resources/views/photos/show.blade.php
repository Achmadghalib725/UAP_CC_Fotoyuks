<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('photos.index') }}"
                   class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-green-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Detail Foto') }}
                </h2>
            </div>
            
            <div class="flex space-x-3">
                <button onclick="openRenameModal()"
                        class="bg-white border border-gray-200 text-gray-700 hover:border-green-500 hover:text-green-600 font-bold py-2 px-4 rounded-xl shadow-sm transform hover:scale-105 transition-all duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Ubah Nama
                </button>
                
                <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-50 hover:bg-red-100 text-red-600 border border-transparent hover:border-red-200 font-bold py-2 px-4 rounded-xl transform hover:scale-105 transition-all duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="md:flex h-full min-h-[500px]">
                    <div class="md:w-2/3 bg-gray-100 flex items-center justify-center p-8 relative">
                         <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#000_1px,transparent_1px)] [background-size:16px_16px]"></div>
                         
                        <img src="{{ route('photos.image', $photo) }}" alt="{{ $photo->original_name }}"
                             class="relative z-10 max-w-full max-h-[600px] rounded-lg shadow-2xl object-contain">
                    </div>

                    <div class="md:w-1/3 p-8 border-l border-gray-100 flex flex-col h-full">
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2 break-words">{{ $photo->original_name }}</h3>
                            <p class="text-sm text-gray-400 font-mono">{{ $photo->name }}</p>
                        </div>

                        <div class="flex-grow space-y-4">
                            <div class="flex items-center p-4 bg-green-50 rounded-xl border border-green-100">
                                <div class="p-2 bg-white rounded-full text-green-600 mr-4 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600 font-bold uppercase">Ukuran File</p>
                                    <p class="font-semibold text-gray-700">{{ number_format($photo->size / 1024, 2) }} KB</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <div class="p-2 bg-white rounded-full text-blue-600 mr-4 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600 font-bold uppercase">Tipe Format</p>
                                    <p class="font-semibold text-gray-700">{{ $photo->mime_type }}</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-purple-50 rounded-xl border border-purple-100">
                                <div class="p-2 bg-white rounded-full text-purple-600 mr-4 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11M9 11h6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-purple-600 font-bold uppercase">Tanggal Upload</p>
                                    <p class="font-semibold text-gray-700">{{ $photo->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 mt-auto">
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('photos.image', $photo) }}" target="_blank"
                                   class="flex items-center justify-center px-4 py-3 bg-gray-800 text-white rounded-xl hover:bg-gray-900 transition-colors shadow-lg shadow-gray-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Penuh
                                </a>
                                <a href="{{ route('photos.download', $photo) }}"
                                   class="flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors shadow-lg shadow-green-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download
                                </a>
                            </div>
                            <button onclick="navigator.share({title: '{{ $photo->original_name }}', url: '{{ Storage::url($photo->path) }}'})"
                                    class="w-full mt-3 flex items-center justify-center px-4 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                                Bagikan Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="renameModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-all duration-300">
        <div class="relative top-32 mx-auto p-8 border-0 w-full max-w-md shadow-2xl rounded-2xl bg-white">
            <div class="mt-2">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Ganti Nama Foto</h3>
                    <button onclick="closeRenameModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form action="{{ route('photos.rename', $photo) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-6">
                        <label for="original_name" class="block text-sm font-bold text-gray-700 mb-2">
                            Nama Baru
                        </label>
                        <input type="text" id="original_name" name="original_name"
                               value="{{ $photo->original_name }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow"
                               placeholder="Masukkan nama foto baru..."
                               required>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRenameModal()"
                                class="px-5 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 shadow-lg hover:shadow-green-500/30 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('renameModal');
        
        function openRenameModal() {
            modal.classList.remove('hidden');
            // Animasi masuk sederhana
            modal.querySelector('div').classList.add('scale-100', 'opacity-100');
            modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
        }

        function closeRenameModal() {
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRenameModal();
            }
        });
    </script>
</x-app-layout>