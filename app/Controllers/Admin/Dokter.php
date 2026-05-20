<?php

namespace App\Controllers\Admin; // REVISI: Namespace diganti ke folder Admin

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use App\Models\DokterModel;

class Dokter extends BaseController
{
    public function index()
    {
        $dokterModel = new DokterModel();

        $data['list_dokter'] = $dokterModel->select('DOKTER.*, PENGGUNA.NAMA_LENGKAP, PENGGUNA.USERNAME, PENGGUNA.EMAIL, PENGGUNA.NO_TELP')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = DOKTER.ID_PENGGUNA')
            ->findAll();

        return view('admin/dokter/index', $data); // REVISI: Mengarah ke folder view admin
    }

    public function tambah()
    {
        return view('admin/dokter/tambah'); // REVISI: Mengarah ke folder view admin
    }

    public function simpan()
    {
        $penggunaModel = new PenggunaModel();
        $dokterModel = new DokterModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        $noTelp = $this->request->getPost('no_telp');
        $namaLengkap = $this->request->getPost('nama_lengkap');
        $alamat = $this->request->getPost('alamat');
        $spesialisasi = $this->request->getPost('spesialisasi');
        $noStr = $this->request->getPost('no_str');

        // Validasi keunikan data akun induk
        if ($penggunaModel->where('USERNAME', $username)->first()) {
            session()->setFlashdata('error', 'Username sudah terdaftar di sistem.');
            return redirect()->back()->withInput();
        }
        if ($penggunaModel->where('EMAIL', $email)->first()) {
            session()->setFlashdata('error', 'Email sudah digunakan oleh akun lain.');
            return redirect()->back()->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Langkah A: Daftarkan ke PENGGUNA (ID_ROLE = 1 mewakili Dokter)
        $penggunaModel->insert([
            'ID_ROLE' => 1,
            'USERNAME' => $username,
            'PASSWORD' => password_hash($password, PASSWORD_BCRYPT),
            'EMAIL' => $email,
            'NO_TELP' => $noTelp,
            'NAMA_LENGKAP' => $namaLengkap,
            'ALAMAT' => $alamat
        ]);
        $idPenggunaBaru = $db->insertID();

        // Langkah B: Hubungkan data kompetensi klinis ke tabel anak DOKTER
        $dokterModel->insert([
            'ID_PENGGUNA' => $idPenggunaBaru,
            'SPESIALISASI' => $spesialisasi,
            'NO_STR' => $noStr
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan data dokter karena masalah database.');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'Akun Dokter baru berhasil diaktifkan.');
        return redirect()->to(base_url('admin/dokter'));
    }
}