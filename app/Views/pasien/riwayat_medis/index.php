<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Riwayat Medis Anabul<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col gap-2">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Buku Riwayat Klinis Anabul</h1>
            <p class="text-slate-400 text-xs mt-1">Rekam jejak pemeriksaan medis, hasil diagnosis, dan tindakan berkala
                peliharaan Anda.</p>
        </div>
    </div>

    <div
        class="space-y-5 relative before:absolute before:inset-0 before:left-6 before:w-0.5 before:bg-slate-100 before:my-3">
        <?php if (!empty($riwayat_medis)):
            foreach ($riwayat_medis as $rm): ?>
                <div class="relative pl-12 group">

                    <div
                        class="absolute left-4 top-5 w-4 h-4 rounded-full bg-white border-4 border-indigo-500 group-hover:border-indigo-600 shadow-xs transition-colors z-10">
                    </div>

                    <div
                        class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs hover:border-slate-200 transition-all">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-50 pb-4 text-xs font-semibold text-slate-400">
                            <div class="flex items-center gap-2">
                                <span
                                    class="bg-indigo-50 text-indigo-700 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wide">
                                    🐾 <?= esc($rm['NAMA_HEWAN']) ?>
                                </span>
                                <span class="text-slate-300">/</span>
                                <span class="text-slate-500 font-bold lowercase"><?= esc($rm['JENIS_HEWAN']) ?></span>
                            </div>
                            <div class="flex items-center gap-1 text-slate-500 font-medium">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span><?= date('d M Y — H:i', strtotime($rm['TANGGAL_PERIKSA'])) ?> WIB</span>
                            </div>
                        </div>

                        <div class="mt-4 space-y-4 text-xs">
                            <div class="flex items-center gap-3 bg-slate-50 border border-slate-100/50 p-3 rounded-xl">
                                <div
                                    class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white shrink-0 shadow-sm shadow-indigo-100">
                                    <i data-lucide="stethoscope" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wide font-bold">Dokter Pemeriksa</p>
                                    <p class="text-slate-800 font-bold text-xs mt-0.5"><?= esc($rm['NAMA_DOKTER']) ?></p>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold text-slate-500 uppercase tracking-wide flex items-center gap-1.5">
                                    <i data-lucide="activity" class="w-3.5 h-3.5 text-slate-400"></i>
                                    Hasil Diagnosis Klinis
                                </label>
                                <div
                                    class="p-4 bg-white border border-slate-200/80 rounded-2xl text-slate-800 font-semibold text-xs leading-relaxed shadow-3xs">
                                    <?= esc($rm['DIAGNOSIS']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
            <div class="bg-white border border-slate-100 rounded-3xl p-12 text-center text-slate-400 shadow-xs">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <div
                        class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100 text-slate-400">
                        <i data-lucide="heart-pulse" class="w-5 h-5 text-indigo-500"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-500">Belum Ada Catatan Klinis</p>
                    <p class="text-[11px] text-slate-400 font-normal">Riwayat rekam medis anabul Anda akan terbit di sini
                        setelah diperiksa dokter.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>