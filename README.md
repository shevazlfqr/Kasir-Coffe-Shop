# Kasir Coffee

Aplikasi Kasir sederhana berbasis web untuk usaha kedai kopi. Aplikasi ini dibuat menggunakan PHP dan MySQL.

## Fitur
- Login/logout pengguna
- Manajemen produk
- Riwayat transaksi
- Laporan penjualan

## Struktur Folder
- `index.php` : Halaman utama/dashboard
- `produk.php` : Manajemen produk
- `riwayat.php` : Riwayat transaksi
- `laporan.php` : Laporan penjualan
- `login.php` : Halaman login
- `logout.php` : Logout
- `config/` : Konfigurasi database dan log
- `assets/` : Asset gambar dan CSS
- `db_kasir_coffee.sql` : File SQL untuk membuat database

## Cara Penggunaan

1. **Clone atau download repository ini ke folder server lokal Anda (misal: `htdocs` pada XAMPP).**

2. **Import database:**
   - Buka phpMyAdmin
   - Buat database baru, misal: `kasir_coffee`
   - Import file `db_kasir_coffee.sql` ke database tersebut

3. **Konfigurasi koneksi database:**
   - Buka file `config/db.php`
   - Sesuaikan konfigurasi database (host, user, password, nama database) sesuai dengan server Anda

4. **Jalankan aplikasi:**
   - Buka browser dan akses `http://localhost/kasir` (atau sesuai folder Anda)
   - Login menggunakan akun yang sudah ada di database

## Kebutuhan Sistem
- PHP 7.x atau lebih baru
- MySQL/MariaDB
- Web server (disarankan XAMPP/Laragon)

## Lisensi
Aplikasi ini bebas digunakan untuk keperluan belajar dan pengembangan.
