<?php

namespace App\Controllers\Paramedis; // Namespace khusus untuk operasional staf loket

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

    // Menampilkan seluruh data anabul dan pemilik di loket
    public function index()
    {
        // Menggunakan method buatan kita sebelumnya yang memakai teknik JOIN SQL
        $data['list_pasien'] = $this->pasienModel->getPasienWithAkun();
        return view('paramedis/pasien/index', $data);
    }

    // Form pendaftaran pasien langsung (Walk-in client) di meja resepsionis
    public function tambah()
    {
        return view('paramedis/pasien/tambah');
    }

    // Memproses simpan data registrasi dari loket
    public function simpan()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        $noTelp = $this->request->getPost('no_telp');
        $namaPemilik = $this->request->getPost('nama_lengkap');
        $alamat = $this->request->getPost('alamat');

        // Data Anabul
        $namaHewan = $this->request->getPost('nama_hewan');
        $jenisHewan = $this->request->getPost('jenis_hewan');
        $ras = $this->request->getPost('ras');
        $tglLahir = $this->request->getPost('tgl_lahir');

        if ($this->penggunaModel->where('USERNAME', $username)->first()) {
            session()->setFlashdata('error', 'Username pemilik sudah terdaftar.');
            return redirect()->back()->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Langkah A: Amankan data Akun Pemilik ke PENGGUNA (ID_ROLE = 3 mewakili Pasien/Client)
        $this->penggunaModel->insert([
            'ID_ROLE' => 3,
            'USERNAME' => $username,
            'PASSWORD' => password_hash($password, PASSWORD_BCRYPT),
            'EMAIL' => $email,
            'NO_TELP' => $noTelp,
            'NAMA_LENGKAP' => $namaPemilik,
            'ALAMAT' => $alamat
        ]);
        $idPemilikBaru = $db->insertID();

        // Langkah B: Ikat data hewan pertama ke ID Pemilik tersebut
        $this->pasienModel->insert([
            'ID_PENGGUNA' => $idPemilikBaru,
            'NAMA_HEWAN' => $namaHewan,
            'JENIS_HEWAN' => $jenisHewan,
            'RAS' => $ras,
            'TGL_LAHIR' => $tglLahir
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Pendaftaran pasien gagal diproses.');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'Data Pasien & Anabul berhasil dimasukkan ke sistem loket.');
        return redirect()->to(base_url('paramedis/pasien'));
    }
}