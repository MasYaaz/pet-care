<?php

namespace App\Controllers\Paramedis;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;

class Kasir extends BaseController
{
    protected $pembayaranModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
    }

    // Menampilkan daftar invoice tagihan pasien
    public function index()
    {
        // REVISI: Mengembalikan select ke STATUS_BAYAR (ENUM) dan menghapus JOIN ke tabel STATUS_BAYAR
        $data['list_billing'] = $this->pembayaranModel->select('
                PEMBAYARAN.*, 
                PASIEN.NAMA_HEWAN, 
                P_PEMILIK.NAMA_LENGKAP AS NAMA_PEMILIK, 
                METODE_BAYAR.NAMA_METODE_BAYAR
            ')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = PEMBAYARAN.ID_PASIEN')
            ->join('PENGGUNA AS P_PEMILIK', 'P_PEMILIK.ID_PENGGUNA = PASIEN.ID_PENGGUNA')
            ->join('METODE_BAYAR', 'METODE_BAYAR.ID_METODE_BAYAR = PEMBAYARAN.ID_METODE_BAYAR')
            ->orderBy('PEMBAYARAN.STATUS_BAYAR', 'ASC') // 'Belum Bayar' biasanya abjad duluan, pas naik ke atas
            ->orderBy('PEMBAYARAN.TGL_BAYAR', 'DESC')
            ->findAll();

        return view('paramedis/kasir/index', $data);
    }

    // Memproses transaksi pelunasan dan menghitung kembalian uang di kasir
    public function bayar($idPembayaran)
    {
        $pembayaran = $this->pembayaranModel->find($idPembayaran);
        if (!$pembayaran) {
            session()->setFlashdata('error', 'Data invoice pembayaran tidak ditemukan.');
            return redirect()->back();
        }

        $idMetodeBayar = $this->request->getPost('id_metode_bayar');
        $jumlahBayar = $this->request->getPost('jumlah_bayar');
        $totalTagihan = $pembayaran['TOTAL_TAGIHAN'];

        // Validasi kecukupan uang tunai
        if ($jumlahBayar < $totalTagihan) {
            session()->setFlashdata('error', 'Uang yang dibayarkan kurang dari total tagihan invoice!');
            return redirect()->back()->withInput();
        }

        $kembalian = $jumlahBayar - $totalTagihan;

        // REVISI: Menyetel kolom STATUS_BAYAR langsung dengan string 'Lunas' sesuai aturan ENUM
        $this->pembayaranModel->update($idPembayaran, [
            'ID_METODE_BAYAR' => $idMetodeBayar,
            'STATUS_BAYAR' => 'Lunas', // String ENUM
            'JUMLAH_BAYAR' => $jumlahBayar,
            'KEMBALIAN' => $kembalian,
            'TGL_BAYAR' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('success', 'Transaksi #' . $pembayaran['KODE_TRANSAKSI'] . ' Sukses. Kembalian: Rp ' . number_format($kembalian, 0, ',', '.'));
        return redirect()->to(base_url('paramedis/kasir'));
    }
}