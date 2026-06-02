<?php

namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\ReservasiModel;
use App\Models\ObatModel;
use App\Models\DokterModel;
use App\Models\RekamMedisModel;
use App\Models\PenggunaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $reservasiModel = new ReservasiModel();
        $pasienModel = new PasienModel();
        $obatModel = new ObatModel();
        $dokterModel = new DokterModel();
        $rekamMedisModel = new RekamMedisModel();

        $idPengguna = session()->get('id_pengguna');
        $idRole = session()->get('id_role');

        // 1. Data statistik standar dasar untuk dashboard
        $data = [
            'nama_user' => session()->get('nama_lengkap'),
            'role_user' => session()->get('nama_role'),
        ];

        // KONDISIONAL DOKTER (Role ID = 1)
        if ($idRole == 1) {
            $dokter = $dokterModel->where('ID_PENGGUNA', $idPengguna)->first();
            $idDokter = $dokter ? $dokter['ID_DOKTER'] : null;

            $data['tindakan_selesai'] = $rekamMedisModel->where('ID_DOKTER', $idDokter)->countAllResults();

            $data['antrean_baru'] = $reservasiModel->join('JADWAL_DOKTER', 'JADWAL_DOKTER.ID_JADWAL = RESERVASI.ID_JADWAL')
                ->where('JADWAL_DOKTER.ID_DOKTER', $idDokter)
                ->where('RESERVASI.TANGGAL_KUNJUNGAN', date('Y-m-d'))
                ->where('RESERVASI.STATUS_RESERVASI', 'Menunggu')
                ->countAllResults();

            $data['list_antrean'] = $reservasiModel->select('RESERVASI.*, PASIEN.NAMA_HEWAN, PENGGUNA.NAMA_LENGKAP AS NAMA_PEMILIK')
                ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
                ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PASIEN.ID_PENGGUNA')
                ->join('JADWAL_DOKTER', 'JADWAL_DOKTER.ID_JADWAL = RESERVASI.ID_JADWAL')
                ->where('JADWAL_DOKTER.ID_DOKTER', $idDokter)
                ->orderBy('RESERVASI.CREATED_AT', 'DESC')
                ->limit(5)
                ->find();
        }
        // KONDISIONAL PARAMEDIS (Role ID = 2)
        else if ($idRole == 2) {
            $data = [
                'antrean_baru' => $reservasiModel->where('STATUS_RESERVASI', 'Menunggu')->countAllResults(),
                'total_pasien' => $pasienModel->countAllResults(),
                'obat_kritis' => $obatModel->where('STOK <=', 10)->countAllResults(),
            ];
        }
        // KONDISIONAL PASIEN / PET OWNER (Role ID = 3)
        elseif ($idRole == 3) {
            $data['list_booking'] = $reservasiModel->select('
                    RESERVASI.*, 
                    PASIEN.NAMA_HEWAN, PASIEN.JENIS_HEWAN, PASIEN.RAS, 
                    JADWAL_DOKTER.JAM_MULAI, JADWAL_DOKTER.JAM_SELESAI,
                    P_DOKTER.NAMA_LENGKAP AS NAMA_DOKTER
                ')
                ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
                ->join('JADWAL_DOKTER', 'JADWAL_DOKTER.ID_JADWAL = RESERVASI.ID_JADWAL')
                ->join('DOKTER', 'DOKTER.ID_DOKTER = JADWAL_DOKTER.ID_DOKTER')
                ->join('PENGGUNA AS P_DOKTER', 'P_DOKTER.ID_PENGGUNA = DOKTER.ID_PENGGUNA')
                ->where('PASIEN.ID_PENGGUNA', $idPengguna)
                ->whereIn('RESERVASI.STATUS_RESERVASI', ['Menunggu', 'Diperiksa'])
                ->orderBy('RESERVASI.TANGGAL_KUNJUNGAN', 'ASC')
                ->findAll();
        }

        // 4. KONDISIONAL UTAMA MANAGEMENT: ADMIN (Role ID = 4)
        elseif ($idRole == 4) {
            $db = \Config\Database::connect();

            $data['total_dokter'] = $db->table('DOKTER')->countAllResults();
            $data['total_paramedis'] = $db->table('PARAMEDIS')->countAllResults();
            $data['total_pasien'] = $db->table('PASIEN')->countAllResults();
        }

        // 5. Fallback Live Log Antrean Global untuk Admin dan Paramedis (Role 2 & 4)
        if ($idRole == 2 || $idRole == 4) {
            $data['list_antrean'] = $reservasiModel->select('RESERVASI.*, PASIEN.NAMA_HEWAN, PENGGUNA.NAMA_LENGKAP AS NAMA_PEMILIK')
                ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
                ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = PASIEN.ID_PENGGUNA')
                ->orderBy('RESERVASI.CREATED_AT', 'DESC')
                ->limit(5)
                ->find();
        }

        return view('dashboard/index', $data);
    }

    // =========================================================================
    // TAMPILAN FORM EDIT PROFIL (UNTUK SEMUA ROLE)
    // =========================================================================
    public function editProfil()
    {
        $penggunaModel = new PenggunaModel();
        $idPengguna = session()->get('id_pengguna');

        $data['user'] = $penggunaModel->find($idPengguna);

        if (!$data['user']) {
            session()->setFlashdata('error', 'Sesi pengguna tidak valid.');
            return redirect()->to(base_url('dashboard'));
        }

        return view('dashboard/edit_profil', $data);
    }

    // =========================================================================
    // PROSES SIMPAN PERUBAHAN PROFIL & RE-SET SESSION
    // =========================================================================
    public function updateProfil()
    {
        $penggunaModel = new PenggunaModel();
        $idPengguna = session()->get('id_pengguna');

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $passwordNew = $this->request->getPost('password');
        $namaLengkap = $this->request->getPost('nama_lengkap');

        // 1. Validasi Keunikan Username (Mengabaikan milik akun sendiri)
        $userCheck = $penggunaModel->where('USERNAME', $username)->where('ID_PENGGUNA !=', $idPengguna)->first();
        if ($userCheck) {
            session()->setFlashdata('error', 'Username sudah digunakan orang lain.');
            return redirect()->back()->withInput();
        }

        // 2. Validasi Keunikan Email (SINKRONISASI: Mengabaikan email milik sendiri)
        $emailCheck = $penggunaModel->where('EMAIL', $email)->where('ID_PENGGUNA !=', $idPengguna)->first();
        if ($emailCheck) {
            session()->setFlashdata('error', 'Email sudah terdaftar pada akun lain.');
            return redirect()->back()->withInput();
        }

        // 3. Logika Pengolahan Gambar Base64 Croppie ke Gambar Fisik
        $base64Image = $this->request->getPost('foto_crop_base64');

        if (!empty($base64Image)) {
            // Pecah string header base64 (data:image/jpeg;base64,.....)
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $data = substr($base64Image, strpos($base64Image, ',') + 1);
                $type = strtolower($type[1]); // jpeg, png, jpg

                // Validasi format ekstensi gambar aman
                if (in_array($type, ['jpg', 'jpeg', 'png'])) {
                    $data = base64_decode($data);

                    if ($data !== false) {
                        $targetFolder = ROOTPATH . 'public/uploads/avatars/';

                        // Buat folder otomatis jika belum tersedia
                        if (!is_dir($targetFolder)) {
                            mkdir($targetFolder, 0777, true);
                        }

                        // Tentukan nama file konstan berbasis ID user
                        $namaFileBaru = $idPengguna . '.jpg';

                        // Tulis ulang file biner gambar ke dalam direktori publik server
                        file_put_contents($targetFolder . $namaFileBaru, $data);
                    }
                }
            }
        }

        // 4. Eksekusi Update Informasi Akun Induk
        $updateData = [
            'USERNAME' => $username,
            'EMAIL' => $email,
            'NO_TELP' => $this->request->getPost('no_telp'),
            'NAMA_LENGKAP' => $namaLengkap,
            'ALAMAT' => $this->request->getPost('alamat')
        ];

        if (!empty($passwordNew)) {
            $updateData['PASSWORD'] = password_hash($passwordNew, PASSWORD_BCRYPT);
        }

        $penggunaModel->update($idPengguna, $updateData);

        // Segarkan session nama lengkap di header utama layout secara realtime
        session()->set(['nama_lengkap' => $namaLengkap]);

        session()->setFlashdata('success', 'Profil dan foto akun Anda berhasil diperbarui.');
        return redirect()->to(base_url('dashboard'));
    }
}