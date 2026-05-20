<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasiModel extends Model
{
    protected $table = 'RESERVASI';
    protected $primaryKey = 'ID_RESERVASI';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    // REVISI: Menambahkan STATUS_RESERVASI ke dalam array allowedFields agar bisa di-insert/update
    protected $allowedFields = [
        'ID_RESERVASI',
        'ID_PARAMEDIS',
        'ID_PASIEN',
        'ID_JADWAL',
        'TANGGAL_KUNJUNGAN',
        'CREATED_AT',
        'KELUHAN',
        'STATUS_RESERVASI'
    ];

    // Join kompleks untuk detail antrean / agenda reservasi klinik yang diselaraskan
    public function getDetailReservasi($id = null)
    {
        $builder = $this->builder();

        // REVISI: Mengambil data nama lengkap dari table induk PENGGUNA masing-masing entitas
        $builder->select('
            RESERVASI.*, 
            PASIEN.NAMA_HEWAN, 
            P_PEMILIK.NAMA_LENGKAP AS NAMA_PEMILIK, 
            P_DOKTER.NAMA_LENGKAP AS NAMA_DOKTER, 
            JADWAL_DOKTER.HARI, 
            JADWAL_DOKTER.JAM_MULAI, 
            JADWAL_DOKTER.JAM_SELESAI,
            P_PARAMEDIS.NAMA_LENGKAP AS NAMA_PARAMEDIS
        ');

        // 1. Hubungkan ke data Pasien dan Ownernya
        $builder->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN');
        $builder->join('PENGGUNA AS P_PEMILIK', 'P_PEMILIK.ID_PENGGUNA = PASIEN.ID_PENGGUNA');

        // 2. Hubungkan ke data Jadwal dan Dokter yang bertugas
        $builder->join('JADWAL_DOKTER', 'JADWAL_DOKTER.ID_JADWAL = RESERVASI.ID_JADWAL');
        $builder->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER');
        $builder->join('PENGGUNA AS P_DOKTER', 'P_DOKTER.ID_PENGGUNA = DOKTER.ID_PENGGUNA');

        // 3. REVISI UTAMA: Menggunakan LEFT JOIN untuk Paramedis agar data antrean online 
        //    yang ID_PARAMEDIS-nya masih NULL tetap bisa lolos dan tampil di sistem!
        $builder->join('PARAMEDIS', 'PARAMEDIS.ID_PARAMEDIS = RESERVASI.ID_PARAMEDIS', 'left');
        $builder->join('PENGGUNA AS P_PARAMEDIS', 'P_PARAMEDIS.ID_PENGGUNA = PARAMEDIS.ID_PENGGUNA', 'left');

        if ($id !== null) {
            return $builder->where('RESERVASI.ID_RESERVASI', $id)->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }
}