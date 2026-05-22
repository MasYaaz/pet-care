<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-4">
    <h1 class="text-xl font-extrabold text-slate-950">Histori Transaksi Kasir</h1>
    <div class="bg-white border rounded-2xl overflow-hidden shadow-xs">
        <table class="w-full text-left border-collapse text-xs">
            <thead class="bg-slate-50 text-slate-500 font-bold">
                <tr>
                    <th class="p-4">Kode</th>
                    <th class="p-4">Anabul</th>
                    <th class="p-4">Metode</th>
                    <th class="p-4 text-right">Total Tagihan</th>
                    <th class="p-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y font-medium text-slate-700">
                <?php if(!empty($riwayat_pembayaran)): foreach($riwayat_pembayaran as $rp): ?>
                    <tr>
                        <td class="p-4 font-mono font-bold"><?= $rp['KODE_TRANSAKSI'] ?></td>
                        <td class="p-4">🐾 <?= $rp['NAMA_HEWAN'] ?></td>
                        <td class="p-4"><?= $rp['NAMA_METODE_BAYAR'] ?></td>
                        <td class="p-4 text-right font-bold text-slate-900">Rp <?= number_format($rp['TOTAL_TAGIHAN'], 0, ',', '.') ?></td>
                        <td class="p-4 text-center">
                            <span class="px-2 py-1 rounded-md text-[10px] font-bold <?= $rp['STATUS_BAYAR'] == 'Lunas' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' ?>">
                                <?= $rp['STATUS_BAYAR'] ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" class="p-4 text-center text-slate-400">Belum ada invoice terekam.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>