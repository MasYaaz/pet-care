<?php

namespace App\Models;

use CodeIgniter\Model;

class RekamMedisModel extends Model
{
    protected $table = 'REKAM_MEDIS';
    protected $primaryKey = 'ID_REKAM';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'ID_REKAM',
        'ID_RESERVASI',
        'ID_DOKTER',
        'TANGGAL_PERIKSA',
        'ANAMNESIS',
        'DIAGNOSIS',
        'TERAPI',
        'CATATAN'
    ];

    // REVISI: Mengambil data rekam medis lengkap disesuaikan dengan struktur relasi PENGGUNA
    public function getRiwayatLengkap($id = null)
    {
        $builder = $this->builder();
        $builder->select('
            REKAM_MEDIS.*, 
            PASIEN.NAMA_HEWAN, PASIEN.JENIS_HEWAN, PASIEN.RAS,
            P_PEMILIK.NAMA_LENGKAP AS NAMA_PEMILIK,
            P_DOKTER.NAMA_LENGKAP AS NAMA_DOKTER
        ');
        $builder->join('RESERVASI', 'RESERVASI.ID_RESERVASI = REKAM_MEDIS.ID_RESERVASI');
        $builder->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN');
        $builder->join('PENGGUNA AS P_PEMILIK', 'P_PEMILIK.ID_PENGGUNA = PASIEN.ID_PENGGUNA');
        $builder->join('DOKTER', 'DOKTER.ID_DOKTER = REKAM_MEDIS.ID_DOKTER');
        $builder->join('PENGGUNA AS P_DOKTER', 'P_DOKTER.ID_PENGGUNA = DOKTER.ID_PENGGUNA');

        if ($id !== null) {
            return $builder->where('REKAM_MEDIS.ID_REKAM', $id)->get()->getRowArray();
        }

        $builder->orderBy('REKAM_MEDIS.TANGGAL_PERIKSA', 'DESC');
        return $builder->get()->getResultArray();
    }
}