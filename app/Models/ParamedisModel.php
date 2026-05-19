<?php

namespace App\Models;

use CodeIgniter\Model;

class ParamedisModel extends Model
{
    protected $table = 'PARAMEDIS';
    protected $primaryKey = 'ID_PARAMEDIS';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_PARAMEDIS', 'ID_PENGGUNA', 'NAMA_PARAMEDIS', 'JABATAN'];

    public function getParamedisWithAkun($id = null)
    {
        $builder = $this->builder();
        $builder->select('PARAMEDIS.*, PENGGUNA.USERNAME, PENGGUNA.EMAIL');
        $builder->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PARAMEDIS.ID_PENGGUNA');

        if ($id !== null) {
            return $builder->where('PARAMEDIS.ID_PARAMEDIS', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}