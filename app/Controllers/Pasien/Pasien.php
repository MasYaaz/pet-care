<?php

namespace App\Controllers\Pasien;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\ReservasiModel;
use App\Models\JadwalDokterModel;
use App\Models\RekamMedisModel;
use App\Models\PembayaranModel;

class Pasien extends BaseController
{
    protected $pasienModel;
    protected $reservasiModel;
    protected $rekamMedisModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        $this->reservasiModel = new ReservasiModel();
        $this->rekamMedisModel = new RekamMedisModel();
        $this->pembayaranModel = new PembayaranModel();
    }

    // MENU 1: Menampilkan daftar anabul milik user yang sedang login
    public function anabul()
    {
        $idPengguna = session()->get('id_pengguna');
        $data['my_anabul'] = $this->pasienModel->where('ID_PENGGUNA', $idPengguna)->findAll();
        return view('pasien/anabul/index', $data);
    }

    public function tambahAnabul()
    {
        return view('pasien/anabul/tambah');
    }

    public function simpanAnabul()
    {
        $idPengguna = session()->get('id_pengguna');
        $namaHewan = $this->request->getPost('nama_hewan');

        $this->pasienModel->insert([
            'ID_PENGGUNA' => $idPengguna,
            'NAMA_HEWAN' => $namaHewan,
            'JENIS_HEWAN' => $this->request->getPost('jenis_hewan'),
            'RAS' => $this->request->getPost('ras'),
            'TGL_LAHIR' => $this->request->getPost('tgl_lahir')
        ]);

        session()->setFlashdata('success', 'Anggota keluarga anabul baru bernama ' . $namaHewan . ' berhasil didaftarkan!');
        return redirect()->to(base_url('pasien/anabul'));
    }

    public function hapusAnabul($idPasien)
    {
        $idPengguna = session()->get('id_pengguna');
        $cekKepemilikan = $this->pasienModel->where(['ID_PASIEN' => $idPasien, 'ID_PENGGUNA' => $idPengguna])->first();

        if (!$cekKepemilikan) {
            session()->setFlashdata('error', 'Akses ditolak! Anda tidak memiliki wewenang menghapus data ini.');
            return redirect()->to(base_url('pasien/anabul'));
        }

        $this->pasienModel->delete($idPasien);
        session()->setFlashdata('success', 'Data profil anabul kesayangan Anda berhasil dihapus dari sistem.');
        return redirect()->to(base_url('pasien/anabul'));
    }

    public function editAnabul($idPasien)
    {
        $idPengguna = session()->get('id_pengguna');
        $data['anabul'] = $this->pasienModel->where(['ID_PASIEN' => $idPasien, 'ID_PENGGUNA' => $idPengguna])->first();

        if (!$data['anabul']) {
            session()->setFlashdata('error', 'Akses ditolak! Data tidak ditemukan atau Anda tidak memiliki akses.');
            return redirect()->to(base_url('pasien/anabul'));
        }

        return view('pasien/anabul/edit', $data);
    }

    public function updateAnabul($idPasien)
    {
        $idPengguna = session()->get('id_pengguna');
        $cekKepemilikan = $this->pasienModel->where(['ID_PASIEN' => $idPasien, 'ID_PENGGUNA' => $idPengguna])->first();

        if (!$cekKepemilikan) {
            session()->setFlashdata('error', 'Gagal memperbarui! Anda tidak memiliki otoritas atas data ini.');
            return redirect()->to(base_url('pasien/anabul'));
        }

        $this->pasienModel->update($idPasien, [
            'NAMA_HEWAN' => $this->request->getPost('nama_hewan'),
            'JENIS_HEWAN' => $this->request->getPost('jenis_hewan'),
            'RAS' => $this->request->getPost('ras'),
            'TGL_LAHIR' => $this->request->getPost('tgl_lahir')
        ]);

        session()->setFlashdata('success', 'Profil ' . $this->request->getPost('nama_hewan') . ' berhasil diperbarui!');
        return redirect()->to(base_url('pasien/anabul'));
    }

    // MENU 2: Halaman form booking jadwal dokter mandiri
    public function booking()
    {
        $idPengguna = session()->get('id_pengguna');
        $data['my_anabul'] = $this->pasienModel->where('ID_PENGGUNA', $idPengguna)->findAll();

        $jadwalModel = new JadwalDokterModel();
        $data['jadwal_dokter'] = $jadwalModel->select('JADWAL_DOKTER.ID_JADWAL, JADWAL_DOKTER.HARI, JADWAL_DOKTER.JAM_MULAI, JADWAL_DOKTER.JAM_SELESAI, JADWAL_DOKTER.KUOTA, PENGGUNA.NAMA_LENGKAP AS NAMA_DOKTER')
            ->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = DOKTER.ID_PENGGUNA')
            ->where('JADWAL_DOKTER.KUOTA >', 0) // Hanya tampilkan jadwal yang kuotanya masih ada
            ->findAll();

        return view('pasien/booking/tambah', $data);
    }

    // PROSES SIMPAN: Menyimpan booking online dari pasien + Potong Kuota Dokter
    public function simpanBooking()
    {
        $idPasien = $this->request->getPost('id_pasien');
        $idJadwal = $this->request->getPost('id_jadwal');
        $tglKunjungan = $this->request->getPost('tanggal_kunjungan');
        $keluhan = $this->request->getPost('keluhan');

        $jadwalModel = new JadwalDokterModel();
        $jadwal = $jadwalModel->find($idJadwal);

        // Validasi pengaman jika kuota mendadak habis terjual
        if (!$jadwal || $jadwal['KUOTA'] <= 0) {
            session()->setFlashdata('error', 'Gagal booking! Sesi jadwal dokter yang Anda pilih baru saja penuh.');
            return redirect()->back()->withInput();
        }

        // 1. Masukkan data ke tabel RESERVASI
        $this->reservasiModel->insert([
            'ID_PARAMEDIS' => null,
            'ID_PASIEN' => $idPasien,
            'ID_JADWAL' => $idJadwal,
            'TANGGAL_KUNJUNGAN' => $tglKunjungan,
            'KELUHAN' => $keluhan,
            'CREATED_AT' => date('Y-m-d H:i:s'),
            'STATUS_RESERVASI' => 'Menunggu'
        ]);

        // 2. Potong Kuota Operasional Praktik Dokter terkait secara otomatis (-1)
        $jadwalModel->where('ID_JADWAL', $idJadwal)
            ->set('KUOTA', 'KUOTA - 1', false)
            ->update();

        session()->setFlashdata('success', 'Booking jadwal berhasil diajukan! Silakan datang sesuai tanggal pilihan Anda.');
        return redirect()->to(base_url('pasien/anabul'));
    }

    // =========================================================================
    // MENU NEW 3: RIWAYAT REKAM MEDIS ANABUL (KHUSUS MILIK USER YANG LOGIN)
    // =========================================================================
    public function riwayatMedis()
    {
        $idPengguna = session()->get('id_pengguna');
        $db = \Config\Database::connect();

        // LANGKAH 1: Ambil data induk rekam medis seperti biasa (Query milikmu)
        $list_riwayat = $this->rekamMedisModel->select('
                REKAM_MEDIS.*, 
                PASIEN.NAMA_HEWAN, PASIEN.JENIS_HEWAN, 
                P_DOKTER.NAMA_LENGKAP AS NAMA_DOKTER
            ')
            ->join('RESERVASI', 'RESERVASI.ID_RESERVASI = REKAM_MEDIS.ID_RESERVASI')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
            ->join('DOKTER', 'DOKTER.ID_DOKTER = REKAM_MEDIS.ID_DOKTER')
            ->join('PENGGUNA AS P_DOKTER', 'P_DOKTER.ID_PENGGUNA = DOKTER.ID_PENGGUNA')
            ->where('PASIEN.ID_PENGGUNA', $idPengguna)
            ->orderBy('REKAM_MEDIS.TANGGAL_PERIKSA', 'DESC')
            ->findAll();

        // LANGKAH 2: Looping untuk menyuntikkan daftar detail resep obat secara spesifik
        if (!empty($list_riwayat)) {
            foreach ($list_riwayat as $key => $rm) {
                // Cari item obat berdasarkan relasi ID_REKAM melalui header RESEP_OBAT ke DETAIL_RESEP
                $list_riwayat[$key]['daftar_obat'] = $db->table('DETAIL_RESEP')
                    ->select('DETAIL_RESEP.DOSIS, DETAIL_RESEP.ATURAN_PAKAI, DETAIL_RESEP.JUMLAH_RESEP, OBAT.NAMA_OBAT')
                    ->join('RESEP_OBAT', 'RESEP_OBAT.ID_RESEP_OBAT = DETAIL_RESEP.ID_RESEP_OBAT')
                    ->join('OBAT', 'OBAT.ID_OBAT = DETAIL_RESEP.ID_OBAT')
                    ->where('RESEP_OBAT.ID_REKAM', $rm['ID_REKAM'])
                    ->get()->getResultArray();
            }
        }

        $data['riwayat_medis'] = $list_riwayat;

        return view('pasien/riwayat_medis/index', $data);
    }

    // =========================================================================
    // MENU NEW 4: RIWAYAT PEMBAYARAN / INVOICE KASIR (KHUSUS MILIK USER YANG LOGIN)
    // =========================================================================
    public function riwayatPembayaran()
    {
        $idPengguna = session()->get('id_pengguna');

        $data['riwayat_pembayaran'] = $this->pembayaranModel->select('
                PEMBAYARAN.*, 
                PASIEN.NAMA_HEWAN, 
                METODE_BAYAR.NAMA_METODE_BAYAR
            ')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = PEMBAYARAN.ID_PASIEN')
            ->join('METODE_BAYAR', 'METODE_BAYAR.ID_METODE_BAYAR = PEMBAYARAN.ID_METODE_BAYAR')
            ->where('PASIEN.ID_PENGGUNA', $idPengguna) // Proteksi: Hanya transaksi anabul miliknya sendiri
            ->orderBy('PEMBAYARAN.ID_PEMBAYARAN', 'DESC')
            ->findAll();

        return view('pasien/riwayat_pembayaran/index', $data);
    }
}