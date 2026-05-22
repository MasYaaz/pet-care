# PetCare - Sistem Klinik Hewan Berbasis Website

## Dokumentasi Teknis & Panduan Implementasi

---

## 📋 Daftar Isi

1. [Tentang Proyek](#tentang-proyek)
2. [Fitur Utama](#fitur-utama)
3. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
4. [Struktur Proyek](#struktur-proyek)
5. [Persyaratan Sistem](#persyaratan-sistem)
6. [Cara Instalasi](#cara-instalasi)
7. [Konfigurasi](#konfigurasi)
8. [Panduan Penggunaan](#panduan-penggunaan)
9. [Modul & Fitur Detail](#modul--fitur-detail)
10. [Troubleshooting](#troubleshooting)

---

## 🎯 Tentang Proyek

**PetCare** adalah sistem manajemen klinik hewan terpadu yang dirancang untuk memudahkan pengelolaan data pasien (hewan), jadwal dokter, resep obat, dan sistem pembayaran. Aplikasi ini dibangun dengan framework **CodeIgniter 4** untuk memberikan performa optimal dan keamanan tingkat enterprise.

### Tujuan Sistem

- Mengelola data pasien hewan peliharaan secara terpusat
- Mengorganisir jadwal dokter dan paramedis
- Mencatat rekam medis dan tindakan medis
- Mengelola inventori obat dan resep
- Mempermudah proses pembayaran dan tagihan
- Meningkatkan efisiensi operasional klinik

---

## ✨ Fitur Utama

### 1. **Manajemen Pasien (Hewan)**

- Registrasi pasien baru dengan data lengkap
- Riwayat medis per pasien
- Tracking kesehatan hewan peliharaan
- Profil pemilik/penjaga hewan

### 2. **Manajemen Dokter & Paramedis**

- Database dokter dengan spesialisasi
- Jadwal kerja dokter
- Profil paramedis
- Sistem antrean pasien

### 3. **Rekam Medis Digital**

- Catatan lengkap per kunjungan
- Diagnosa dan prognosa
- Riwayat tindakan medis
- Dokumentasi pemeriksaan fisik

### 4. **Manajemen Obat & Resep**

- Database lengkap inventori obat
- Resep obat per pasien
- Detail resep terperinci
- Tracking penggunaan obat

### 5. **Sistem Pembayaran & Billing**

- Kalkulasi tagihan otomatis
- Metode pembayaran fleksibel
- Riwayat pembayaran pasien
- Laporan finansial

### 6. **Sistem Booking/Reservasi**

- Reservasi konsultasi online
- Manajemen slot jadwal
- Konfirmasi otomatis

### 7. **Sistem Manajemen Peran (Role & Permission)**

- Admin: Akses penuh sistem
- Dokter: Manajemen pasien & rekam medis
- Paramedis: Manajemen antrean & kasir
- Pasien: Portal self-service

---

## 🛠️ Teknologi yang Digunakan

| Komponen               | Teknologi               |
| ---------------------- | ----------------------- |
| **Framework Backend**  | CodeIgniter 4           |
| **Bahasa Pemrograman** | PHP 7.4+                |
| **Database**           | MySQL/MariaDB           |
| **Web Server**         | Apache (XAMPP)          |
| **Frontend**           | HTML5, CSS3, JavaScript |
| **Testing**            | PHPUnit                 |
| **Package Manager**    | Composer                |

### Versi Minimum

- PHP: 7.4
- MySQL: 5.7+
- Apache: 2.4+

---

## 📁 Struktur Proyek

```
klinik-hewan/
├── app/                          # Inti aplikasi CodeIgniter
│   ├── Config/                   # Konfigurasi sistem
│   ├── Controllers/              # Controller aplikasi
│   │   ├── Auth.php
│   │   ├── Dashboard.php
│   │   ├── Admin/                # Module admin
│   │   ├── Dokter/               # Module dokter
│   │   ├── Paramedis/            # Module paramedis
│   │   └── Pasien/               # Module pasien
│   ├── Models/                   # Model database
│   │   ├── PasienModel.php
│   │   ├── DokterModel.php
│   │   ├── RekamMedisModel.php
│   │   ├── ResepObatModel.php
│   │   ├── PembayaranModel.php
│   │   └── ...
│   ├── Views/                    # Template view
│   │   ├── layouts/              # Layout template
│   │   ├── admin/                # View admin
│   │   ├── dokter/               # View dokter
│   │   ├── paramedis/            # View paramedis
│   │   └── pasien/               # View pasien
│   ├── Database/
│   │   ├── Migrations/           # Database migration
│   │   └── Seeds/                # Database seeder
│   ├── Filters/                  # Filter & middleware
│   ├── Helpers/                  # Helper functions
│   └── Libraries/                # Custom libraries
│
├── public/                        # Web root (entry point)
│   ├── index.php                 # Front controller
│   └── assets/                   # CSS, JS, images
│
├── vendor/                        # Composer dependencies
├── writable/                      # Folder yang dapat ditulis
│   ├── cache/
│   ├── logs/
│   ├── session/
│   └── uploads/
│
├── tests/                         # Unit testing
├── composer.json                 # Dependency configuration
├── phpunit.xml.dist              # Testing configuration
├── spark                         # CLI tool
└── .env                          # Environment variables
```

---

## 💻 Persyaratan Sistem

### Hardware

- **RAM Minimum**: 2 GB
- **Disk Space**: 500 MB+ (untuk instalasi dan data)
- **Processor**: Intel i3/AMD equivalent atau lebih baik

### Software

- **OS**: Windows 7+, macOS, atau Linux
- **XAMPP**: 7.4+ (atau server lokal equivalent)
- **Browser**: Chrome, Firefox, Safari, Edge (versi terbaru)
- **Text Editor**: VS Code, Sublime, PHPStorm (optional)

---

## 🚀 Cara Instalasi

### Metode 1: Instalasi Virtual Hosts (Recommended)

Metode ini mengarahkan _Document Root_ server langsung ke folder `public/` milik CodeIgniter 4 demi alasan keamanan, sehingga berkas inti framework tidak terekspos ke publik.

#### Langkah 1: Konfigurasi Windows Hosts File

1. Buka aplikasi **Notepad** dengan opsi **Run as Administrator**
2. Buka file konfigurasi jaringan Windows:
   ```
   C:\Windows\System32\drivers\etc\hosts
   ```
3. Tambahkan baris berikut di akhir file:
   ```
   127.0.0.1   pet-care.test
   ```
4. Simpan file (Ctrl+S)

#### Langkah 2: Konfigurasi Virtual Hosts XAMPP

1. Buka file Apache Virtual Hosts:

   ```
   C:\xampp\apache\conf\extra\httpd-vhosts.conf
   ```

2. Tambahkan konfigurasi berikut di akhir file:

   ```apache
   <VirtualHost *:80>
       DocumentRoot "C:/xampp/htdocs/klinik-hewan/public"
       ServerName pet-care.test
       ServerAlias www.pet-care.test

       <Directory "C:/xampp/htdocs/klinik-hewan/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

3. Simpan file

#### Langkah 3: Restart Apache

1. Buka XAMPP Control Panel
2. Klik tombol **Stop** pada Apache (jika sedang berjalan)
3. Tunggu beberapa detik, lalu klik **Start**
4. Status Apache seharusnya menunjukkan "Running"

#### Langkah 4: Clone/Download Proyek

```bash
# Navigasi ke folder htdocs
cd C:\xampp\htdocs

# Clone repository (jika menggunakan Git)
git clone <repository-url> klinik-hewan

# Atau ekstrak file zip
# Pastikan folder bernama "klinik-hewan"
```

#### Langkah 5: Install Dependencies

```bash
# Navigasi ke folder proyek
cd C:\xampp\htdocs\klinik-hewan

# Install composer dependencies
composer install
```

---

## ⚙️ Konfigurasi

### 1. Konfigurasi Environment (.env)

Buat file `.env` di root folder proyek (atau copy dari `.env.example`):

```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------
CI_ENVIRONMENT = development

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------
app.baseURL = 'http://pet-care.test/'

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = pet_care
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

#--------------------------------------------------------------------
# SESSION
#--------------------------------------------------------------------
# session.driver = 'CodeIgniter\Session\Handlers\FileHandler'
# session.savePath = null
```

### 2. Buat Database MySQL

```sql
-- Buka phpMyAdmin (http://localhost/phpmyadmin)
-- Atau gunakan command line MySQL:

CREATE DATABASE pet_care;
USE pet_care;
```

### 3. Jalankan Migrasi Database

```bash
# Navigasi ke folder proyek
cd C:\xampp\htdocs\klinik-hewan

# Jalankan migrasi
php spark migrate

# (Optional) Jalankan seeder untuk data dummy
php spark db:seed ClinicSeeder
php spark db:seed UserSeeder
```

### 4. Konfigurasi Timezone (Optional)

Edit file `app/Config/App.php`:

```php
public $appTimezone = 'Asia/Jakarta';
```

---

## 📚 Panduan Penggunaan

### Akses Aplikasi

1. Buka browser (Chrome, Firefox, etc.)
2. Ketik URL: `http://pet-care.test`
3. Halaman login akan muncul

### Login Credentials (Default - Setelah Seeding)

| Role      | Username              | Password | Fungsi                                 |
| --------- | --------------------- | -------- | -------------------------------------- |
| Admin     | admin@petcare.com     | password | Kelola sistem, user, dokter, paramedis |
| Dokter    | dokter@petcare.com    | password | Manajemen pasien, rekam medis, resep   |
| Paramedis | paramedis@petcare.com | password | Manajemen antrean, kasir               |
| Pasien    | pasien@petcare.com    | password | Booking, riwayat medis, pembayaran     |

**⚠️ PENTING**: Ubah password setelah login pertama untuk keamanan!

### Fitur Utama Per Role

#### Admin Dashboard

- Statistik sistem
- Manajemen user & role
- Manajemen dokter & paramedis
- Laporan & analitik
- Konfigurasi sistem

#### Dokter

- Dashboard jadwal
- Ruang tunggu/antrean
- Input rekam medis
- Buat resep obat
- Riwayat pasien

#### Paramedis

- Manajemen antrean pasien
- Kasir/pembayaran
- Input data pasien baru
- Manajemen inventori dasar

#### Pasien

- Booking konsultasi
- Lihat riwayat medis
- Tracking pembayaran
- Update profil hewan

---

## 🔧 Modul & Fitur Detail

### Module: Authentication (Autentikasi)

**File**: `app/Controllers/Auth.php`

- Login dengan email & password
- Registrasi pasien baru
- Session management
- Password reset

### Module: Admin

**File**: `app/Controllers/Admin/`

- Dashboard overview
- Manajemen dokter
- Manajemen paramedis
- System settings

### Module: Dokter

**File**: `app/Controllers/Dokter/`

- Jadwal kerja
- Ruang tunggu
- Rekam medis digital
- Resep obat

### Module: Paramedis

**File**: `app/Controllers/Paramedis/`

- Antrean pasien
- Kasir/pembayaran
- Manajemen pasien
- Laporan harian

### Module: Pasien

**File**: `app/Controllers/Pasien/`

- Booking konsultasi
- Riwayat medis
- Pembayaran
- Profil hewan

---

## 🗄️ Database Schema Summary

| Tabel            | Fungsi                                       |
| ---------------- | -------------------------------------------- |
| `users`          | Data user (admin, dokter, paramedis, pasien) |
| `pasien`         | Data hewan peliharaan                        |
| `dokter`         | Data dokter                                  |
| `paramedis`      | Data paramedis                               |
| `jadwal_dokter`  | Jadwal praktek dokter                        |
| `rekam_medis`    | Catatan medis per kunjungan                  |
| `rekam_tindakan` | Tindakan medis yang dilakukan                |
| `obat`           | Database inventori obat                      |
| `resep_obat`     | Resep obat per pasien                        |
| `detail_resep`   | Detail item dalam resep                      |
| `jenis_item`     | Kategori item (lab, farmasi, dll)            |
| `pembayaran`     | Riwayat pembayaran                           |
| `item_tagihan`   | Detail item dalam tagihan                    |
| `metode_bayar`   | Metode pembayaran yang tersedia              |
| `role`           | Role/peran user                              |
| `reservasi`      | Booking konsultasi                           |

---

## 🐛 Troubleshooting

### Error: "Database connection failed"

**Solusi:**

1. Pastikan MySQL sudah running di XAMPP
2. Check konfigurasi `.env` - hostname, username, password
3. Pastikan database `pet_care` sudah dibuat
4. Cek credentials MySQL di phpMyAdmin

### Error: "View not found"

**Solusi:**

1. Pastikan struktur folder Views sesuai dengan controller route
2. Check nama file (case-sensitive pada Linux/Mac)
3. Jalankan `php spark cache:clear`

### Error: "404 Not Found"

**Solusi:**

1. Pastikan Virtual Host sudah dikonfigurasi dengan benar
2. Restart Apache service
3. Clear browser cache (Ctrl+Shift+Delete)
4. Check file `app/Config/Routes.php`

### Apache tidak mau di-restart

**Solusi:**

1. Check apakah port 80 sedang digunakan aplikasi lain
2. Buka Command Prompt sebagai Administrator
3. Jalankan: `netstat -ano | findstr :80`
4. Kill process yang menggunakan port 80

### File upload tidak berfungsi

**Solusi:**

1. Pastikan folder `writable/uploads/` ada permission write
2. Check konfigurasi upload di `app/Config/Uploads.php`
3. Increase `upload_max_filesize` di `php.ini`

---

## 📖 Dokumentasi Tambahan

- **CodeIgniter 4 Docs**: https://codeigniter.com/user_guide/
- **PHP Docs**: https://www.php.net/docs.php
- **MySQL Docs**: https://dev.mysql.com/doc/

---

## 👥 Tim Pengembang

- **Lead Developer**: [Nama]
- **UI/UX Designer**: [Nama]
- **Database Admin**: [Nama]

---

## 📝 Lisensi

Proyek ini dilindungi oleh lisensi yang sesuai. Lihat file `LICENSE` untuk detail.

---

**Terakhir diperbarui**: May 22, 2026
