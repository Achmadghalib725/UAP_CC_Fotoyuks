<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('photos.index') }}"
               class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-green-600 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upload Foto Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Tambahkan Koleksi Baru</h3>
                        <p class="text-gray-500">Pilih foto berkualitas tinggi dari perangkat Anda.</p>
                    </div>

                    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div>
                            <div class="relative group">
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                       onchange="previewImage(event)" required>
                                
                                <div class="border-3 border-dashed border-gray-300 group-hover:border-green-400 group-hover:bg-green-50 rounded-2xl p-10 text-center transition-all duration-300 min-h-[300px] flex flex-col items-center justify-center">
                                    <div id="upload-placeholder" class="transition-all duration-300">
                                        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-700 mb-1">Klik atau seret foto ke sini</h4>
                                        <p class="text-sm text-gray-400">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                                    </div>

                                    <div id="file-preview" class="hidden w-full h-full">
                                        <img id="preview-img" class="max-h-[300px] mx-auto rounded-lg shadow-md object-contain">
                                        <p class="mt-4 text-sm text-green-600 font-medium bg-green-50 inline-block px-3 py-1 rounded-full">Foto berhasil dipilih!</p>
                                    </div>
                                </div>
                            </div>
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('photos.index') }}"
                               class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg hover:shadow-green-500/30 transform hover:scale-105 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Upload Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const placeholder = document.getElementById('upload-placeholder');
            const preview = document.getElementById('file-preview');
            const previewImg = document.getElementById('preview-img');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    placeholder.classList.add('hidden');
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                placeholder.classList.remove('hidden');
                preview.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>