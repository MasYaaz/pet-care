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
$routes->group('paramedis', function ($routes) {
    // Kelola Pasien (Hewan & Pemilik)
    $routes->get('pasien', 'Paramedis\Pasien::index');
    $routes->get('pasien/tambah', 'Paramedis\Pasien::tambah');
    $routes->post('pasien/simpan', 'Paramedis\Pasien::simpan');

    // Kelola Antrean / Kunjungan Loket
    $routes->get('antrean', 'Paramedis\Antrean::index');
    $routes->get('antrean/tambah', 'Paramedis\Antrean::tambah');
    $routes->post('antrean/simpan', 'Paramedis\Antrean::simpan');

    // Kasir & Billing Pembayaran
    $routes->get('kasir', 'Paramedis\Kasir::index');
});

// ============================================================================
// 2. GRUP NAVIGASI MANAJEMEN UTAMA: KHUSUS SUPER ADMIN (ROLE ID = 4)
// ============================================================================
$routes->group('admin', function ($routes) {
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
$routes->group('pasien', function ($routes) {
    // Menu 1: Profil Anabulku
    $routes->get('anabul', 'Pasien\Pasien::anabul');

    // REVISI: Tambahan rute mandiri untuk tambah hewan baru
    $routes->get('anabul/tambah', 'Pasien\Pasien::tambahAnabul');
    $routes->post('anabul/simpan', 'Pasien\Pasien::simpanAnabul');

    // REVISI: Tambahan rute untuk fitur edit anabul
    $routes->get('anabul/edit/(:num)', 'Pasien\Pasien::editAnabul/$1');
    $routes->post('anabul/update/(:num)', 'Pasien\Pasien::updateAnabul/$1');

    $routes->get('anabul/hapus/(:num)', 'Pasien\Pasien::hapusAnabul/$1');

    // Menu 2: Booking Jadwal Mandiri
    $routes->get('booking', 'Pasien\Pasien::booking');
    $routes->post('booking/simpan', 'Pasien\Pasien::simpanBooking');
});