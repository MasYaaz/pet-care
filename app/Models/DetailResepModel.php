<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailResepModel extends Model
{
    protected $table = 'DETAIL_RESEP';
    protected $primaryKey = 'ID_DETAIL_RESEP';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_DETAIL_RESEP', 'ID_OBAT', 'ID_RESEP_OBAT', 'DOSIS', 'ATURAN_PAKAI', 'HARGA_TERCATAT', 'JUMLAH_RESEP'];

    // Mengambil item-item obat di dalam selembar resep
    public function getObatByResep($idResepObat)
    {
        return $this->builder()
            ->select('DETAIL_RESEP.*, OBAT.NAMA_OBAT, OBAT.SATUAN')
            ->join('OBAT', 'OBAT.ID_OBAT = DETAIL_RESEP.ID_OBAT')
            ->where('DETAIL_RESEP.ID_RESEP_OBAT', $idResepObat)
            ->get()->getResultArray();
    }
}