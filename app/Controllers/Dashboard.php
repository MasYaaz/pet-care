<?php

namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\ReservasiModel;
use App\Models\ObatModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $reservasiModel = new ReservasiModel();
        $pasienModel = new PasienModel();
        $obatModel = new ObatModel();

        // Data statistik untuk dashboard staf
        $data = [
            'nama_user' => session()->get('nama_lengkap'),
            'role_user' => session()->get('nama_role'),
            'antrean_baru' => $reservasiModel->where('STATUS_RESERVASI', 'Menunggu')->countAllResults(),
            'total_pasien' => $pasienModel->countAllResults(), // Sekarang menghitung total anabul terdaftar
            'obat_kritis' => $obatModel->where('STOK <=', 10)->countAllResults(),

            // REVISI: Mengambil data antrean dengan double JOIN untuk mendapatkan nama pemilik asli dari PENGGUNA
            'list_antrean' => $reservasiModel->select('RESERVASI.*, PASIEN.NAMA_HEWAN, PENGGUNA.NAMA_LENGKAP AS NAMA_PEMILIK')
                ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
                ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PASIEN.ID_PENGGUNA') // Ambil data pemilik dari tabel induk
                ->orderBy('RESERVASI.CREATED_AT', 'DESC')
                ->limit(5)
                ->find()
        ];

        return view('dashboard/index', $data);
    }
}