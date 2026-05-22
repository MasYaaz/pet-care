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

        $idPengguna = session()->get('id_pengguna');
        $idRole = session()->get('id_role');

        // 1. Data statistik standar dasar untuk dashboard
        $data = [
            'nama_user' => session()->get('nama_lengkap'),
            'role_user' => session()->get('nama_role'),
            'antrean_baru' => $reservasiModel->where('STATUS_RESERVASI', 'Menunggu')->countAllResults(),
            'total_pasien' => $pasienModel->countAllResults(),
            'obat_kritis' => $obatModel->where('STOK <=', 10)->countAllResults(),
            'list_booking' => [] // Default kosong untuk non-pasien
        ];

        // 2. KONDISIONAL REVISI: Jika yang login adalah PASIEN (Role ID = 3)
        if ($idRole == 3) {
            $data['list_booking'] = $reservasiModel->select('
                    RESERVASI.*, 
                    PASIEN.NAMA_HEWAN, PASIEN.JENIS_HEWAN, PASIEN.RAS, 
                    JADWAL_DOKTER.JAM_MULAI, JADWAL_DOKTER.JAM_SELESAI,
                    P_DOKTER.NAMA_LENGKAP AS NAMA_DOKTER
                ')
                ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
                ->join('JADWAL_DOKTER', 'JADWAL_DOKTER.ID_JADWAL = RESERVASI.ID_JADWAL')
                ->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER')
                ->join('PENGGUNA AS P_DOKTER', 'P_DOKTER.ID_PENGGUNA = DOKTER.ID_PENGGUNA')
                ->where('PASIEN.ID_PENGGUNA', $idPengguna)
                ->whereIn('RESERVASI.STATUS_RESERVASI', ['Menunggu', 'Diperiksa']) // Hanya yang aktif jalan
                ->orderBy('RESERVASI.TANGGAL_KUNJUNGAN', 'ASC')
                ->findAll();
        }

        // 3. Data antrean global untuk dashboard Admin/Staf/Dokter
        $data['list_antrean'] = $reservasiModel->select('RESERVASI.*, PASIEN.NAMA_HEWAN, PENGGUNA.NAMA_LENGKAP AS NAMA_PEMILIK')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PASIEN.ID_PENGGUNA')
            ->orderBy('RESERVASI.CREATED_AT', 'DESC')
            ->limit(5)
            ->find();

        return view('dashboard/index', $data);
    }
}