<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use App\Models\DokterModel;

class Dokter extends BaseController
{
    protected $dokterModel;
    protected $penggunaModel;

    public function __construct()
    {
        $this->dokterModel = new DokterModel();
        $this->penggunaModel = new PenggunaModel();
    }

    // =========================================================================
    // 1. READ: Tampilkan Semua Daftar Dokter
    // =========================================================================
    public function index()
    {
        $data['list_dokter'] = $this->dokterModel->select('DOKTER.*, PENGGUNA.NAMA_LENGKAP, PENGGUNA.USERNAME, PENGGUNA.EMAIL, PENGGUNA.NO_TELP, PENGGUNA.ALAMAT')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = DOKTER.ID_PENGGUNA')
            ->findAll();

        return view('admin/dokter/index', $data);
    }

    // =========================================================================
    // 2. CREATE: Form Tambah Dokter Baru
    // =========================================================================
    public function tambah()
    {
        return view('admin/dokter/tambah');
    }

    // =========================================================================
    // 3. CREATE: Proses Simpan Akun Induk & Anak (Transaction)
    // =========================================================================
    public function simpan()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        $noTelp = $this->request->getPost('no_telp');
        $namaLengkap = $this->request->getPost('nama_lengkap');
        $alamat = $this->request->getPost('alamat');
        $spesialisasi = $this->request->getPost('spesialisasi');
        $noStr = $this->request->getPost('no_str');

        // Validasi keunikan data akun induk
        if ($this->penggunaModel->where('USERNAME', $username)->first()) {
            session()->setFlashdata('error', 'Username sudah terdaftar di sistem.');
            return redirect()->back()->withInput();
        }
        if ($this->penggunaModel->where('EMAIL', $email)->first()) {
            session()->setFlashdata('error', 'Email sudah digunakan oleh akun lain.');
            return redirect()->back()->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Langkah A: Daftarkan ke PENGGUNA (ID_ROLE = 1 mewakili Dokter)
        $this->penggunaModel->insert([
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
        $this->dokterModel->insert([
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

    // =========================================================================
    // 4. UPDATE: Form Edit Data Dokter & User Akun
    // =========================================================================
    public function edit($idDokter)
    {
        // Tarik data gabungan dari tabel anak DOKTER dan tabel induk PENGGUNA
        $data['dokter'] = $this->dokterModel->select('DOKTER.*, PENGGUNA.NAMA_LENGKAP, PENGGUNA.USERNAME, PENGGUNA.EMAIL, PENGGUNA.NO_TELP, PENGGUNA.ALAMAT')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = DOKTER.ID_PENGGUNA')
            ->find($idDokter);

        if (!$data['dokter']) {
            session()->setFlashdata('error', 'Data dokter tidak ditemukan.');
            return redirect()->to(base_url('admin/dokter'));
        }

        return view('admin/dokter/edit', $data);
    }

    // =========================================================================
    // 5. UPDATE: Proses Perbarui Data Dua Tabel Sekaligus
    // =========================================================================
    public function update($idDokter)
    {
        $dokter = $this->dokterModel->find($idDokter);
        if (!$dokter) {
            session()->setFlashdata('error', 'Data tidak valid.');
            return redirect()->to(base_url('admin/dokter'));
        }

        $idPengguna = $dokter['ID_PENGGUNA'];
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

        // Langkah A: Siapkan update data akun induk PENGGUNA
        $updateUser = [
            'USERNAME' => $username,
            'EMAIL' => $email,
            'NO_TELP' => $this->request->getPost('no_telp'),
            'NAMA_LENGKAP' => $this->request->getPost('nama_lengkap'),
            'ALAMAT' => $this->request->getPost('alamat')
        ];

        // Jika password diisi di form, lakukan hash ulang. Jika kosong, biarkan password lama.
        if (!empty($passwordBaru)) {
            $updateUser['PASSWORD'] = password_hash($passwordBaru, PASSWORD_BCRYPT);
        }

        $this->penggunaModel->update($idPengguna, $updateUser);

        // Langkah B: Update data kompetensi klinis di tabel DOKTER
        $this->dokterModel->update($idDokter, [
            'SPESIALISASI' => $this->request->getPost('spesialisasi'),
            'NO_STR' => $this->request->getPost('no_str')
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal memperbarui data karena kendala database.');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'Data profil dan kompetensi Dokter berhasil diperbarui.');
        return redirect()->to(base_url('admin/dokter'));
    }

    // =========================================================================
    // 6. DELETE: Hapus Data Akun Induk & Anak (Cascading Berbasis Transaksi)
    // =========================================================================
    public function hapus($idDokter)
    {
        $dokter = $this->dokterModel->find($idDokter);
        if (!$dokter) {
            session()->setFlashdata('error', 'Data dokter memang tidak ditemukan.');
            return redirect()->to(base_url('admin/dokter'));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Sesuai constraint foreign key, kita hapus dulu tabel anak (DOKTER)
        $this->dokterModel->delete($idDokter);

        // Kemudian hapus login aksesnya di tabel induk (PENGGUNA)
        $this->penggunaModel->delete($dokter['ID_PENGGUNA']);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menghapus dokter. Data kemungkinan terikat dengan catatan medis / rekam jadwal.');
            return redirect()->to(base_url('admin/dokter'));
        }

        session()->setFlashdata('success', 'Akun akses dokter dan seluruh kompetensinya telah dihapus.');
        return redirect()->to(base_url('admin/dokter'));
    }
}