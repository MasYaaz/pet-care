<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-4">
    <h1 class="text-xl font-extrabold text-slate-950">Buku Riwayat Klinis Anabul</h1>
    <div class="space-y-4">
        <?php if (!empty($riwayat_medis)):
            foreach ($riwayat_medis as $rm): ?>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
                    <div class="flex justify-between border-b pb-2 text-xs text-slate-400">
                        <span>🐾 <strong class="text-slate-800">
                                <?= $rm['NAMA_HEWAN'] ?>
                            </strong> (
                            <?= $rm['JENIS_HEWAN'] ?>)
                        </span>
                        <span>📅
                            <?= date('d M Y H:i', strtotime($rm['TANGGAL_PERIKSA'])) ?>
                        </span>
                    </div>
                    <div class="mt-3 text-xs space-y-1">
                        <p class="text-slate-400">Dokter Penanggung Jawab: <span class="text-slate-800 font-semibold">
                                <?= $rm['NAMA_DOKTER'] ?>
                            </span></p>
                        <p class="font-bold text-slate-900 mt-2">Diagnosis Medis:</p>
                        <p class="p-3 bg-slate-50 border rounded-xl text-slate-700 font-medium">
                            <?= esc($rm['DIAGNOSIS']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; else: ?>
            <p class="text-xs text-slate-400 text-center py-6">Belum ada catatan rekam medis terdaftar.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>