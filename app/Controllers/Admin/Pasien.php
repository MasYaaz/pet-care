<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use App\Models\PasienModel;

class Pasien extends BaseController
{
    protected $pasienModel;
    protected $penggunaModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        $this->penggunaModel = new PenggunaModel();
    }

    // =========================================================================
    // 1. READ: Tampilkan Semua Data Pasien & Owner ke Admin
    // =========================================================================
    public function index()
    {
        $data['list_pasien'] = $this->pasienModel->select('PASIEN.*, PENGGUNA.NAMA_LENGKAP, PENGGUNA.USERNAME, PENGGUNA.EMAIL, PENGGUNA.NO_TELP')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PASIEN.ID_PENGGUNA')
            ->orderBy('PASIEN.ID_PASIEN', 'DESC')
            ->findAll();

        return view('admin/pasien/index', $data);
    }

    // =========================================================================
    // 2. UPDATE (Form): Ambil Data Kamar Pasien & Owner untuk Diedit
    // =========================================================================
    public function edit($idPasien)
    {
        $data['pasien'] = $this->pasienModel->select('PASIEN.*, PENGGUNA.NAMA_LENGKAP, PENGGUNA.USERNAME, PENGGUNA.EMAIL, PENGGUNA.NO_TELP, PENGGUNA.ALAMAT')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PASIEN.ID_PENGGUNA')
            ->find($idPasien);

        if (!$data['pasien']) {
            session()->setFlashdata('error', 'Data pasien/owner tidak ditemukan.');
            return redirect()->to(base_url('admin/pasien'));
        }

        return view('admin/pasien/edit', $data);
    }

    // =========================================================================
    // 3. UPDATE (Proses): Eksekusi Perubahan Dua Tabel (Transaction)
    // =========================================================================
    public function update($idPasien)
    {
        $pasien = $this->pasienModel->find($idPasien);
        if (!$pasien) {
            session()->setFlashdata('error', 'Data tidak valid.');
            return redirect()->to(base_url('admin/pasien'));
        }

        $idPengguna = $pasien['ID_PENGGUNA'];
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $passwordBaru = $this->request->getPost('password');

        // Validasi keunikan username & email owner (abaikan milik dia sendiri)
        $userCheck = $this->penggunaModel->where('USERNAME', $username)->where('ID_PENGGUNA !=', $idPengguna)->first();
        if ($userCheck) {
            session()->setFlashdata('error', 'Username sudah digunakan oleh pengguna lain.');
            return redirect()->back()->withInput();
        }

        $emailCheck = $this->penggunaModel->where('EMAIL', $email)->where('ID_PENGGUNA !=', $idPengguna)->first();
        if ($emailCheck) {
            session()->setFlashdata('error', 'Email sudah digunakan oleh pengguna lain.');
            return redirect()->back()->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Langkah A: Perbarui data akun induk milik Owner
        $updateUser = [
            'USERNAME' => $username,
            'EMAIL' => $email,
            'NO_TELP' => $this->request->getPost('no_telp'),
            'NAMA_LENGKAP' => $this->request->getPost('nama_lengkap'),
            'ALAMAT' => $this->request->getPost('alamat')
        ];

        if (!empty($passwordBaru)) {
            $updateUser['PASSWORD'] = password_hash($passwordBaru, PASSWORD_BCRYPT);
        }
        $this->penggunaModel->update($idPengguna, $updateUser);

        // Langkah B: Perbarui data fisik anabul di tabel PASIEN
        $this->pasienModel->update($idPasien, [
            'NAMA_HEWAN' => $this->request->getPost('nama_hewan'),
            'JENIS_HEWAN' => $this->request->getPost('jenis_hewan'),
            'RAS' => $this->request->getPost('ras'),
            'TGL_LAHIR' => $this->request->getPost('tgl_lahir')
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal memperbarui data karena kendala database.');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'Data rekam akun Owner & profil Anabul berhasil diperbarui.');
        return redirect()->to(base_url('admin/pasien'));
    }

    // =========================================================================
    // 4. DELETE: Hapus Pasien & Akun Owner terkait
    // =========================================================================
    public function hapus($idPasien)
    {
        $pasien = $this->pasienModel->find($idPasien);
        if (!$pasien) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to(base_url('admin/pasien'));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Hapus data anak (PASIEN)
        $this->pasienModel->delete($idPasien);

        // Hapus data induk (PENGGUNA)
        $this->penggunaModel->delete($pasien['ID_PENGGUNA']);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menghapus. Pasien kemungkinan besar sudah memiliki riwayat rekam medis/billing kasir.');
            return redirect()->to(base_url('admin/pasien'));
        }

        session()->setFlashdata('success', 'Profil anabul beserta akun portal owner berhasil dihapus.');
        return redirect()->to(base_url('admin/pasien'));
    }
}