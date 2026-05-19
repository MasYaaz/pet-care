<?php

namespace App\Models;

use CodeIgniter\Model;

class ResepObatModel extends Model
{
    protected $table = 'RESEP_OBAT';
    protected $primaryKey = 'ID_RESEP_OBAT';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_RESEP_OBAT', 'ID_REKAM', 'ID_PARAMEDIS', 'TANGGAL_RESEP'];

    public function getResepWithDetail($id = null)
    {
        $builder = $this->builder();
        $builder->select('RESEP_OBAT.*, PARAMEDIS.NAMA_PARAMEDIS, REKAM_MEDIS.DIAGNOSIS');
        $builder->join('PARAMEDIS', 'PARAMEDIS.ID_PARAMEDIS = RESEP_OBAT.ID_PARAMEDIS');
        $builder->join('REKAM_MEDIS', 'REKAM_MEDIS.ID_REKAM = RESEP_OBAT.ID_REKAM');

        if ($id !== null) {
            return $builder->where('RESEP_OBAT.ID_RESEP_OBAT', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}