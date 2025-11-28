<footer class="bg-gray-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- About Section -->
            <div>
                <h3 class="text-lg font-semibold mb-4">FotoYuks</h3>
                <p class="text-gray-300 text-sm">
                    Platform untuk berbagi dan mengelola galeri foto pribadi Anda. Upload, bagikan, dan nikmati momen indah dalam hidup.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a></li>
                    <li><a href="{{ route('photos.index') }}" class="text-gray-300 hover:text-white transition-colors">Galeri Foto</a></li>
                    <li><a href="{{ route('photos.create') }}" class="text-gray-300 hover:text-white transition-colors">Upload Foto</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white transition-colors">Profil</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li>Email: support@fotoyuks.com</li>
                    <li>Telepon: +62 123 456 789</li>
                    <li>Alamat: Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-700 mt-8 pt-6 text-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} FotoYuks. All rights reserved. Dibuat dengan ❤️ menggunakan Laravel.
            </p>
        </div>
    </div>
</footer>
