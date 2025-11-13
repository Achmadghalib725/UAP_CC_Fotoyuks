<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('photos.index') }}"
                   class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail Foto') }}
                </h2>
            </div>
            <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="inline"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Foto
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="md:flex">
                    <!-- Image Section -->
                    <div class="md:w-2/3 p-6">
                        <div class="relative">
                            <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->original_name }}"
                                 class="w-full rounded-lg shadow-lg object-contain max-h-96 md:max-h-[600px]">
                            <div class="absolute top-4 right-4">
                                <div class="bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm">
                                    {{ $photo->mime_type }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="md:w-1/3 p-6 bg-gray-50 dark:bg-gray-700">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $photo->original_name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $photo->name }}</p>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Ukuran File</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ number_format($photo->size / 1024, 2) }} KB
                                    </span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11M9 11h6"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tipe MIME</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $photo->mime_type }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Diunggah Pada</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $photo->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div class="flex space-x-3">
                                    <a href="{{ Storage::url($photo->path) }}" target="_blank"
                                       class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg shadow-md transform hover:scale-105 transition-all duration-200 text-center">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        Lihat Asli
                                    </a>
                                    <button onclick="navigator.share({title: '{{ $photo->original_name }}', url: '{{ Storage::url($photo->path) }}'})"
                                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg shadow-md transform hover:scale-105 transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
