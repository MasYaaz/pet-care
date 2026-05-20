<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Jadwal Praktik Saya
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Pengaturan Jadwal Praktik</h1>
            <p class="text-slate-400 text-xs mt-1">Kelola hari dan alokasi shift kerja Anda secara mandiri untuk booking
                online pasien.</p>
        </div>
        <a href="<?= base_url('dokter/jadwal/tambah') ?>"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm uppercase tracking-wider">
            <i data-lucide="calendar-plus" class="w-4 h-4"></i> Tambah Hari Praktik
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div
            class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-emerald-800 text-xs font-semibold">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
            <span>
                <?= session()->getFlashdata('success') ?>
            </span>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php if (empty($my_jadwal)): ?>
            <div
                class="col-span-full bg-white border border-slate-100 rounded-3xl p-12 text-center text-xs text-slate-400 font-medium">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <i data-lucide="calendar-x" class="w-10 h-10 text-slate-300"></i>
                    <p>Anda belum mengaktifkan hari operasional praktik.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($my_jadwal as $j): ?>
                <div
                    class="bg-white border border-slate-100 rounded-3xl p-6 space-y-4 hover:border-indigo-200 transition-all flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span
                                class="text-xs font-black px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-xl uppercase tracking-wide">
                                📅 Hari
                                <?= esc($j['HARI']) ?>
                            </span>
                        </div>
                        <div class="space-y-1 text-xs text-slate-500 font-medium">
                            <p class="flex items-center gap-1.5"><i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                                Jam Masuk: <b class="text-slate-800 font-bold">
                                    <?= date('H:i', strtotime($j['JAM_MULAI'])) ?> WIB
                                </b></p>
                            <p class="flex items-center gap-1.5"><i data-lucide="log-out"
                                    class="w-3.5 h-3.5 text-slate-400"></i> Selesai Shift: <b class="text-slate-800 font-bold">
                                    <?= date('H:i', strtotime($j['JAM_SELESAI'])) ?> WIB
                                </b></p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-50 flex justify-end">
                        <a href="<?= base_url('dokter/jadwal/hapus/' . $j['ID_JADWAL']) ?>"
                            onclick="return confirm('Apakah Anda ingin menonaktifkan slot jadwal hari ini?')"
                            class="text-[11px] font-bold text-slate-400 hover:text-rose-600 flex items-center gap-1 transition-colors">
                            <i data-lucide="calendar-x" class="w-3.5 h-3.5"></i> Tutup Shift
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>