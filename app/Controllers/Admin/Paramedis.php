<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use App\Models\ParamedisModel;

class Paramedis extends BaseController
{
    // Menampilkan daftar seluruh staf paramedis
    public function index()
    {
        $paramedisModel = new ParamedisModel();
        $data['list_paramedis'] = $paramedisModel->select('PARAMEDIS.*, PENGGUNA.NAMA_LENGKAP, PENGGUNA.USERNAME, PENGGUNA.EMAIL, PENGGUNA.NO_TELP')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PARAMEDIS.ID_PENGGUNA')
            ->findAll();

        return view('admin/paramedis/index', $data);
    }

    // Form tambah paramedis baru
    public function tambah()
    {
        return view('admin/paramedis/tambah');
    }

    // Proses simpan akun paramedis baru
    public function simpan()
    {
        $penggunaModel = new PenggunaModel();
        $paramedisModel = new ParamedisModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        $noTelp = $this->request->getPost('no_telp');
        $namaLengkap = $this->request->getPost('nama_lengkap');
        $alamat = $this->request->getPost('alamat');
        $jabatan = $this->request->getPost('jabatan');

        if ($penggunaModel->where('USERNAME', $username)->first()) {
            session()->setFlashdata('error', 'Username paramedis sudah terdaftar.');
            return redirect()->back()->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Simpan ke tabel induk PENGGUNA (ID_ROLE = 2 untuk Paramedis)
        $penggunaModel->insert([
            'ID_ROLE' => 2,
            'USERNAME' => $username,
            'PASSWORD' => password_hash($password, PASSWORD_BCRYPT),
            'EMAIL' => $email,
            'NO_TELP' => $noTelp,
            'NAMA_LENGKAP' => $namaLengkap,
            'ALAMAT' => $alamat
        ]);
        $idPenggunaBaru = $db->insertID();

        // Simpan ke tabel anak PARAMEDIS
        $paramedisModel->insert([
            'ID_PENGGUNA' => $idPenggunaBaru,
            'JABATAN' => $jabatan
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menambahkan data paramedis.');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'Akun Paramedis berhasil diaktifkan.');
        return redirect()->to(base_url('admin/paramedis'));
    }
}