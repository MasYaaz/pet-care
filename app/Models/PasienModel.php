<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table = 'PASIEN';
    protected $primaryKey = 'ID_PASIEN';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    // REVISI: Hanya menyisakan kolom spesifik hewan saja
    protected $allowedFields = ['ID_PASIEN', 'ID_PENGGUNA', 'NAMA_HEWAN', 'JENIS_HEWAN', 'RAS', 'TGL_LAHIR'];

    public function getPasienWithAkun($id = null)
    {
        $builder = $this->builder();
        // REVISI: Mengambil NAMA_LENGKAP (Nama Pemilik) dan ALAMAT dari tabel PENGGUNA
        $builder->select('PASIEN.*, PENGGUNA.USERNAME, PENGGUNA.NO_TELP, PENGGUNA.EMAIL, PENGGUNA.NAMA_LENGKAP AS NAMA_PEMILIK, PENGGUNA.ALAMAT');
        $builder->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PASIEN.ID_PENGGUNA', 'left');

        if ($id !== null) {
            return $builder->where('PASIEN.ID_PASIEN', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}