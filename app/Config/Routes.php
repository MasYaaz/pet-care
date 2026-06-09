<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================================
// PUBLIC ROUTES (AKSES UMUM)
// ============================================================================
$routes->get('/', 'Home::index');

// Alur Sistem Autentikasi Kredensial Akses
$routes->get('login', 'Auth::login');
$routes->post('loginProcess', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('registerProcess', 'Auth::registerProcess');


// ============================================================================
// PROTECTED CORE ROUTES (WAJIB FILTER LOGIN 'AUTH')
// ============================================================================
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Beranda Dashboard Multi-Role Internal
    $routes->get('dashboard', 'Dashboard::index');

    // Fitur Tambahan: Manajemen Sunting Profil Mandiri Seluruh Personel Klinik
    $routes->get('profil/edit', 'Dashboard::editProfil');
    $routes->post('profil/update', 'Dashboard::updateProfil');
});


// ============================================================================
// 1. ROLE: PARAMEDIS / LOKET RESEPSIONIS (ROLE ID = 2)
// ============================================================================
$routes->group('paramedis', ['filter' => 'auth'], function ($routes) {

    // Front Office: Registrasi Berkas Pasien Walk-in
    $routes->get('pasien', 'Paramedis\Pasien::index');
    $routes->get('pasien/tambah', 'Paramedis\Pasien::tambah');
    $routes->post('pasien/simpan', 'Paramedis\Pasien::simpan');

    // Triage: Manajemen Antrean Kunjungan Kamar Periksa
    $routes->get('antrean', 'Paramedis\Antrean::index');
    $routes->get('antrean/tambah', 'Paramedis\Antrean::tambah');
    $routes->post('antrean/simpan', 'Paramedis\Antrean::simpan');
    $routes->get('antrean/status/(:num)', 'Paramedis\Antrean::updateStatus/$1');

    // Keuangan: Billing Faktur Nota & Kasir Utama Pembayaran
    $routes->get('kasir', 'Paramedis\Kasir::index');
    $routes->post('kasir/bayar/(:num)', 'Paramedis\Kasir::bayar/$1');

    // Logistik: Gudang Farmasi, Manajemen Stok Opname, Jenis & Satuan Obat
    $routes->get('obat', 'Paramedis\Obat::index');
    $routes->get('obat/tambah', 'Paramedis\Obat::tambah');
    $routes->post('obat/simpan', 'Paramedis\Obat::simpan');
    $routes->get('obat/edit/(:num)', 'Paramedis\Obat::edit/$1');
    $routes->post('obat/update/(:num)', 'Paramedis\Obat::update/$1');
    $routes->get('obat/hapus/(:num)', 'Paramedis\Obat::hapus/$1');
});


// ============================================================================
// 2. ROLE: SUPER ADMIN / DIREKSI MANAJEMEN (ROLE ID = 4)
// ============================================================================
$routes->group('admin', ['filter' => 'auth'], function ($routes) {

    // Kontrol Kredensial & Berkas Legal Tenaga Medis (Dokter)
    $routes->get('dokter', 'Admin\Dokter::index');
    $routes->get('dokter/tambah', 'Admin\Dokter::tambah');
    $routes->post('dokter/simpan', 'Admin\Dokter::simpan');
    $routes->get('dokter/edit/(:num)', 'Admin\Dokter::edit/$1');
    $routes->post('dokter/update/(:num)', 'Admin\Dokter::update/$1');
    $routes->get('dokter/hapus/(:num)', 'Admin\Dokter::hapus/$1');

    // Kontrol Kredensial & Divisi Tugas Personel Struktural Loket (Paramedis)
    $routes->get('paramedis', 'Admin\Paramedis::index');
    $routes->get('paramedis/tambah', 'Admin\Paramedis::tambah');
    $routes->post('paramedis/simpan', 'Admin\Paramedis::simpan');
    $routes->get('paramedis/edit/(:num)', 'Admin\Paramedis::edit/$1');
    $routes->post('paramedis/update/(:num)', 'Admin\Paramedis::update/$1');
    $routes->get('paramedis/hapus/(:num)', 'Admin\Paramedis::hapus/$1');

    // Pembersihan & Pengawasan Audit Berkas Klien Pasien (Tanpa Fitur Create/Tambah)
    $routes->get('pasien', 'Admin\Pasien::index');
    $routes->get('pasien/edit/(:num)', 'Admin\Pasien::edit/$1');
    $routes->post('pasien/update/(:num)', 'Admin\Pasien::update/$1');
    $routes->get('pasien/hapus/(:num)', 'Admin\Pasien::hapus/$1');

    $routes->get('laporan', 'Admin\Laporan::index');
    $routes->get('laporan/exportExcel', 'Admin\Laporan::exportExcel');
});


// ============================================================================
// 3. ROLE: CLIENT / PET OWNER / KLIEN PASIEN (ROLE ID = 3)
// ============================================================================
$routes->group('pasien', ['filter' => 'auth'], function ($routes) {

    // Manajemen Mandiri Profil Fisik Hewan Peliharaan (Anabul)
    $routes->get('anabul', 'Pasien\Pasien::anabul');
    $routes->get('anabul/tambah', 'Pasien\Pasien::tambahAnabul');
    $routes->post('anabul/simpan', 'Pasien\Pasien::simpanAnabul');
    $routes->get('anabul/edit/(:num)', 'Pasien\Pasien::editAnabul/$1');
    $routes->post('anabul/update/(:num)', 'Pasien\Pasien::updateAnabul/$1');
    $routes->get('anabul/hapus/(:num)', 'Pasien\Pasien::hapusAnabul/$1');

    // Pemesanan Slot Kunjungan Pemeriksaan dari Rumah (Booking Online)
    $routes->get('booking', 'Pasien\Pasien::booking');
    $routes->post('booking/simpan', 'Pasien\Pasien::simpanBooking');

    // Histori Transaksi Kasir & Lembar Salinan Riwayat Rekam Medis Klinis
    $routes->get('riwayat-medis', 'Pasien\Pasien::riwayatMedis');
    $routes->get('riwayat-pembayaran', 'Pasien\Pasien::riwayatPembayaran');
});


// ============================================================================
// 4. ROLE: DOKTER HEWAN / TENAGA MEDIS KLINIK (ROLE ID = 1)
// ============================================================================
$routes->group('dokter', ['filter' => 'auth'], function ($routes) {

    // Ruang Tunggu Meja Dokter (Daftar antrean pasien masuk ruang periksa)
    $routes->get('ruang-tunggu', 'Dokter\Dokter::ruangTunggu');

    // Lembar Kerja Hasil Diagnosa, Input Tindakan, Resep & Potong Stok Otomatis
    $routes->get('rekam-medis/periksa/(:num)', 'Dokter\Dokter::periksaPasien/$1');
    $routes->post('rekam-medis/simpan', 'Dokter\Dokter::simpanRekamMedis');
    $routes->get('riwayat-medis', 'Dokter\Dokter::riwayatMedis');
    $routes->get('rekam-medis/edit/(:num)', 'Dokter\Dokter::editRekamMedis/$1');
    $routes->post('rekam-medis/update/(:num)', 'Dokter\Dokter::updateRekamMedis/$1');

    // Pengaturan Mandiri Sesi Sifat Kunjungan & Jam Praktik Kerja
    $routes->get('jadwal', 'Dokter\Dokter::jadwal');
    $routes->get('jadwal/tambah', 'Dokter\Dokter::tambahJadwal');
    $routes->post('jadwal/simpan', 'Dokter\Dokter::simpanJadwal');
    $routes->get('jadwal/edit/(:num)', 'Dokter\Dokter::editJadwal/$1');
    $routes->post('jadwal/update/(:num)', 'Dokter\Dokter::updateJadwal/$1');
    $routes->get('jadwal/hapus/(:num)', 'Dokter\Dokter::hapusJadwal/$1');
});