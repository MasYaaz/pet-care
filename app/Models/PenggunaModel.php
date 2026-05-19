<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table = 'PENGGUNA';
    protected $primaryKey = 'ID_PENGGUNA';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_PENGGUNA', 'ID_ROLE', 'USERNAME', 'PASSWORD', 'EMAIL', 'NO_TELP'];

    // Mendapatkan data pengguna beserta nama role-nya
    public function getPenggunaWithRole($id = null)
    {
        $builder = $this->builder();
        $builder->select('PENGGUNA.*, ROLE.NAMA_ROLE');
        $builder->join('ROLE', 'ROLE.ID_ROLE = PENGGUNA.ID_ROLE', 'left');

        if ($id !== null) {
            return $builder->where('PENGGUNA.ID_PENGGUNA', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}