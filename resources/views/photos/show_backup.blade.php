<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Foto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <a href="{{ route('photos.index') }}" class="text-blue-500 hover:text-blue-700">&larr; Kembali ke Galeri</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->original_name }}" class="w-full rounded-lg shadow-lg">
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4">{{ $photo->original_name }}</h3>
                            <div class="space-y-2 text-sm">
                                <p><strong>Nama File:</strong> {{ $photo->name }}</p>
                                <p><strong>Ukuran:</strong> {{ number_format($photo->size / 1024, 2) }} KB</p>
                                <p><strong>Tipe MIME:</strong> {{ $photo->mime_type }}</p>
                                <p><strong>Diunggah pada:</strong> {{ $photo->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="mt-6">
                                <form action="{{ route('photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Hapus Foto
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
