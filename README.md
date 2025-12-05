<p align="center">
  <a href="http://fotoyuks.test">
    <img src="public/images/logo fotoyuks.png" alt="Logo FotoYuks" width="200">
  </a>
</p>

<h1 align="center">FotoYuks</h1>

<p align="center">
  <strong>Abadikan dan bagikan momen terbaikmu dengan dunia.</strong>
</p>

<p align="center">
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=flat&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"></a>
  <a href="https://alpinejs.dev"><img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat&logo=alpine.js&logoColor=white" alt="Alpine.js"></a>
</p>

---

## 📸 Tentang Proyek

**FotoYuks** adalah aplikasi galeri foto modern yang dibangun menggunakan framework **Laravel**. Aplikasi ini dirancang untuk memudahkan pengguna dalam menyimpan, mengelola, dan membagikan koleksi foto mereka dengan antarmuka yang bersih, responsif, dan estetis.

Dengan nuansa **Green Nature Theme**, FotoYuks memberikan pengalaman pengguna yang segar dan menenangkan.

## ✨ Fitur Utama

* **🔐 Autentikasi Modern**: Halaman Login & Register dengan desain *Split Screen* yang elegan dan aman.
* **🖼️ Manajemen Galeri**: Tampilan grid foto yang responsif dengan efek hover yang interaktif.
* **📤 Upload Drag & Drop**: Kemudahan mengunggah foto dengan fitur seret-dan-lepas (drag-and-drop) yang intuitif.
* **🎨 Filter Warna Dominan**: Fitur unik untuk mencari/menyaring foto berdasarkan nuansa warna (Merah, Biru, Hijau, dll).
* **📱 Responsif Penuh**: Tampilan yang optimal di perangkat Desktop, Tablet, dan Mobile.
* **📊 Dashboard Informatif**: Ringkasan aktivitas dan akses cepat ke fitur-fitur penting.
* **⚙️ Manajemen Profil**: Pengguna dapat memperbarui informasi akun, mengganti password, dan mengelola privasi.
* **📂 Detail Metadata**: Melihat informasi rinci foto seperti ukuran file, tipe format, dan tanggal upload.

## 🛠️ Teknologi yang Digunakan

* **Backend**: Laravel (PHP Framework)
* **Frontend**: Blade Templates, Tailwind CSS
* **Interactivity**: Alpine.js
* **Database**: MySQL / MariaDB
* **Build Tool**: Vite

## 🚀 Instalasi & Menjalankan Proyek

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### Prasyarat
Pastikan Anda telah menginstal:
* PHP >= 8.2
* Composer
* Node.js & NPM

### Langkah-langkah

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/username/uap-cc-fotoyuks.git](https://github.com/username/uap-cc-fotoyuks.git)
    cd uap-cc-fotoyuks
    ```

2.  **Instal Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Instal Dependensi Frontend**
    ```bash
    npm install
    ```

4.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database**
    Jalankan migrasi untuk membuat tabel yang diperlukan:
    ```bash
    php artisan migrate
    ```

7.  **Link Storage**
    Penting! Jalankan perintah ini agar foto yang diupload bisa diakses publik:
    ```bash
    php artisan storage:link
    ```

8.  **Jalankan Proyek**
    Jalankan server pengembangan Laravel dan Vite (dalam 2 terminal terpisah):
    
    *Terminal 1:*
    ```bash
    php artisan serve
    ```
    
    *Terminal 2:*
    ```bash
    npm run dev
    ```

9.  **Selesai!**
    Buka browser dan akses: `http://localhost:8000`

## 📂 Struktur Folder Penting

* `app/Http/Controllers` - Logika backend (PhotoController, ProfileController).
* `resources/views` - Tampilan antarmuka (Blade templates).
    * `auth/` - Halaman Login, Register, dll.
    * `photos/` - Halaman galeri foto (Index, Create, Show).
    * `layouts/` - Layout utama (Navigation, Guest).
* `public/images` - Tempat penyimpanan aset statis seperti logo.
* `routes/web.php` - Definisi rute aplikasi.

## 📄 Lisensi

Proyek ini bersifat open-source dan dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">
  Dibuat dengan ❤️ untuk UAP Cloud Computing
</p>
