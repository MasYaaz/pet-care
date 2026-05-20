<?php

namespace App\Controllers;

use App\Models\PenggunaModel;

class Auth extends BaseController
{
    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/register');
    }

    public function registerProcess()
    {
        $penggunaModel = new \App\Models\PenggunaModel();
        $pasienModel = new \App\Models\PasienModel();

        // 1. Ambil data input form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        $noTelp = $this->request->getPost('no_telp');
        $namaLengkap = $this->request->getPost('nama_lengkap'); // Nama Pemilim asli
        $alamat = $this->request->getPost('alamat');

        // Data hewan pertama
        $namaHewan = $this->request->getPost('nama_hewan');
        $jenisHewan = $this->request->getPost('jenis_hewan');
        $ras = $this->request->getPost('ras');
        $tglLahir = $this->request->getPost('tgl_lahir');

        // Validasi keunikan username
        $cekUser = $penggunaModel->where('USERNAME', $username)->first();
        if ($cekUser) {
            session()->setFlashdata('error', 'Username sudah digunakan. Silakan pilih username lain.');
            return redirect()->back()->withInput();
        }

        // Bungkus proses ke dalam Database Transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Langkah A: Insert data personal pemilik ke tabel PENGGUNA (ID_ROLE = 3)
        $penggunaData = [
            'ID_ROLE' => 3,
            'USERNAME' => $username,
            'PASSWORD' => password_hash($password, PASSWORD_BCRYPT),
            'EMAIL' => $email,
            'NO_TELP' => $noTelp,
            'NAMA_LENGKAP' => $namaLengkap,
            'ALAMAT' => $alamat
        ];
        $penggunaModel->insert($penggunaData);
        $idPenggunaBaru = $db->insertID(); // Tangkap id_pengguna yang barusan digenerate

        // Langkah B: Insert data spesifik hewan pertama ke tabel PASIEN
        $pasienData = [
            'ID_PENGGUNA' => $idPenggunaBaru, // Ikat relasi One-to-Many ke Pemiliknya
            'NAMA_HEWAN' => $namaHewan,
            'JENIS_HEWAN' => $jenisHewan,
            'RAS' => $ras,
            'TGL_LAHIR' => $tglLahir
        ];
        $pasienModel->insert($pasienData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Pendaftaran gagal karena terjadi kendala teknis database.');
            return redirect()->back()->withInput();
        }

        // Otomatis buat session login agar pengguna langsung diarahkan masuk
        $sessionData = [
            'id_pengguna' => $idPenggunaBaru,
            'id_role' => 3,
            'username' => $username,
            'nama_lengkap' => $namaLengkap,
            'nama_role' => 'Pasien',
            'logged_in' => true,
        ];
        session()->set($sessionData);

        return redirect()->to(base_url('dashboard'));
    }

    public function login()
    {
        // Jika sudah login, tendang langsung ke halaman dashboard internal
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        $penggunaModel = new PenggunaModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // 1. Ambil data dasar pengguna beserta role & nama lengkapnya
        $user = $penggunaModel->select('PENGGUNA.*, ROLE.NAMA_ROLE')
            ->join('ROLE', 'ROLE.ID_ROLE = PENGGUNA.ID_ROLE', 'left')
            ->where('USERNAME', $username)
            ->first();

        if ($user) {
            // 2. Verifikasi kesesuaian password
            if (password_verify($password, $user['PASSWORD']) || $password === $user['PASSWORD']) {

                // 3. REVISI SANGAT SINGKAT: Langsung petakan payload ke Session aplikasi
                // Tidak perlu lagi memanggil DokterModel, ParamedisModel, atau PasienModel di sini!
                $sessionData = [
                    'id_pengguna' => $user['ID_PENGGUNA'],
                    'id_role' => $user['ID_ROLE'],
                    'username' => $user['USERNAME'],
                    'nama_lengkap' => $user['NAMA_LENGKAP'], // <-- Langsung diambil dari tabel PENGGUNA
                    'nama_role' => $user['NAMA_ROLE'],
                    'logged_in' => true,
                ];
                session()->set($sessionData);

                return redirect()->to(base_url('dashboard'));
            } else {
                session()->setFlashdata('error', 'Kombinasi password yang Anda masukkan salah.');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Username tidak terdaftar pada sistem klinik.');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}