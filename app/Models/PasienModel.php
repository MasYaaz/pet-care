<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table = 'PASIEN';
    protected $primaryKey = 'ID_PASIEN';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_PASIEN', 'ID_PENGGUNA', 'NAMA_HEWAN', 'JENIS_HEWAN', 'RAS', 'TGL_LAHIR', 'NAMA_PEMILIK', 'ALAMAT'];

    public function getPasienWithAkun($id = null)
    {
        $builder = $this->builder();
        $builder->select('PASIEN.*, PENGGUNA.USERNAME, PENGGUNA.NO_TELP');
        $builder->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PASIEN.ID_PENGGUNA', 'left');

        if ($id !== null) {
            return $builder->where('PASIEN.ID_PASIEN', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}