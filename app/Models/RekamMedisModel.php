<?php

namespace App\Models;

use CodeIgniter\Model;

class RekamMedisModel extends Model
{
    protected $table = 'REKAM_MEDIS';
    protected $primaryKey = 'ID_REKAM';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_REKAM', 'ID_RESERVASI', 'ID_DOKTER', 'TANGGAL_PERIKSA', 'ANAMNESIS', 'DIAGNOSIS', 'TERAPI', 'CATATAN'];

    // Mengambil data rekam medis lengkap dengan info hewan dan dokter pemeriksa
    public function getRiwayatLengkap($id = null)
    {
        $builder = $this->builder();
        $builder->select('REKAM_MEDIS.*, DOKTER.NAMA_DOKTER, PASIEN.NAMA_HEWAN, PASIEN.NAMA_PEMILIK, PASIEN.JENIS_HEWAN');
        $builder->join('DOKTER', 'DOKTER.ID_DOKTER = REKAM_MEDIS.ID_DOKTER');
        $builder->join('RESERVASI', 'RESERVASI.ID_RESERVASI = REKAM_MEDIS.ID_RESERVASI');
        $builder->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN');

        if ($id !== null) {
            return $builder->where('REKAM_MEDIS.ID_REKAM', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}