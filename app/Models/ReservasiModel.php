<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasiModel extends Model
{
    protected $table = 'RESERVASI';
    protected $primaryKey = 'ID_RESERVASI';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_RESERVASI', 'ID_PARAMEDIS', 'ID_PASIEN', 'ID_JADWAL', 'TANGGAL_KUNJUNGAN', 'CREATED_AT', 'KELUHAN'];

    // Join kompleks untuk detail antrean / agenda reservasi klinik
    public function getDetailReservasi($id = null)
    {
        $builder = $this->builder();
        $builder->select('RESERVASI.*, PASIEN.NAMA_HEWAN, PASIEN.NAMA_PEMILIK, DOKTER.NAMA_DOKTER, JADWAL_DOKTER.HARI, PARAMEDIS.NAMA_PARAMEDIS');
        $builder->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN');
        $builder->join('JADWAL_DOKTER', 'JADWAL_DOKTER.ID_JADWAL = RESERVASI.ID_JADWAL');
        $builder->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER');
        $builder->join('PARAMEDIS', 'PARAMEDIS.ID_PARAMEDIS = RESERVASI.ID_PARAMEDIS');

        if ($id !== null) {
            return $builder->where('RESERVASI.ID_RESERVASI', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}