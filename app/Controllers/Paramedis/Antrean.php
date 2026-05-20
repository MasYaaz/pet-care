<?php

namespace App\Controllers\Paramedis;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\ReservasiModel;
use App\Models\JadwalDokterModel;

class Antrean extends BaseController
{
    protected $reservasiModel;
    protected $pasienModel;

    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel();
        $this->pasienModel = new PasienModel();
    }

    // Menampilkan list antrean hari ini di meja resepsionis
    public function index()
    {
        // Mengambil antrean hari ini menggunakan schema JOIN milik ReservasiModel
        // Kita sesuaikan alias PENGGUNA untuk menarik nama dokter dari relasi baru
        $data['list_antrean'] = $this->reservasiModel->select('
                RESERVASI.*, 
                PASIEN.NAMA_HEWAN, 
                P_PEMILIK.NAMA_LENGKAP AS NAMA_PEMILIK, 
                P_DOKTER.NAMA_LENGKAP AS NAMA_DOKTER
            ')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
            ->join('PENGGUNA AS P_PEMILIK', 'P_PEMILIK.ID_PENGGUNA = PASIEN.ID_PENGGUNA') // Pemilik anabul
            ->join('JADWAL_DOKTER', 'JADWAL_DOKTER.ID_JADWAL = RESERVASI.ID_JADWAL')
            ->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER')
            ->join('PENGGUNA AS P_DOKTER', 'P_DOKTER.ID_PENGGUNA = DOKTER.ID_PENGGUNA') // Dokter bertugas
            ->where('RESERVASI.TANGGAL_KUNJUNGAN', date('Y-m-d'))
            ->orderBy('RESERVASI.ID_RESERVASI', 'ASC') // Diurutkan berdasarkan record pendaftaran
            ->findAll();

        return view('paramedis/antrean/index', $data);
    }

    // Membuka form registrasi antrean baru
    public function tambah()
    {
        // 1. Ambil data pasien (Anabul) beserta nama pemilik aslinya dari tabel pengguna
        $data['pasien'] = $this->pasienModel->select('PASIEN.ID_PASIEN, PASIEN.NAMA_HEWAN, PENGGUNA.NAMA_LENGKAP AS NAMA_PEMILIK')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PASIEN.ID_PENGGUNA')
            ->findAll();

        // 2. Ambil data Jadwal Dokter yang aktif untuk dipilih di komponen <select> view
        //    (Pastikan kamu sudah memiliki JadwalDokterModel)
        $jadwalModel = new JadwalDokterModel();
        $data['jadwal_dokter'] = $jadwalModel->select('JADWAL_DOKTER.ID_JADWAL, JADWAL_DOKTER.HARI, JADWAL_DOKTER.JAM_MULAI, JADWAL_DOKTER.JAM_SELESAI, PENGGUNA.NAMA_LENGKAP AS NAMA_DOKTER')
            ->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = DOKTER.ID_PENGGUNA')
            ->findAll();

        return view('paramedis/antrean/tambah', $data);
    }

    // ==========================================
    // TAMBAHAN: Mengubah Status Reservasi / Antrean Pasien
    // ==========================================
    public function updateStatus($idReservasi)
    {
        $statusBaru = $this->request->getGet('status');

        $statusValid = ['Menunggu', 'Diperiksa', 'Selesai', 'Batal'];
        if (!in_array($statusBaru, $statusValid)) {
            session()->setFlashdata('error', 'Status reservasi tidak valid!');
            return redirect()->to(base_url('paramedis/antrean'));
        }

        // --- PANDUAN REVISI: Langsung tembak ambil nilainya dalam 1 baris ---
        $idParamedis = (new \App\Models\ParamedisModel())->where('ID_PENGGUNA', session()->get('id_pengguna'))->first()['ID_PARAMEDIS'] ?? null;
        if (!$idParamedis) {
            session()->setFlashdata('error', 'Akun Anda tidak terdaftar sebagai Paramedis!');
            return redirect()->to(base_url('paramedis/antrean'));
        }

        // Update data ke database
        $this->reservasiModel->update($idReservasi, [
            'ID_PARAMEDIS' => $idParamedis,
            'STATUS_RESERVASI' => $statusBaru
        ]);

        session()->setFlashdata('success', 'Status reservasi berhasil diperbarui menjadi "' . $statusBaru . '".');
        return redirect()->to(base_url('paramedis/antrean'));
    }

    // Menyimpan pendaftaran antrean ke tabel RESERVASI
    public function simpan()
    {
        $idPasien = $this->request->getPost('id_pasien');
        $idJadwal = $this->request->getPost('id_jadwal');
        $keluhan = $this->request->getPost('keluhan');

        $idParamedis = session()->get('id_paramedis');

        // Langsung insert tanpa perlu menghitung nomor antrean
        $this->reservasiModel->insert([
            'ID_PARAMEDIS' => $idParamedis,
            'ID_PASIEN' => $idPasien,
            'ID_JADWAL' => $idJadwal,
            'TANGGAL_KUNJUNGAN' => date('Y-m-d'),
            'KELUHAN' => $keluhan,
            'CREATED_AT' => date('Y-m-d H:i:s'),
            'STATUS_RESERVASI' => 'Menunggu'
        ]);

        session()->setFlashdata('success', 'Pasien berhasil didaftarkan ke dalam antrean medis.');
        return redirect()->to(base_url('paramedis/antrean'));
    }
}