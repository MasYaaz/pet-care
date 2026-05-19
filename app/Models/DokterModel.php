<?php

namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table = 'DOKTER';
    protected $primaryKey = 'ID_DOKTER';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_DOKTER', 'ID_PENGGUNA', 'NAMA_DOKTER', 'SPESIALISASI', 'NO_STR'];

    // Menampilkan profil dokter beserta info akun pengguna
    public function getDokterWithAkun($id = null)
    {
        $builder = $this->builder();
        $builder->select('DOKTER.*, PENGGUNA.USERNAME, PENGGUNA.EMAIL, PENGGUNA.NO_TELP');
        $builder->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = DOKTER.ID_PENGGUNA');

        if ($id !== null) {
            return $builder->where('DOKTER.ID_DOKTER', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}