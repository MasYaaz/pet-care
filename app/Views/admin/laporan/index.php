<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Laporan Analisis Klinik<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- TOP HEADER HERO -->
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Pusat Data & Analisis Eksekutif</h1>
            <p class="text-slate-400 text-xs mt-1">Laporan performa berkala finansial, penanganan medis, dan log
                aktivitas kassa klinik.</p>
        </div>
        <div class="flex items-center gap-2">
            <div
                class="text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-xl flex items-center gap-2">
                <i data-lucide="trending-up" class="w-4 h-4"></i> Real-time Analytics
            </div>
            <button onclick="exportLaporanKeExcel()"
                class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 px-4 py-2 rounded-xl flex items-center gap-2 transition-all cursor-pointer">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Export ke Excel
            </button>
        </div>
    </div>

    <!-- METRIK RINGKASAN UTAMA (4 GRID BOX) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- OMZET BERSIH -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-3xs flex items-center gap-4">
            <div
                class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 shrink-0 border border-emerald-100/50">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Omzet Bersih
                    (Lunas)</span>
                <span class="text-sm font-black text-slate-900 font-mono mt-0.5 block">Rp
                    <?= number_format($total_omzet, 0, ',', '.') ?></span>
            </div>
        </div>

        <!-- PIUTANG TERPENDAM -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-3xs flex items-center gap-4">
            <div
                class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 shrink-0 border border-amber-100/50">
                <i data-lucide="landmark" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Piutang Pending</span>
                <span class="text-sm font-black text-slate-900 font-mono mt-0.5 block">Rp
                    <?= number_format($piutang_berjalan, 0, ',', '.') ?></span>
            </div>
        </div>

        <!-- TOTAL REKAM DATA MEDIS -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-3xs flex items-center gap-4">
            <div
                class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shrink-0 border border-indigo-100/50">
                <i data-lucide="folder-heart" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Kasus Ditangani</span>
                <span class="text-sm font-black text-slate-900 font-mono mt-0.5 block"><?= $total_periksa ?> Sesi
                    Periksa</span>
            </div>
        </div>

        <!-- BASE TOTAL PASIEN TERDAFTAR -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-3xs flex items-center gap-4">
            <div
                class="w-10 h-10 bg-sky-50 rounded-xl flex items-center justify-center text-sky-600 shrink-0 border border-sky-100/50">
                <i data-lucide="paw-print" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Populasi
                    Anabul</span>
                <span class="text-sm font-black text-slate-900 font-mono mt-0.5 block"><?= $total_pasien ?> Ekor
                    Pasien</span>
            </div>
        </div>
    </div>

    <!-- SEKTOR ANALISIS GRAFIK & LEAGUE TABLE -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- ALLOKASI FINANSIAL KLINIK (BAR CHART MINIMALIS) -->
        <div
            class="lg:col-span-7 bg-white p-6 rounded-3xl border border-slate-100 shadow-3xs space-y-5 flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-indigo-600"></i> Alokasi Struktur Pendapatan Klinik
                </h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Proporsi pembagian nominal masuk dari total invoice yang
                    lunas.</p>
            </div>

            <?php
            $grandTotal = $omzet_konsul + $omzet_tindakan + $omzet_obat;
            $pctKonsul = $grandTotal > 0 ? round(($omzet_konsul / $grandTotal) * 100, 1) : 0;
            $pctTindakan = $grandTotal > 0 ? round(($omzet_tindakan / $grandTotal) * 100, 1) : 0;
            $pctObat = $grandTotal > 0 ? round(($omzet_obat / $grandTotal) * 100, 1) : 0;
            ?>

            <div class="space-y-4 py-2">
                <!-- Bar Jasa Dokter -->
                <div class="space-y-1">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-600">Jasa Konsultasi Umum</span>
                        <span class="text-slate-900 font-mono font-bold">Rp
                            <?= number_format($omzet_konsul, 0, ',', '.') ?> (<?= $pctKonsul ?>%)</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full" style="width: <?= $pctKonsul ?>%"></div>
                    </div>
                </div>

                <!-- Bar Tindakan -->
                <div class="space-y-1">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-600">Tindakan Operasional Medis</span>
                        <span class="text-slate-900 font-mono font-bold">Rp
                            <?= number_format($omzet_tindakan, 0, ',', '.') ?> (<?= $pctTindakan ?>%)</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: <?= $pctTindakan ?>%"></div>
                    </div>
                </div>

                <!-- Bar Obat -->
                <div class="space-y-1">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-600">Farmasi, Obat & Alkes</span>
                        <span class="text-slate-900 font-mono font-bold">Rp
                            <?= number_format($omzet_obat, 0, ',', '.') ?> (<?= $pctObat ?>%)</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-sky-500 h-full rounded-full" style="width: <?= $pctObat ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LIGA DOKTER TERGANCANG -->
        <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-100 shadow-3xs space-y-4">
            <div>
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="award" class="w-4 h-4 text-indigo-600"></i> Produktivitas Dokter (Top 5)
                </h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Peringkat dokter berdasarkan kuantitas penanganan kasus
                    klinis.</p>
            </div>

            <div class="divide-y divide-slate-50 text-xs font-semibold">
                <?php if (!empty($performa_dokter)):
                    foreach ($performa_dokter as $idx => $doc): ?>
                        <div class="flex justify-between items-center py-2.5">
                            <div class="flex items-center gap-2.5">
                                <span
                                    class="w-5 h-5 rounded-md flex items-center justify-center font-mono font-black text-[10px] <?= $idx == 0 ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-500' ?>">
                                    <?= $idx + 1 ?>
                                </span>
                                <span class="text-slate-800 font-bold"><?= esc($doc['NAMA_DOKTER']) ?></span>
                            </div>
                            <span
                                class="text-indigo-600 bg-indigo-50 font-bold px-2 py-0.5 rounded-md text-[10px]"><?= $doc['total_penanganan'] ?>
                                Kasus</span>
                        </div>
                    <?php endforeach; else: ?>
                    <p class="text-center text-slate-400 py-6 font-medium">Belum ada rekam medis terbit.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- LOG HISTORI ARUS KAS MASUK TERAKHIR (10 INVOICE TERKINI) -->
    <div class="bg-white border border-slate-100 rounded-3xl shadow-3xs overflow-hidden">
        <div class="p-5 border-b border-slate-50 bg-slate-50/20">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="receipt-text" class="w-4 h-4 text-slate-400"></i> Audit Arus Transaksi Terkini
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table id="tabel-keuangan-admin" class="w-full text-left border-collapse text-xs">
                <thead
                    class="bg-slate-50/60 font-bold border-b border-slate-100 text-[10px] text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4 pl-6">Kode Transaksi</th>
                        <th class="p-4">Pasien</th>
                        <th class="p-4 text-right">Total Billing</th>
                        <th class="p-4 text-center">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-semibold text-slate-700">
                    <?php if (!empty($log_transaksi)):
                        foreach ($log_transaksi as $tx): ?>
                            <tr class="hover:bg-slate-50/20 transition-colors">
                                <td class="p-4 pl-6 font-mono font-bold text-slate-900"><?= esc($tx['KODE_TRANSAKSI']) ?></td>
                                <td class="p-4 text-slate-600">🐾 Anabul <?= esc($tx['NAMA_HEWAN']) ?></td>
                                <td class="p-4 text-right font-black text-slate-900 font-mono">Rp
                                    <?= number_format($tx['TOTAL_TAGIHAN'], 0, ',', '.') ?>
                                </td>
                                <td class="p-4 text-center">
                                    <?php if (strtolower(trim($tx['STATUS_BAYAR'])) === 'lunas'): ?>
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Lunas</span>
                                    <?php else: ?>
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="4" class="p-12 text-center text-slate-400 font-medium">Belum ada mutasi keuangan
                                masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function exportLaporanKeExcel() {
        window.location.href = "<?= base_url('admin/laporan/exportExcel') ?>";
    }
</script>
<?= $this->endSection() ?>