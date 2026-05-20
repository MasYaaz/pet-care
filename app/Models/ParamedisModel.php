<?php

namespace App\Models;

use CodeIgniter\Model;

class ParamedisModel extends Model
{
    protected $table = 'PARAMEDIS';
    protected $primaryKey = 'ID_PARAMEDIS';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    // REVISI: NAMA_PARAMEDIS dihapus dari allowedFields
    protected $allowedFields = ['ID_PARAMEDIS', 'ID_PENGGUNA', 'JABATAN'];

    public function getParamedisWithAkun($id = null)
    {
        $builder = $this->builder();
        // REVISI: Mengambil NAMA_LENGKAP dari PENGGUNA alias sebagai NAMA_PARAMEDIS
        $builder->select('PARAMEDIS.*, PENGGUNA.NAMA_LENGKAP AS NAMA_PARAMEDIS, PENGGUNA.USERNAME, PENGGUNA.EMAIL');
        $builder->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PARAMEDIS.ID_PENGGUNA');

        if ($id !== null) {
            return $builder->where('PARAMEDIS.ID_PARAMEDIS', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}