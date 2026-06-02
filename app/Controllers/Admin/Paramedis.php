<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use App\Models\ParamedisModel;

class Paramedis extends BaseController
{
    protected $paramedisModel;
    protected $penggunaModel;

    public function __construct()
    {
        $this->paramedisModel = new ParamedisModel();
        $this->penggunaModel = new PenggunaModel();
    }

    // =========================================================================
    // 1. READ: Menampilkan Daftar Seluruh Staf Paramedis
    // =========================================================================
    public function index()
    {
        $data['list_paramedis'] = $this->paramedisModel->select('PARAMEDIS.*, PENGGUNA.NAMA_LENGKAP, PENGGUNA.USERNAME, PENGGUNA.EMAIL, PENGGUNA.NO_TELP, PENGGUNA.ALAMAT')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PARAMEDIS.ID_PENGGUNA')
            ->findAll();

        return view('admin/paramedis/index', $data);
    }

    // =========================================================================
    // 2. CREATE: Form Tambah Paramedis Baru
    // =========================================================================
    public function tambah()
    {
        return view('admin/paramedis/tambah');
    }

    // =========================================================================
    // 3. CREATE: Proses Simpan Akun Paramedis Baru (Transaction)
    // =========================================================================
    public function simpan()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        $noTelp = $this->request->getPost('no_telp');
        $namaLengkap = $this->request->getPost('nama_lengkap');
        $alamat = $this->request->getPost('alamat');
        $jabatan = $this->request->getPost('jabatan');

        // Validasi keunikan data akun induk
        if ($this->penggunaModel->where('USERNAME', $username)->first()) {
            session()->setFlashdata('error', 'Username paramedis sudah terdaftar.');
            return redirect()->back()->withInput();
        }
        if ($this->penggunaModel->where('EMAIL', $email)->first()) {
            session()->setFlashdata('error', 'Email sudah digunakan oleh akun lain.');
            return redirect()->back()->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Simpan ke tabel induk PENGGUNA (ID_ROLE = 2 untuk Paramedis)
        $this->penggunaModel->insert([
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
        $this->paramedisModel->insert([
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

    // =========================================================================
    // 4. UPDATE: Form Edit Data Paramedis & Akun User
    // =========================================================================
    public function edit($idParamedis)
    {
        // Tarik data gabungan dari tabel anak PARAMEDIS dan tabel induk PENGGUNA
        $data['paramedis'] = $this->paramedisModel->select('PARAMEDIS.*, PENGGUNA.NAMA_LENGKAP, PENGGUNA.USERNAME, PENGGUNA.EMAIL, PENGGUNA.NO_TELP, PENGGUNA.ALAMAT')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PARAMEDIS.ID_PENGGUNA')
            ->find($idParamedis);

        if (!$data['paramedis']) {
            session()->setFlashdata('error', 'Data paramedis tidak ditemukan.');
            return redirect()->to(base_url('admin/paramedis'));
        }

        return view('admin/paramedis/edit', $data);
    }

    // =========================================================================
    // 5. UPDATE: Proses Perbarui Data Dua Tabel Sekaligus
    // =========================================================================
    public function update($idParamedis)
    {
        $paramedis = $this->paramedisModel->find($idParamedis);
        if (!$paramedis) {
            session()->setFlashdata('error', 'Data tidak valid.');
            return redirect()->to(base_url('admin/paramedis'));
        }

        $idPengguna = $paramedis['ID_PENGGUNA'];
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $passwordBaru = $this->request->getPost('password');

        // Validasi keunikan username (abaikan jika milik dia sendiri)
        $userCheck = $this->penggunaModel->where('USERNAME', $username)->where('ID_PENGGUNA !=', $idPengguna)->first();
        if ($userCheck) {
            session()->setFlashdata('error', 'Username sudah digunakan oleh akun staf lain.');
            return redirect()->back()->withInput();
        }

        // Validasi keunikan email (abaikan jika milik dia sendiri)
        $emailCheck = $this->penggunaModel->where('EMAIL', $email)->where('ID_PENGGUNA !=', $idPengguna)->first();
        if ($emailCheck) {
            session()->setFlashdata('error', 'Email sudah digunakan oleh akun staf lain.');
            return redirect()->back()->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Langkah A: Update data akun induk PENGGUNA
        $updateUser = [
            'USERNAME' => $username,
            'EMAIL' => $email,
            'NO_TELP' => $this->request->getPost('no_telp'),
            'NAMA_LENGKAP' => $this->request->getPost('nama_lengkap'),
            'ALAMAT' => $this->request->getPost('alamat')
        ];

        // Jika password baru diinput kasir/staf, lakukan hash ulang
        if (!empty($passwordBaru)) {
            $updateUser['PASSWORD'] = password_hash($passwordBaru, PASSWORD_BCRYPT);
        }

        $this->penggunaModel->update($idPengguna, $updateUser);

        // Langkah B: Update data struktural di tabel anak PARAMEDIS
        $this->paramedisModel->update($idParamedis, [
            'JABATAN' => $this->request->getPost('jabatan')
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal memperbarui data karena kendala database.');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'Data profil dan jabatan Paramedis berhasil diperbarui.');
        return redirect()->to(base_url('admin/paramedis'));
    }

    // =========================================================================
    // 6. DELETE: Hapus Data Akun Induk & Anak (Cascading Berbasis Transaksi)
    // =========================================================================
    public function hapus($idParamedis)
    {
        $paramedis = $this->paramedisModel->find($idParamedis);
        if (!$paramedis) {
            session()->setFlashdata('error', 'Data staf tidak ditemukan.');
            return redirect()->to(base_url('admin/paramedis'));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Hapus tabel anak (PARAMEDIS) terlebih dahulu demi mematuhi foreign key constraint
        $this->paramedisModel->delete($idParamedis);

        // Kemudian hapus akun login utamanya di tabel induk (PENGGUNA)
        $this->penggunaModel->delete($paramedis['ID_PENGGUNA']);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menghapus data. Akun staf ini kemungkinan sudah terikat dengan aktivitas transaksi kasir / registrasi loket.');
            return redirect()->to(base_url('admin/paramedis'));
        }

        session()->setFlashdata('success', 'Data akun paramedis berhasil dihapus secara permanen dari sistem.');
        return redirect()->to(base_url('admin/paramedis'));
    }
}