<p align="center">
  <!-- [FOTO LOGO: Masukkan URL/path foto logo project Anda di sini. Ukuran disarankan: 200x200px] -->
  <img src="https://via.placeholder.com/200?text=Logo+NFC+Inventory" alt="Logo Project">
</p>

<h1 align="center">NFC Inventory Management System</h1>

<p align="center">
  Sistem Web Peminjaman dan Manajemen Inventaris Barang menggunakan teknologi <strong>NFC (Near Field Communication)</strong>. 
  Memudahkan proses peminjaman, pelacakan, dan pengelolaan barang secara cepat, akurat, dan modern.
</p>

## 🚀 Fitur Utama

- **Manajemen Barang (Admin):** Tambah, edit, hapus, dan kelola data inventaris barang lengkap dengan stok.
- **Peminjaman via NFC:** Proses peminjaman barang semudah melakukan *tapping* (tap) kartu atau tag NFC ke perangkat.
- **Riwayat & Pelacakan (History):** Melacak siapa yang meminjam barang, waktu peminjaman, dan status pengembalian.
- **Laporan (Report):** Sistem rekapitulasi dan laporan peminjaman barang.
- **Dashboard Interaktif:** Ringkasan statistik barang dan peminjaman secara *real-time*.
- **Role Management:** Sistem autentikasi dengan pemisahan hak akses (Admin dan User).

## 🛠️ Teknologi yang Digunakan

- **Backend:** [Laravel](https://laravel.com/) (PHP)
- **Frontend:** Laravel Blade, HTML, CSS, JavaScript (termasuk Web NFC API)
- **Database:** MySQL

## 📸 Screenshots (Tangkapan Layar)

<!-- [FOTO DASHBOARD ADMIN: Ganti atribut 'src' pada tag img di bawah dengan path gambar screenshot Dashboard Admin Anda] -->
### 1. Dashboard Admin
![Dashboard Admin](https://via.placeholder.com/800x400?text=Screenshot+Dashboard+Admin)

<!-- [FOTO HALAMAN SCAN NFC: Ganti atribut 'src' di bawah dengan gambar saat proses scan/tapping NFC berlangsung] -->
### 2. Halaman Tapping / Scan NFC
![Scan NFC](https://via.placeholder.com/800x400?text=Screenshot+Tapping+NFC)

<!-- [FOTO HALAMAN DAFTAR BARANG: Ganti atribut 'src' di bawah dengan gambar tabel daftar barang] -->
### 3. Daftar Inventaris Barang
![Daftar Barang](https://via.placeholder.com/800x400?text=Screenshot+Daftar+Barang)

## ⚙️ Cara Instalasi (Instalasi Lokal)

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal Anda:

1. **Clone Repository**
   ```bash
   git clone https://github.com/BaridNst/NFC_Invetory.git
   cd NFC_Invetory
   ```

2. **Install Dependensi Composer & NPM**
   ```bash
   composer install
   npm install
   ```

3. **Salin File Konfigurasi Environment**
   ```bash
   cp .env.example .env
   ```
   *Buka file `.env` dan atur koneksi database Anda (DB_DATABASE, DB_USERNAME, dll).*

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi Database dan Seeder**
   ```bash
   php artisan migrate --seed
   ```

6. **Kompilasi Asset Frontend**
   ```bash
   npm run build
   ```
   *(Atau gunakan `npm run dev` jika sedang dalam tahap pengembangan)*

7. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   *Buka `http://localhost:8000` di browser Anda.*

## 📱 Catatan Penggunaan Fitur NFC

Fitur *tapping* NFC membaca data menggunakan protokol **Web NFC API**. Agar fitur ini berjalan dengan baik:
- Pastikan aplikasi diakses menggunakan koneksi **HTTPS** atau melalui **localhost** (syarat wajib dari Web NFC API).
- Gunakan smartphone (misal: Android) yang dilengkapi sensor NFC yang aktif.
- Gunakan browser modern yang mendukung Web NFC (direkomendasikan **Google Chrome** veri terbaru).
