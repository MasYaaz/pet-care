<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rute Autentikasi
$routes->get('login', 'Auth::login');
$routes->post('loginProcess', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('registerProcess', 'Auth::registerProcess');

// Rute Internal Klinik (Hanya bisa diakses jika lolos Filter Auth)
$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index'); // Halaman beranda internal admin/staf
});

// ============================================================================
// 1. GRUP NAVIGASI OPERASIONAL: KHUSUS PARAMEDIS / STAF LOKET (ROLE ID = 2)
// ============================================================================
$routes->group('paramedis', ['filter' => 'auth'], function ($routes) {
    // Kelola Pasien (Hewan & Pemilik)
    $routes->get('pasien', 'Paramedis\Pasien::index');
    $routes->get('pasien/tambah', 'Paramedis\Pasien::tambah');
    $routes->post('pasien/simpan', 'Paramedis\Pasien::simpan');

    // Kelola Antrean / Kunjungan Loket
    $routes->get('antrean', 'Paramedis\Antrean::index');
    $routes->get('antrean/tambah', 'Paramedis\Antrean::tambah');
    $routes->post('antrean/simpan', 'Paramedis\Antrean::simpan');

    $routes->get('antrean/status/(:num)', 'Paramedis\Antrean::updateStatus/$1');
    // Kasir & Billing Pembayaran
    $routes->get('kasir', 'Paramedis\Kasir::index');
    $routes->post('kasir/bayar/(:num)', 'Paramedis\Kasir::bayar/$1');
});

// ============================================================================
// 2. GRUP NAVIGASI MANAJEMEN UTAMA: KHUSUS SUPER ADMIN (ROLE ID = 4)
// ============================================================================
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // REVISI: Manajemen Akun Dokter dipindahkan penuh ke kendali folder Admin
    $routes->get('dokter', 'Admin\Dokter::index');
    $routes->get('dokter/tambah', 'Admin\Dokter::tambah');
    $routes->post('dokter/simpan', 'Admin\Dokter::simpan'); // Diperbaiki: Tanpa prefix "admin/" lagi di dalam grup

    // Tempat manajemen paramedis oleh admin di masa depan
    $routes->get('paramedis', 'Admin\Paramedis::index');
    $routes->get('paramedis/tambah', 'Admin\Paramedis::tambah');
    $routes->post('paramedis/simpan', 'Admin\Paramedis::simpan');
});

// --- Grup Navigasi Khusus Klien / Pemilik Hewan (Role ID = 3) ---
$routes->group('pasien', ['filter' => 'auth'], function ($routes) {
    // Manajemen Profil Anabul (Pasien)
    $routes->get('anabul', 'Pasien\Pasien::anabul');
    $routes->get('anabul/tambah', 'Pasien\Pasien::tambahAnabul');
    $routes->post('anabul/simpan', 'Pasien\Pasien::simpanAnabul');
    $routes->get('anabul/edit/(:num)', 'Pasien\Pasien::editAnabul/$1');
    $routes->post('anabul/update/(:num)', 'Pasien\Pasien::updateAnabul/$1');
    $routes->get('anabul/hapus/(:num)', 'Pasien\Pasien::hapusAnabul/$1');

    // Alur Booking Sistem Online
    $routes->get('booking', 'Pasien\Pasien::booking');
    $routes->post('booking/simpan', 'Pasien\Pasien::simpanBooking');

    // Menu Baru Rekam Medis & Invoice Kasir
    $routes->get('riwayat-medis', 'Pasien\Pasien::riwayatMedis');
    $routes->get('riwayat-pembayaran', 'Pasien\Pasien::riwayatPembayaran');
});

// --- Grup Navigasi Khusus Dokter Hewan (Role ID = 1) ---
$routes->group('dokter', ['filter' => 'auth'], function ($routes) {
    // Menu 1: Ruang Tunggu Medis (Daftar antrean pasien masuk)
    $routes->get('ruang-tunggu', 'Dokter\Dokter::ruangTunggu');

    // Menu 2: Input Rekam Medis & Tindakan
    $routes->get('rekam-medis/periksa/(:num)', 'Dokter\Dokter::periksaPasien/$1');
    $routes->post('rekam-medis/simpan', 'Dokter\Dokter::simpanRekamMedis');

    // Menu 3: Manajemen Jadwal Praktik Mandiri (Tambahan Baru)
    $routes->get('jadwal', 'Dokter\Dokter::jadwal');
    $routes->get('jadwal/tambah', 'Dokter\Dokter::tambahJadwal');
    $routes->post('jadwal/simpan', 'Dokter\Dokter::simpanJadwal');
    $routes->get('jadwal/edit/(:num)', 'Dokter\Dokter::editJadwal/$1');
    $routes->post('jadwal/update/(:num)', 'Dokter\Dokter::updateJadwal/$1');
    $routes->get('jadwal/hapus/(:num)', 'Dokter\Dokter::hapusJadwal/$1');
});