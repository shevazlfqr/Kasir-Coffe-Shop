# Kasir Coffee

<img width="428" height="428" alt="Logo" src="https://github.com/user-attachments/assets/f10871fe-da9e-49d3-a634-8f182f68d8b1" />

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

# Lampiran
<img width="1919" height="910" alt="Screenshot 2025-07-22 092518" src="https://github.com/user-attachments/assets/6e1a168d-f1e4-47ae-9f6c-d2bbdcee8949" />
<img width="1919" height="910" alt="Screenshot 2025-07-22 092547" src="https://github.com/user-attachments/assets/6d3cdcc6-9d61-4093-a22e-62537533303b" />
<img width="1919" height="907" alt="Screenshot 2025-07-22 092559" src="https://github.com/user-attachments/assets/8532a7b7-4b7d-4de8-946a-bcc0cacab583" />
<img width="1919" height="909" alt="Screenshot 2025-07-22 092611" src="https://github.com/user-attachments/assets/42d8f7c6-66ff-47e6-8b4c-57c5f3f1c285" />
<img width="1919" height="908" alt="Screenshot 2025-07-22 092636" src="https://github.com/user-attachments/assets/0c4f19d0-8e71-4edb-8b4d-4ae9242881ba" />


