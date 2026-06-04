<?php

namespace App\Controllers\Dokter;

use App\Controllers\BaseController;
use App\Models\ReservasiModel;
use App\Models\JadwalDokterModel;
use App\Models\DokterModel;
use App\Models\PembayaranModel;
use App\Models\RekamMedisModel;
use App\Models\ResepObatModel;
use App\Models\RekamTindakanModel;
use App\Models\DetailResepModel;
use App\Models\TindakanModel;
use App\Models\ObatModel;

class Dokter extends BaseController
{
    protected $reservasiModel;
    protected $jadwalDokterModel;
    protected $dokterModel;
    protected $rekamMedisModel; // TAMBAHAN: Properti untuk model baru
    protected $resepObatModel;   // TAMBAHAN: Properti untuk model baru

    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel();
        $this->jadwalDokterModel = new JadwalDokterModel();
        $this->dokterModel = new DokterModel();
        $this->rekamMedisModel = new RekamMedisModel(); // Inisialisasi
        $this->resepObatModel = new ResepObatModel();   // Inisialisasi
    }

    // Mengambil ID_DOKTER asli dari tabel anak berdasarkan id_pengguna yang login
    private function getLoggedInDokterId()
    {
        $idPengguna = session()->get('id_pengguna');
        $dokter = $this->dokterModel->where('ID_PENGGUNA', $idPengguna)->first();
        return $dokter ? $dokter['ID_DOKTER'] : null;
    }

    // MENU 1: Ruang Tunggu Medis (Antrean Khusus untuk Dokter Terkait)
    public function ruangTunggu()
    {
        $idDokter = $this->getLoggedInDokterId();

        $data['list_antrean'] = $this->reservasiModel->select('
                RESERVASI.*, 
                PASIEN.NAMA_HEWAN, PASIEN.JENIS_HEWAN, PASIEN.RAS, 
                P_PEMILIK.NAMA_LENGKAP AS NAMA_PEMILIK
            ')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
            ->join('PENGGUNA AS P_PEMILIK', 'P_PEMILIK.ID_PENGGUNA = PASIEN.ID_PENGGUNA')
            ->join('JADWAL_DOKTER', 'JADWAL_DOKTER.ID_JADWAL = RESERVASI.ID_JADWAL')
            ->where('JADWAL_DOKTER.ID_DOKTER', $idDokter)
            ->where('RESERVASI.TANGGAL_KUNJUNGAN', date('Y-m-d'))
            ->where('RESERVASI.STATUS_RESERVASI', 'Diperiksa') // Menampilkan yang sedang aktif diperiksa dokter
            ->orderBy('RESERVASI.ID_RESERVASI', 'ASC')
            ->findAll();

        return view('dokter/ruang_tunggu/index', $data);
    }

    public function periksaPasien($idReservasi)
    {
        $data['antrean'] = $this->reservasiModel->select('RESERVASI.*, PASIEN.NAMA_HEWAN, PASIEN.ID_PASIEN')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
            ->find($idReservasi);

        // Ambil data master untuk pilihan dropdown di view
        $data['master_tindakan'] = (new TindakanModel())->findAll();
        $data['master_obat'] = (new ObatModel())->where('STOK >', 0)->findAll();

        return view('dokter/rekam_medis/tambah', $data);
    }

    public function simpanRekamMedis()
    {
        $idReservasi = $this->request->getPost('id_reservasi');
        $idPasien = $this->request->getPost('id_pasien');

        // Sesuaikan penangkapan data post dengan allowedFields model (Gunakan huruf kecil/sesuai input form)
        $diagnosa = $this->request->getPost('diagnosa') ?? $this->request->getPost('diagnosis');
        $anamnesis = $this->request->getPost('anamnesis') ?? '-';
        $terapi = $this->request->getPost('terapi') ?? '-';
        $catatan = $this->request->getPost('catatan') ?? '-';

        // Tangkap data array dinamis dari form
        $arrIdTindakan = $this->request->getPost('id_tindakan');
        $arrTindakanQty = $this->request->getPost('tindakan_qty');
        $arrTindakanHarga = $this->request->getPost('tindakan_harga');

        $arrIdObat = $this->request->getPost('id_obat');
        $arrObatQty = $this->request->getPost('obat_qty');
        $arrObatHarga = $this->request->getPost('obat_harga');
        $arrObatDosis = $this->request->getPost('obat_dosis');
        $arrObatAturan = $this->request->getPost('obat_aturan');

        // Kalkulasi Finansial Tindakan
        $subtotalTindakan = 0;
        if (!empty($arrIdTindakan)) {
            foreach ($arrTindakanHarga as $key => $harga) {
                $subtotalTindakan += ((int) $harga * (int) $arrTindakanQty[$key]);
            }
        }

        // Kalkulasi Finansial Obat
        $subtotalObat = 0;
        if (!empty($arrIdObat)) {
            foreach ($arrObatHarga as $key => $harga) {
                $subtotalObat += ((int) $harga * (int) $arrObatQty[$key]);
            }
        }

        $biayaKonsul = (int) $this->request->getPost('biaya_konsultasi');
        $totalTagihan = $biayaKonsul + $subtotalTindakan + $subtotalObat;

        // Lacak Paramedis Loket Asal
        $reservasiAsal = $this->reservasiModel->find($idReservasi);
        $idParamedis = $reservasiAsal['ID_PARAMEDIS'] ?? 1;
        $idDokter = $this->getLoggedInDokterId();

        // --- LANGKAH 1: Insert ke tabel REKAM_MEDIS (Diselaraskan dengan Model) ---
        $this->rekamMedisModel->insert([
            'ID_RESERVASI' => $idReservasi,
            'ID_DOKTER' => $idDokter,
            'TANGGAL_PERIKSA' => date('Y-m-d H:i:s'),
            'ANAMNESIS' => $anamnesis,
            'DIAGNOSIS' => $diagnosa,
            'TERAPI' => $terapi,
            'CATATAN' => $catatan
        ]);
        $idRekamBaru = $this->rekamMedisModel->getInsertID();

        // --- LANGKAH 2: Insert item ke tabel REKAM_TINDAKAN ---
        if (!empty($arrIdTindakan)) {
            $rekamTindakanModel = new RekamTindakanModel();
            foreach ($arrIdTindakan as $key => $idTindakan) {
                if (!empty($idTindakan)) {
                    $rekamTindakanModel->insert([
                        'ID_TINDAKAN' => $idTindakan,
                        'ID_REKAM' => $idRekamBaru,
                        'HARGA_SAAT_ITU' => (int) $arrTindakanHarga[$key],
                        'JUMLAH_TINDAKAN' => (int) $arrTindakanQty[$key]
                    ]);
                }
            }
        }

        // --- LANGKAH 3: Insert header ke tabel RESEP_OBAT ---
        $this->resepObatModel->insert([
            'ID_REKAM' => $idRekamBaru,
            'ID_PARAMEDIS' => $idParamedis,
            'TANGGAL_RESEP' => date('Y-m-d')
        ]);
        $idResepBaru = $this->resepObatModel->getInsertID();

        // --- LANGKAH 4: Insert detail item ke tabel DETAIL_RESEP & Potong Stok ---
        if (!empty($arrIdObat)) {
            $detailResepModel = new DetailResepModel();
            $obatModel = new ObatModel();

            foreach ($arrIdObat as $key => $idObat) {
                if (!empty($idObat)) {
                    $detailResepModel->insert([
                        'ID_RESEP_OBAT' => $idResepBaru,
                        'ID_OBAT' => $idObat,
                        'DOSIS' => $arrObatDosis[$key],
                        'ATURAN_PAKAI' => $arrObatAturan[$key],
                        'HARGA_TERCATAT' => (int) $arrObatHarga[$key],
                        'JUMLAH_RESEP' => (int) $arrObatQty[$key]
                    ]);

                    // Pengurangan stok inventaris apotek secara atomik
                    $obatModel->where('ID_OBAT', $idObat)
                        ->set('STOK', "STOK - " . (int) $arrObatQty[$key], false)
                        ->update();
                }
            }
        }

        // --- LANGKAH 5: Buat invoice billing ke tabel PEMBAYARAN ---
        $pembayaranModel = new PembayaranModel();
        $pembayaranModel->insert([
            'ID_RESERVASI' => $idReservasi,
            'ID_METODE_BAYAR' => 1,
            'STATUS_BAYAR' => 'Belum Bayar',
            'ID_PASIEN' => $idPasien,
            'BIAYA_KONSULTASI' => $biayaKonsul,
            'SUBTOTAL_TINDAKAN' => $subtotalTindakan,
            'SUBTOTAL_OBAT' => $subtotalObat,
            'TOTAL_TAGIHAN' => $totalTagihan,
            'JUMLAH_BAYAR' => 0,
            'KEMBALIAN' => 0,
            'KODE_TRANSAKSI' => 'TX-' . time(),
            'TGL_BAYAR' => null
        ]);

        // --- LANGKAH 6: Selesaikan antrean di meja dokter ---
        $this->reservasiModel->update($idReservasi, ['STATUS_RESERVASI' => 'Selesai']);

        session()->setFlashdata('success', 'Rekam medis, item tindakan, resep, dan tagihan kasir berhasil disinkronkan.');
        return redirect()->to(base_url('dokter/ruang-tunggu'));
    }

    // =========================================================================
    // BARU: MODUL RIWAYAT REKAM MEDIS & EDIT REKAM MEDIS
    // =========================================================================

    // 1. READ: Daftar Semua Riwayat Medis yang Pernah Ditangani oleh Dokter Ini
    public function riwayatMedis()
    {
        $idDokter = $this->getLoggedInDokterId();

        $data['list_riwayat'] = $this->rekamMedisModel->select('
                REKAM_MEDIS.*, 
                PASIEN.NAMA_HEWAN, PASIEN.JENIS_HEWAN,
                P_PEMILIK.NAMA_LENGKAP AS NAMA_PEMILIK
            ')
            ->join('RESERVASI', 'RESERVASI.ID_RESERVASI = REKAM_MEDIS.ID_RESERVASI')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
            ->join('PENGGUNA AS P_PEMILIK', 'P_PEMILIK.ID_PENGGUNA = PASIEN.ID_PENGGUNA')
            ->where('REKAM_MEDIS.ID_DOKTER', $idDokter)
            ->orderBy('REKAM_MEDIS.TANGGAL_PERIKSA', 'DESC')
            ->findAll();

        return view('dokter/rekam_medis/riwayat', $data);
    }

    // 2. UPDATE (Form): Tampilan Mengubah Data Diagnosa & Resep Lama (PROTECTED STATUS_BAYAR)
    public function editRekamMedis($idRekam)
    {
        $idDokter = $this->getLoggedInDokterId();

        // Ambil rekam medis dengan proteksi kepemilikan dokter
        $rekam = $this->rekamMedisModel->select('REKAM_MEDIS.*, PASIEN.NAMA_HEWAN, RESERVASI.ID_PASIEN, RESERVASI.ID_RESERVASI')
            ->join('RESERVASI', 'RESERVASI.ID_RESERVASI = REKAM_MEDIS.ID_RESERVASI')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = RESERVASI.ID_PASIEN')
            ->where(['ID_REKAM' => $idRekam, 'ID_DOKTER' => $idDokter])
            ->first();

        if (!$rekam) {
            session()->setFlashdata('error', 'Data rekam medis tidak ditemukan atau akses ditolak.');
            return redirect()->to(base_url('dokter/riwayat-medis'));
        }

        // KUNCI PROTEKSI 1: Cek apakah invoice tagihan ini sudah lunas di kasir
        $pembayaranModel = new PembayaranModel();
        $pembayaran = $pembayaranModel->where('ID_RESERVASI', $rekam['ID_RESERVASI'])->first();

        if ($pembayaran && trim(strtolower($pembayaran['STATUS_BAYAR'])) === 'lunas') {
            session()->setFlashdata('error', 'Akses ditolak! Rekam medis tidak dapat diubah karena tagihan kasir sudah berstatus LUNAS.');
            return redirect()->to(base_url('dokter/riwayat-medis'));
        }

        $data['rekam'] = $rekam;

        // Ambil tindakan & obat yang terdaftar di rekam medis ini sebelumnya
        $data['current_tindakan'] = (new RekamTindakanModel())->where('ID_REKAM', $idRekam)->findAll();

        $resep = $this->resepObatModel->where('ID_REKAM', $idRekam)->first();
        $data['current_obat'] = $resep ? (new DetailResepModel())->where('ID_RESEP_OBAT', $resep['ID_RESEP_OBAT'])->findAll() : [];

        // Master data dropdown
        $data['master_tindakan'] = (new TindakanModel())->findAll();
        $data['master_obat'] = (new ObatModel())->findAll();

        return view('dokter/rekam_medis/edit', $data);
    }

    // 3. UPDATE (Proses): Sinkronisasi Perubahan & Re-Kalkulasi (PROTECTED STATUS_BAYAR)
    public function updateRekamMedis($idRekam)
    {
        $idDokter = $this->getLoggedInDokterId();

        $rekamExist = $this->rekamMedisModel->where(['ID_REKAM' => $idRekam, 'ID_DOKTER' => $idDokter])->first();
        if (!$rekamExist) {
            session()->setFlashdata('error', 'Gagal memperbarui, data tidak valid.');
            return redirect()->to(base_url('dokter/riwayat-medis'));
        }

        $idReservasi = $rekamExist['ID_RESERVASI'];
        $pembayaranModel = new PembayaranModel();

        // KUNCI PROTEKSI 2: Validasi ganda di sisi backend saat proses submit data
        $pembayaran = $pembayaranModel->where('ID_RESERVASI', $idReservasi)->first();
        if ($pembayaran && trim(strtolower($pembayaran['STATUS_BAYAR'])) === 'lunas') {
            session()->setFlashdata('error', 'Gagal menyimpan perubahan! Transaksi keuangan untuk rekam medis ini sudah dikunci karena sudah dibayar.');
            return redirect()->to(base_url('dokter/riwayat-medis'));
        }

        // Ambil model pembantu lainnya
        $rekamTindakanModel = new RekamTindakanModel();
        $detailResepModel = new DetailResepModel();
        $obatModel = new ObatModel();

        // Ambil post input data medis
        $this->rekamMedisModel->update($idRekam, [
            'ANAMNESIS' => $this->request->getPost('anamnesis') ?? '-',
            'DIAGNOSIS' => $this->request->getPost('diagnosa') ?? $this->request->getPost('diagnosis'),
            'TERAPI' => $this->request->getPost('terapi') ?? '-',
            'CATATAN' => $this->request->getPost('catatan') ?? '-'
        ]);

        // --- MANAJEMEN ULANG TINDAKAN ---
        $rekamTindakanModel->where('ID_REKAM', $idRekam)->delete();

        $arrIdTindakan = $this->request->getPost('id_tindakan');
        $arrTindakanQty = $this->request->getPost('tindakan_qty');
        $arrTindakanHarga = $this->request->getPost('tindakan_harga');

        $subtotalTindakan = 0;
        if (!empty($arrIdTindakan)) {
            foreach ($arrIdTindakan as $key => $idTindakan) {
                if (!empty($idTindakan)) {
                    $rekamTindakanModel->insert([
                        'ID_TINDAKAN' => $idTindakan,
                        'ID_REKAM' => $idRekam,
                        'HARGA_SAAT_ITU' => (int) $arrTindakanHarga[$key],
                        'JUMLAH_TINDAKAN' => (int) $arrTindakanQty[$key]
                    ]);
                    $subtotalTindakan += ((int) $arrTindakanHarga[$key] * (int) $arrTindakanQty[$key]);
                }
            }
        }

        // --- MANAJEMEN ULANG OBAT & RESTOCK ---
        $resepHeader = $this->resepObatModel->where('ID_REKAM', $idRekam)->first();
        if ($resepHeader) {
            $oldDetails = $detailResepModel->where('ID_RESEP_OBAT', $resepHeader['ID_RESEP_OBAT'])->findAll();
            foreach ($oldDetails as $old) {
                $obatModel->where('ID_OBAT', $old['ID_OBAT'])
                    ->set('STOK', "STOK + " . (int) $old['JUMLAH_RESEP'], false)
                    ->update();
            }
            $detailResepModel->where('ID_RESEP_OBAT', $resepHeader['ID_RESEP_OBAT'])->delete();
            $idResep = $resepHeader['ID_RESEP_OBAT'];
        } else {
            $reservasiAsal = $this->reservasiModel->find($idReservasi);
            $this->resepObatModel->insert([
                'ID_REKAM' => $idRekam,
                'ID_PARAMEDIS' => $reservasiAsal['ID_PARAMEDIS'] ?? 1,
                'TANGGAL_RESEP' => date('Y-m-d')
            ]);
            $idResep = $this->resepObatModel->getInsertID();
        }

        $arrIdObat = $this->request->getPost('id_obat');
        $arrObatQty = $this->request->getPost('obat_qty');
        $arrObatHarga = $this->request->getPost('obat_harga');
        $arrObatDosis = $this->request->getPost('obat_dosis');
        $arrObatAturan = $this->request->getPost('obat_aturan');

        $subtotalObat = 0;
        if (!empty($arrIdObat)) {
            foreach ($arrIdObat as $key => $idObat) {
                if (!empty($idObat)) {
                    $detailResepModel->insert([
                        'ID_RESEP_OBAT' => $idResep,
                        'ID_OBAT' => $idObat,
                        'DOSIS' => $arrObatDosis[$key],
                        'ATURAN_PAKAI' => $arrObatAturan[$key],
                        'HARGA_TERCATAT' => (int) $arrObatHarga[$key],
                        'JUMLAH_RESEP' => (int) $arrObatQty[$key]
                    ]);

                    $obatModel->where('ID_OBAT', $idObat)
                        ->set('STOK', "STOK - " . (int) $arrObatQty[$key], false)
                        ->update();

                    $subtotalObat += ((int) $arrObatHarga[$key] * (int) $arrObatQty[$key]);
                }
            }
        }

        // --- RE-KALKULASI FINANSIAL INVOICE KASIR ---
        if ($pembayaran) {
            $biayaKonsul = (int) $pembayaran['BIAYA_KONSULTASI'];
            $totalTagihanBaru = $biayaKonsul + $subtotalTindakan + $subtotalObat;

            $pembayaranModel->update($pembayaran['ID_PEMBAYARAN'], [
                'SUBTOTAL_TINDAKAN' => $subtotalTindakan,
                'SUBTOTAL_OBAT' => $subtotalObat,
                'TOTAL_TAGIHAN' => $totalTagihanBaru
            ]);
        }

        session()->setFlashdata('success', 'Perubahan berkas rekam medis dan penyesuaian logistik obat berhasil diperbarui.');
        return redirect()->to(base_url('dokter/riwayat-medis'));
    }

    // =========================================================================
    // REVISI UTAMA: MODUL MANAGEMENT JADWAL & KUOTA PRAKTIK (CRUD MANDIRI)
    // =========================================================================

    // 1. READ: List Jadwal Praktik Dokter Terkait
    public function jadwal()
    {
        $idDokter = $this->getLoggedInDokterId();
        $data['my_jadwal'] = $this->jadwalDokterModel->where('ID_DOKTER', $idDokter)->findAll();
        return view('dokter/jadwal/index', $data);
    }

    // 2. CREATE (Form): Tampilan Tambah Jadwal Praktik
    public function tambahJadwal()
    {
        return view('dokter/jadwal/tambah');
    }

    // 3. CREATE (Proses): Simpan Jadwal & Kuota Pasien Baru
    public function simpanJadwal()
    {
        $idDokter = $this->getLoggedInDokterId();

        $this->jadwalDokterModel->insert([
            'ID_DOKTER' => $idDokter,
            'HARI' => $this->request->getPost('hari'),
            'JAM_MULAI' => $this->request->getPost('jam_mulai'),
            'JAM_SELESAI' => $this->request->getPost('jam_selesai'),
            'KUOTA' => (int) $this->request->getPost('kuota') // Mampu menangkap kuota maksimal
        ]);

        session()->setFlashdata('success', 'Slot jadwal praktik dan kuota baru berhasil diaktifkan.');
        return redirect()->to(base_url('dokter/jadwal'));
    }

    // 4. UPDATE (Form): Tampilan Edit Jadwal & Kuota Praktik
    public function editJadwal($idJadwal)
    {
        $idDokter = $this->getLoggedInDokterId();

        // Proteksi: Ambil data jadwal hanya jika murni miliknya sendiri
        $jadwal = $this->jadwalDokterModel->where(['ID_JADWAL' => $idJadwal, 'ID_DOKTER' => $idDokter])->first();

        if (!$jadwal) {
            session()->setFlashdata('error', 'Akses ditolak atau data jadwal tidak ditemukan.');
            return redirect()->to(base_url('dokter/jadwal'));
        }

        $data['jadwal'] = $jadwal;
        return view('dokter/jadwal/edit', $data);
    }

    // 5. UPDATE (Proses): Perbarui Data Jadwal Praktik & Kuota
    public function updateJadwal($idJadwal)
    {
        $idDokter = $this->getLoggedInDokterId();

        // Verifikasi kepemilikan sebelum melakukan pembaruan data
        $jadwalExist = $this->jadwalDokterModel->where(['ID_JADWAL' => $idJadwal, 'ID_DOKTER' => $idDokter])->first();

        if (!$jadwalExist) {
            session()->setFlashdata('error', 'Gagal memperbarui, data tidak valid.');
            return redirect()->to(base_url('dokter/jadwal'));
        }

        $this->jadwalDokterModel->update($idJadwal, [
            'HARI' => $this->request->getPost('hari'),
            'JAM_MULAI' => $this->request->getPost('jam_mulai'),
            'JAM_SELESAI' => $this->request->getPost('jam_selesai'),
            'KUOTA' => (int) $this->request->getPost('kuota') // Pembaruan kapasitas kuota
        ]);

        session()->setFlashdata('success', 'Perubahan slot jadwal dan kuota praktik berhasil disimpan.');
        return redirect()->to(base_url('dokter/jadwal'));
    }

    // 6. DELETE: Nonaktifkan Slot Jadwal Praktik
    public function hapusJadwal($idJadwal)
    {
        $idDokter = $this->getLoggedInDokterId();

        // Proteksi: Pastikan jadwal yang dihapus murni miliknya sendiri
        $this->jadwalDokterModel->where(['ID_JADWAL' => $idJadwal, 'ID_DOKTER' => $idDokter])->delete();

        session()->setFlashdata('success', 'Slot jadwal berhasil dinonaktifkan.');
        return redirect()->to(base_url('dokter/jadwal'));
    }
}