# Student Information Portal

Portal Informasi Mahasiswa adalah aplikasi berbasis web yang dibangun menggunakan PHP untuk mengelola informasi mahasiswa, program eksternal (seperti beasiswa), dokumen kemahasiswaan, dan menyediakan dashboard administratif yang responsif.

## Fitur Utama

- **Admin Dashboard**: Ringkasan dan statistik data kemahasiswaan.
- **Manajemen Dokumen**: Mengelola formulir dan dokumen kemahasiswaan.
- **Program Eksternal**: Informasi dan pengelolaan program beasiswa.
- **Desain Responsif**: Antarmuka yang ramah pengguna dan mendukung perangkat seluler maupun desktop.

## Teknologi yang Digunakan

- PHP
- HTML, CSS (Vanilla), JavaScript
- MySQL (Database)

## Prasyarat

Sebelum menjalankan proyek ini, pastikan Anda telah menginstal perangkat lunak berikut:
- Web Server lokal seperti **XAMPP**, **WAMP**, atau **MAMP**.
- PHP (disarankan versi 7.4 atau lebih baru).
- MySQL/MariaDB.

## Instalasi dan Penggunaan

1. **Clone Repositori**
   Clone repositori ini ke dalam direktori server lokal Anda (misalnya `htdocs` untuk XAMPP).
   ```bash
   git clone <url-repositori-anda>
   cd student_information_portal
   ```

2. **Konfigurasi Database**
   - Buat database baru di phpMyAdmin (misalnya: `db_student_portal`).
   - Import file `.sql` (jika tersedia di proyek) ke dalam database tersebut.
   - Buka file konfigurasi database di `config/koneksi.php` dan sesuaikan pengaturan koneksi:
     ```php
     // Contoh pengaturan di koneksi.php
     $host = "localhost";
     $user = "root";
     $password = "";
     $database = "nama_database_anda";
     ```

3. **Menjalankan Aplikasi**
   Anda bisa menjalankan aplikasi ini melalui web server XAMPP dengan mengakses URL:
   ```
   http://localhost/student_information_portal
   ```
   Atau, menggunakan built-in web server PHP dari terminal di dalam folder proyek:
   ```bash
   php -S 127.0.0.1:8000
   ```
   Lalu buka browser dan akses `http://127.0.0.1:8000`.

## Struktur Direktori

- `/admin` - Halaman dan modul khusus untuk level administrator.
- `/assets` - File statis seperti stylesheet CSS, file JavaScript, dan gambar.
- `/auth` - File untuk menangani proses otentikasi seperti login dan logout.
- `/config` - File konfigurasi aplikasi, termasuk koneksi database (`koneksi.php`).
- `/includes` - Komponen antarmuka yang digunakan berulang seperti header, sidebar, dan footer.
- `/pages` - Halaman-halaman fitur yang dapat diakses dari dashboard.

## Hak Cipta & Lisensi

Aplikasi Portal Informasi Mahasiswa.
