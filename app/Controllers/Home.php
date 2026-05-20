<?php

namespace App\Controllers;

use App\Models\TindakanModel;
use App\Models\JadwalDokterModel;

class Home extends BaseController
{
    public function index()
    {
        $tindakanModel = new TindakanModel();
        $jadwalModel = new JadwalDokterModel();

        // 1. Mengambil data seluruh layanan medis klinik (Tabel Master)
        $data['tindakan'] = $tindakanModel->findAll();

        // 2. REVISI: Mengambil data jadwal dengan double JOIN untuk mendapatkan NAMA_LENGKAP dari tabel PENGGUNA
        $data['jadwal_dokter'] = $jadwalModel->select('JADWAL_DOKTER.*, PENGGUNA.NAMA_LENGKAP AS NAMA_DOKTER, DOKTER.SPESIALISASI')
            ->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = DOKTER.ID_PENGGUNA') // Hubungkan ke tabel user induk
            ->findAll();

        // Render ke halaman home publik umum
        return view('home', $data);
    }
}