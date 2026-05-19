<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalDokterModel extends Model
{
    protected $table = 'JADWAL_DOKTER';
    protected $primaryKey = 'ID_JADWAL';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_JADWAL', 'ID_DOKTER', 'HARI', 'JAM_MULAI', 'JAM_SELESAI', 'KUOTA'];

    // Menampilkan jadwal kerja lengkap dengan nama dokternya
    public function getJadwalLengkap($id = null)
    {
        $builder = $this->builder();
        $builder->select('JADWAL_DOKTER.*, DOKTER.NAMA_DOKTER, DOKTER.SPESIALISASI');
        $builder->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER');

        if ($id !== null) {
            return $builder->where('JADWAL_DOKTER.ID_JADWAL', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}