<?php

namespace App\Models;

use CodeIgniter\Model;

class RekamTindakanModel extends Model
{
    protected $table = 'REKAM_TINDAKAN';
    protected $primaryKey = 'ID_REKAM_TINDAKAN';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_REKAM_TINDAKAN', 'ID_TINDAKAN', 'ID_REKAM', 'HARGA_SAAT_ITU', 'JUMLAH_TINDAKAN'];

    // Melihat list tindakan yang didapatkan pasien pada satu sesi pemeriksaan
    public function getTindakanByRekamMedis($idRekam)
    {
        return $this->builder()
            ->select('REKAM_TINDAKAN.*, TINDAKAN.NAMA_TINDAKAN')
            ->join('TINDAKAN', 'TINDAKAN.ID_TINDAKAN = REKAM_TINDAKAN.ID_TINDAKAN')
            ->where('REKAM_TINDAKAN.ID_REKAM', $idRekam)
            ->get()->getResultArray();
    }
}