<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Laporan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. KONTROLLER RINGKASAN EKSEKUTIF (TOTAL OMZET & VOLUME)
        $data['total_omzet'] = $db->table('PEMBAYARAN')
            ->where('STATUS_BAYAR', 'Lunas')
            ->selectSum('TOTAL_TAGIHAN')
            ->get()->getRow()->TOTAL_TAGIHAN ?? 0;

        $data['piutang_berjalan'] = $db->table('PEMBAYARAN')
            ->where('STATUS_BAYAR', 'Belum Bayar')
            ->selectSum('TOTAL_TAGIHAN')
            ->get()->getRow()->TOTAL_TAGIHAN ?? 0;

        $data['total_pasien'] = $db->table('PASIEN')->countAllResults();
        $data['total_periksa'] = $db->table('REKAM_MEDIS')->countAllResults();

        // 2. METRIK DISTRIBUSI PENDAPATAN (JASA VS TINDAKAN VS OBAT)
        $pembayaranLunas = $db->table('PEMBAYARAN')->where('STATUS_BAYAR', 'Lunas');
        $data['omzet_konsul'] = (clone $pembayaranLunas)->selectSum('BIAYA_KONSULTASI')->get()->getRow()->BIAYA_KONSULTASI ?? 0;
        $data['omzet_tindakan'] = (clone $pembayaranLunas)->selectSum('SUBTOTAL_TINDAKAN')->get()->getRow()->SUBTOTAL_TINDAKAN ?? 0;
        $data['omzet_obat'] = (clone $pembayaranLunas)->selectSum('SUBTOTAL_OBAT')->get()->getRow()->SUBTOTAL_OBAT ?? 0;

        // 3. STATISTIK POPULARITAS METODE PEMBAYARAN
        $data['metode_stats'] = $db->table('PEMBAYARAN')
            ->select('STATUS_BAYAR, COUNT(ID_PEMBAYARAN) as jumlah')
            ->groupBy('STATUS_BAYAR')
            ->get()->getResultArray();

        // 4. LIGA PERFORMA DOKTER (Berdasarkan Jumlah Menangani Rekam Medis)
        $data['performa_dokter'] = $db->table('REKAM_MEDIS')
            ->select('PENGGUNA.NAMA_LENGKAP AS NAMA_DOKTER, COUNT(REKAM_MEDIS.ID_REKAM) as total_penanganan')
            ->join('DOKTER', 'DOKTER.ID_DOKTER = REKAM_MEDIS.ID_DOKTER')
            ->join('PENGGUNA', 'PENGGUNA.ID_PENGGUNA = DOKTER.ID_PENGGUNA') // Tambahkan join ini untuk mengambil nama asli dokter
            ->groupBy('REKAM_MEDIS.ID_DOKTER, PENGGUNA.NAMA_LENGKAP')
            ->orderBy('total_penanganan', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // 5. HISTORI LOG TRANSAKSI FINANSIAL TERAKHIR
        $data['log_transaksi'] = $db->table('PEMBAYARAN')
            ->select('PEMBAYARAN.*, PASIEN.NAMA_HEWAN')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = PEMBAYARAN.ID_PASIEN')
            ->orderBy('PEMBAYARAN.ID_PEMBAYARAN', 'DESC')
            ->limit(10)
            ->get()->getResultArray();

        return view('admin/laporan/index', $data);
    }
    public function exportExcel()
    {
        $db = \Config\Database::connect();

        // 1. AMBIL DATA FINANSIAL (Sama seperti query dashboard)
        $log_transaksi = $db->table('PEMBAYARAN')
            ->select('PEMBAYARAN.*, PASIEN.NAMA_HEWAN')
            ->join('PASIEN', 'PASIEN.ID_PASIEN = PEMBAYARAN.ID_PASIEN')
            ->orderBy('PEMBAYARAN.ID_PEMBAYARAN', 'DESC')
            ->get()->getResultArray();

        // Ambil akumulasi data untuk ringkasan di atas laporan
        $total_omzet = $db->table('PEMBAYARAN')->where('STATUS_BAYAR', 'Lunas')->selectSum('TOTAL_TAGIHAN')->get()->getRow()->TOTAL_TAGIHAN ?? 0;
        $piutang_berjalan = $db->table('PEMBAYARAN')->where('STATUS_BAYAR', 'Belum Bayar')->selectSum('TOTAL_TAGIHAN')->get()->getRow()->TOTAL_TAGIHAN ?? 0;

        // 2. SET BINDING HEADER EXCEL NATIVE (Gunakan ekstensi .xls)
        $filename = 'Laporan_Eksekutif_Finansial_PetCare_' . date('Y-m-d') . '.xls';

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        // 3. RENDER STRUKTUR LAPORAN BERGAYA HTML INTERN EXCEL
        echo "
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
            <style>
                /* Styling khusus agar dibaca rapi oleh Excel */
                .title { font-family: 'Arial'; font-size: 16px; font-weight: bold; color: #1e293b; }
                .subtitle { font-family: 'Arial'; font-size: 10px; color: #64748b; }
                .meta-label { font-family: 'Arial'; font-size: 11px; font-weight: bold; }
                .meta-value { font-family: 'Arial'; font-size: 11px; }
                
                table.report-table { border-collapse: collapse; font-family: 'Arial'; font-size: 11px; }
                table.report-table th { background-color: #6366f1; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #cbd5e1; padding: 6px; }
                table.report-table td { border: 1px solid #cbd5e1; padding: 5px; }
                
                /* Format paksa excel agar mendeteksi angka sebagai IDR currency tanpa text mask */
                .num-format { mso-number-format:'\\#\\,\\#\\#0'; text-align: right; }
                .text-center { text-align: center; }
                .font-bold { font-weight: bold; }
            </style>
        </head>
        <body>
            <table>
                <tr>
                    <td colspan='4' class='title'>LAPORAN EKSEKUTIF FINANSIAL CLINIC</td>
                </tr>
                <tr>
                    <td colspan='4' class='subtitle'>Pusat Struktur Data & Transaksi Billing Pasien PetCare</td>
                </tr>
                <tr>
                    <td colspan='4' class='subtitle'>Dicetak pada: " . date('d F Y, H:i') . " WIB</td>
                </tr>
                <tr><td></td></tr> </table>

            <table border='1' style='border-collapse:collapse; border-color:#e2e8f0; font-family:Arial; font-size:11px;'>
                <tr style='background-color:#f8fafc;'>
                    <td style='padding:5px;'><b>Total Omzet (Lunas)</b></td>
                    <td class='num-format' style='padding:5px; color:#15803d; font-weight:bold;'>$total_omzet</td>
                    <td style='padding:5px;'><b>Total Piutang (Pending)</b></td>
                    <td class='num-format' style='padding:5px; color:#b45309; font-weight:bold;'>$piutang_berjalan</td>
                </tr>
            </table>

            <table><tr><td></td></tr></table> <table class='report-table'>
                <thead>
                    <tr>
                        <th style='width: 150px;'>KODE TRANSAKSI</th>
                        <th style='width: 180px;'>NAMA PASIEN ANABUL</th>
                        <th style='width: 140px;'>TOTAL BILLING LAYANAN</th>
                        <th style='width: 120px;'>STATUS VERIFIKASI</th>
                    </tr>
                </thead>
                <tbody>";

        if (!empty($log_transaksi)) {
            foreach ($log_transaksi as $tx) {
                $kode = $tx['KODE_TRANSAKSI'];
                $pasien = 'Anabul ' . $tx['NAMA_HEWAN'];
                $total = $tx['TOTAL_TAGIHAN'];
                $status = strtoupper(trim($tx['STATUS_BAYAR']));
                $colorStatus = ($status === 'LUNAS') ? '#10b981' : '#f59e0b';

                echo "
                <tr>
                    <td class='text-center' style='font-family:monospace;'>$kode</td>
                    <td>$pasien</td>
                    <td class='num-format'>$total</td>
                    <td class='text-center font-bold' style='color:$colorStatus;'>$status</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center' style='color:#94a3b8;'>Belum ada rekaman data transaksi kasir.</td></tr>";
        }

        echo "
                </tbody>
            </table>
        </body>
        </html>";
        exit;
    }
}