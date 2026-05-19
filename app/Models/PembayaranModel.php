<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'PEMBAYARAN';
    protected $primaryKey = 'ID_PEMBAYARAN';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'ID_PEMBAYARAN',
        'ID_JENIS_ITEM',
        'ID_RESERVASI',
        'ID_METODE_BAYAR',
        'ID_STATUS_BAYAR',
        'ID_ITEM_TAGIHAN',
        'ID_PASIEN',
        'SUBTOTAL_TINDAKAN',
        'SUBTOTAL_OBAT',
        'BIAYA_KONSULTASI',
        'TOTAL_TAGIHAN',
        'JUMLAH_BAYAR',
        'KEMBALIAN',
        'KODE_TRANSAKSI',
        'TGL_BAYAR'
    ];

    // Mengambil Invoice Lengkap Kasir beserta status dan nama pemililik hewan
    public function getInvoiceLengkap($idPembayaran = null)
    {
        $builder = $this->builder();
        $builder->select('PEMBAYARAN.*, PASIEN.NAMA_HEWAN, PASIEN.NAMA_PEMILIK, METODE_BAYAR.NAMA_METODE_BAYAR, STATUS_BAYAR.NAMA_STATUS_BAYAR, ITEM_TAGIHAN.KETERANGAN');
        $builder->join('PASIEN', 'PASIEN.ID_PASIEN = PEMBAYARAN.ID_PASIEN');
        $builder->join('METODE_BAYAR', 'METODE_BAYAR.ID_METODE_BAYAR = PEMBAYARAN.ID_METODE_BAYAR');
        $builder->join('STATUS_BAYAR', 'STATUS_BAYAR.ID_STATUS_BAYAR = PEMBAYARAN.ID_STATUS_BAYAR');
        $builder->join('ITEM_TAGIHAN', 'ITEM_TAGIHAN.ID_ITEM_TAGIHAN = PEMBAYARAN.ID_ITEM_TAGIHAN');

        if ($idPembayaran !== null) {
            return $builder->where('PEMBAYARAN.ID_PEMBAYARAN', $idPembayaran)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }
}