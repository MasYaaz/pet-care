<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Riwayat Pembayaran Medis<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col gap-2">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Histori Transaksi Kasir</h1>
            <p class="text-slate-400 text-xs mt-1">Pantau seluruh rekaman tagihan nota pembayaran klinik dan status
                faktur billing Anda.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead
                    class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="p-4 pl-6">Kode Transaksi</th>
                        <th class="p-4">Nama Anabul</th>
                        <th class="p-4">Metode Bayar</th>
                        <th class="p-4 text-right">Total Tagihan</th>
                        <th class="p-4 text-center pr-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-semibold text-slate-700">
                    <?php if (!empty($riwayat_pembayaran)):
                        foreach ($riwayat_pembayaran as $rp): ?>
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="p-4 pl-6 font-mono font-bold text-indigo-600">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="receipt" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span><?= esc($rp['KODE_TRANSAKSI']) ?></span>
                                    </div>
                                </td>

                                <td class="p-4 text-slate-900">
                                    <div class="flex items-center gap-1.5 font-bold">
                                        <span class="text-base leading-none">🐾</span>
                                        <span><?= esc($rp['NAMA_HEWAN']) ?></span>
                                    </div>
                                </td>

                                <td class="p-4 text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="credit-card" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span><?= esc($rp['NAMA_METODE_BAYAR'] ?? 'Belum Ditentukan') ?></span>
                                    </div>
                                </td>

                                <td class="p-4 text-right font-extrabold text-slate-950 text-sm">
                                    Rp <?= number_format($rp['TOTAL_TAGIHAN'], 0, ',', '.') ?>
                                </td>

                                <td class="p-4 text-center pr-6">
                                    <?php if (trim(strtolower($rp['STATUS_BAYAR'])) === 'lunas'): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-100/80 uppercase tracking-wide">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Lunas
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-100/80 uppercase tracking-wide">
                                            <span class="w-1 h-1 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <div
                                        class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100 text-slate-400">
                                        <i data-lucide="file-text" class="w-5 h-5"></i>
                                    </div>
                                    <p class="text-xs font-bold text-slate-500">Belum Ada Rekaman Invoice</p>
                                    <p class="text-[11px] text-slate-400 font-normal">Riwayat nota klinis pembayaran Anda
                                        akan terekam otomatis di sini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>