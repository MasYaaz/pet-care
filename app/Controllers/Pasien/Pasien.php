<?php

namespace App\Controllers\Pasien;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\ReservasiModel;
use App\Models\JadwalDokterModel;

class Pasien extends BaseController
{
    protected $pasienModel;
    protected $reservasiModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        $this->reservasiModel = new ReservasiModel();
    }

    // MENU 1: Menampilkan daftar anabul milik user yang sedang login
    public function anabul()
    {
        $idPengguna = session()->get('id_pengguna');

        // Ambil semua anabul yang diikat oleh ID Pengguna milik akun ini
        $data['my_anabul'] = $this->pasienModel->where('ID_PENGGUNA', $idPengguna)->findAll();

        return view('pasien/anabul/index', $data);
    }

    public function tambahAnabul()
    {
        return view('pasien/anabul/tambah');
    }

    public function simpanAnabul()
    {
        // Ambil ID Pengguna dari session login aktif
        $idPengguna = session()->get('id_pengguna');

        $namaHewan = $this->request->getPost('nama_hewan');
        $jenisHewan = $this->request->getPost('jenis_hewan');
        $ras = $this->request->getPost('ras');
        $tglLahir = $this->request->getPost('tgl_lahir');

        // Suntikkan data langsung ke tabel PASIEN
        $this->pasienModel->insert([
            'ID_PENGGUNA' => $idPengguna, // Mengikat kepemilikan ke user ini
            'NAMA_HEWAN' => $namaHewan,
            'JENIS_HEWAN' => $jenisHewan,
            'RAS' => $ras,
            'TGL_LAHIR' => $tglLahir
        ]);

        session()->setFlashdata('success', 'Anggota keluarga anabul baru bernama ' . $namaHewan . ' berhasil didaftarkan!');
        return redirect()->to(base_url('pasien/anabul'));
    }

    // Tambahkan method ini ke dalam class Pasien:

    public function hapusAnabul($idPasien)
    {
        $idPengguna = session()->get('id_pengguna');

        // PROTEKSI: Cek apakah anabul ini benar-benar milik user yang sedang login
        $cekKepemilikan = $this->pasienModel->where([
            'ID_PASIEN' => $idPasien,
            'ID_PENGGUNA' => $idPengguna
        ])->first();

        if (!$cekKepemilikan) {
            session()->setFlashdata('error', 'Akses ditolak! Anda tidak memiliki wewenang menghapus data ini.');
            return redirect()->to(base_url('pasien/anabul'));
        }

        // Jika lolos pengecekan, lakukan penghapusan
        $this->pasienModel->delete($idPasien);

        session()->setFlashdata('success', 'Data profil anabul kesayangan Anda berhasil dihapus dari sistem.');
        return redirect()->to(base_url('pasien/anabul'));
    }

    // Tambahkan kedua method ini ke dalam class Pasien:

    public function editAnabul($idPasien)
    {
        $idPengguna = session()->get('id_pengguna');

        // PROTEKSI: Pastikan anabul yang mau diedit adalah milik user yang login
        $data['anabul'] = $this->pasienModel->where([
            'ID_PASIEN' => $idPasien,
            'ID_PENGGUNA' => $idPengguna
        ])->first();

        if (!$data['anabul']) {
            session()->setFlashdata('error', 'Akses ditolak! Data tidak ditemukan atau Anda tidak memiliki akses.');
            return redirect()->to(base_url('pasien/anabul'));
        }

        return view('pasien/anabul/edit', $data);
    }

    public function updateAnabul($idPasien)
    {
        $idPengguna = session()->get('id_pengguna');

        // PROTEKSI: Pastikan kembali kepemilikan sebelum update dieksekusi
        $cekKepemilikan = $this->pasienModel->where([
            'ID_PASIEN' => $idPasien,
            'ID_PENGGUNA' => $idPengguna
        ])->first();

        if (!$cekKepemilikan) {
            session()->setFlashdata('error', 'Gagal memperbarui! Anda tidak memiliki otoritas atas data ini.');
            return redirect()->to(base_url('pasien/anabul'));
        }

        // Eksekusi update data
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

        // Ambil daftar anabul milik dia sendiri untuk select option
        $data['my_anabul'] = $this->pasienModel->where('ID_PENGGUNA', $idPengguna)->findAll();

        // Ambil master jadwal dokter aktif untuk dipilih
        $jadwalModel = new JadwalDokterModel();
        $data['jadwal_dokter'] = $jadwalModel->select('JADWAL_DOKTER.ID_JADWAL, JADWAL_DOKTER.HARI, JADWAL_DOKTER.JAM_MULAI, JADWAL_DOKTER.JAM_SELESAI, PENGGUNA.NAMA_LENGKAP AS NAMA_DOKTER')
            ->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = DOKTER.ID_PENGGUNA')
            ->findAll();

        return view('pasien/booking/tambah', $data);
    }

    // PROSES SIMPAN: Menyimpan booking online dari pasien
    public function simpanBooking()
    {
        $idPasien = $this->request->getPost('id_pasien');
        $idJadwal = $this->request->getPost('id_jadwal');
        $tglKunjungan = $this->request->getPost('tanggal_kunjungan');
        $keluhan = $this->request->getPost('keluhan');

        // Masukkan data ke tabel RESERVASI
        // ID_PARAMEDIS dikosongkan (null) dulu karena di-booking mandiri oleh user online, bukan dari loket
        $this->reservasiModel->insert([
            'ID_PARAMEDIS' => null,
            'ID_PASIEN' => $idPasien,
            'ID_JADWAL' => $idJadwal,
            'TANGGAL_KUNJUNGAN' => $tglKunjungan,
            'KELUHAN' => $keluhan,
            'CREATED_AT' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('success', 'Booking jadwal berhasil diajukan! Silakan datang sesuai tanggal pilihan Anda.');
        return redirect()->to(base_url('dashboard')); // Balikkan ke dashboard utama
    }
}