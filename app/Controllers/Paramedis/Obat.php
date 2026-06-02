<?php

namespace App\Controllers\Paramedis;

use App\Controllers\BaseController;
use App\Models\ObatModel;

class Obat extends BaseController
{
    protected $obatModel;

    public function __construct()
    {
        $this->obatModel = new ObatModel();
    }

    // =========================================================================
    // 1. READ: Tampilkan Seluruh Stok Inventaris Apotek Klinik
    // =========================================================================
    public function index()
    {
        $data['list_obat'] = $this->obatModel->orderBy('STOK', 'ASC')->findAll();
        return view('paramedis/obat/index', $data);
    }

    // =========================================================================
    // 2. CREATE (Form): Tampilan Tambah Item Obat/Alkes Baru
    // =========================================================================
    public function tambah()
    {
        return view('paramedis/obat/tambah');
    }

    // =========================================================================
    // 3. CREATE (Proses): Eksekusi Simpan Data Produk Farmasi
    // =========================================================================
    public function simpan()
    {
        $namaObat = $this->request->getPost('nama_obat');

        if ($this->obatModel->where('NAMA_OBAT', $namaObat)->first()) {
            session()->setFlashdata('error', 'Produk bernama "' . $namaObat . '" sudah terdaftar.');
            return redirect()->back()->withInput();
        }

        // SINKRONISASI: Menggunakan JENIS dan SATUAN sesuai allowedFields Model asli
        $this->obatModel->insert([
            'NAMA_OBAT' => $namaObat,
            'JENIS' => $this->request->getPost('jenis') ?? 'Obat Umum',
            'SATUAN' => $this->request->getPost('satuan') ?? 'Pcs',
            'STOK' => (int) $this->request->getPost('stok'),
            'HARGA_SATUAN_OBAT' => (int) $this->request->getPost('harga_satuan_obat')
        ]);

        session()->setFlashdata('success', 'Produk farmasi baru "' . $namaObat . '" berhasil diinput.');
        return redirect()->to(base_url('paramedis/obat'));
    }

    // =========================================================================
    // 4. UPDATE (Form): Ambil Berkas Obat Lama untuk Dimodifikasi
    // =========================================================================
    public function edit($idObat)
    {
        $data['obat'] = $this->obatModel->find($idObat);

        if (!$data['obat']) {
            session()->setFlashdata('error', 'Data produk farmasi tidak ditemukan.');
            return redirect()->to(base_url('paramedis/obat'));
        }

        return view('paramedis/obat/edit', $data);
    }

    // =========================================================================
    // 5. UPDATE (Proses): Perbarui Nominal Harga, Stok Opname, Jenis, atau Satuan
    // =========================================================================
    public function update($idObat)
    {
        if (!$this->obatModel->find($idObat)) {
            session()->setFlashdata('error', 'Gagal memperbarui, produk tidak valid.');
            return redirect()->to(base_url('paramedis/obat'));
        }

        $namaObat = $this->request->getPost('nama_obat');

        $checkDuplicate = $this->obatModel->where('NAMA_OBAT', $namaObat)->where('ID_OBAT !=', $idObat)->first();
        if ($checkDuplicate) {
            session()->setFlashdata('error', 'Nama obat "' . $namaObat . '" sudah digunakan oleh produk lain.');
            return redirect()->back()->withInput();
        }

        // SINKRONISASI: Update menggunakan field JENIS dan SATUAN asli
        $this->obatModel->update($idObat, [
            'NAMA_OBAT' => $namaObat,
            'JENIS' => $this->request->getPost('jenis'),
            'SATUAN' => $this->request->getPost('satuan'),
            'STOK' => (int) $this->request->getPost('stok'),
            'HARGA_SATUAN_OBAT' => (int) $this->request->getPost('harga_satuan_obat')
        ]);

        session()->setFlashdata('success', 'Data pembaruan logistik "' . $namaObat . '" berhasil disimpan.');
        return redirect()->to(base_url('paramedis/obat'));
    }

    // =========================================================================
    // 6. DELETE: Hapus Item dari Gudang Farmasi
    // =========================================================================
    public function hapus($idObat)
    {
        $obat = $this->obatModel->find($idObat);
        if (!$obat) {
            session()->setFlashdata('error', 'Data obat tidak ditemukan.');
            return redirect()->to(base_url('paramedis/obat'));
        }

        $deleteSuccess = $this->obatModel->delete($idObat);

        if ($deleteSuccess) {
            session()->setFlashdata('success', 'Produk "' . $obat['NAMA_OBAT'] . '" telah dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus produk, data terikat resep rekam medis.');
        }

        return redirect()->to(base_url('paramedis/obat'));
    }
}