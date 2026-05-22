<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Jadwal Praktik<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-5xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-100">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Agenda Operasional Praktik</h1>
            <p class="text-slate-400 text-xs mt-1">Kelola hari kunjungan, kapasitas tampung kuota, dan waktu pelayanan
                mandiri Anda.</p>
        </div>
        <a href="<?= base_url('dokter/jadwal/tambah') ?>"
            class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-5 py-3 rounded-xl transition-all shadow-sm uppercase tracking-wider flex items-center justify-center gap-1.5 cursor-pointer h-fit shrink-0">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Slot Baru
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div
            class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div
            class="p-4 bg-rose-50 border border-rose-100 text-rose-800 text-xs font-semibold rounded-xl flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($my_jadwal)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($my_jadwal as $j): ?>
                <div
                    class="bg-white border border-slate-100 shadow-xs rounded-2xl p-6 flex flex-col justify-between hover:border-slate-200 transition-all duration-300">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <span
                                class="text-xs font-black text-slate-900 bg-slate-100 px-3 py-1.5 rounded-lg uppercase tracking-wide">
                                <i data-lucide="calendar" class="w-full h-full"></i> <?= esc($j['HARI']) ?>
                            </span>
                            <div class="flex items-center gap-1">
                                <a href="<?= base_url('dokter/jadwal/edit/' . $j['ID_JADWAL']) ?>"
                                    class="p-1.5 text-slate-400 hover:text-indigo-600 transition-colors rounded-md hover:bg-slate-50"
                                    title="Ubah Sesi">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <a href="<?= base_url('dokter/jadwal/hapus/' . $j['ID_JADWAL']) ?>"
                                    onclick="return confirm('Apakah Anda yakin ingin menonaktifkan slot operasional hari <?= $j['HARI'] ?>?')"
                                    class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors rounded-md hover:bg-slate-50"
                                    title="Hapus Slot">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>

                        <div class="space-y-2 mt-4 text-xs font-medium text-slate-600">
                            <div class="flex items-center gap-2">
                                <i data-lucide="clock" class="w-4 h-4 text-slate-400 stroke-[1.5]"></i>
                                <span>Jam Praktik: <strong
                                        class="text-slate-800 font-semibold"><?= substr($j['JAM_MULAI'], 0, 5) ?> -
                                        <?= substr($j['JAM_SELESAI'], 0, 5) ?> WIB</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="users" class="w-4 h-4 text-slate-400 stroke-[1.5]"></i>
                                <span>Kapasitas Sesi: <strong class="text-indigo-600 font-bold"><?= esc($j['KUOTA']) ?>
                                        Pasien</strong></span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-5 pt-3 border-t border-slate-50 flex items-center gap-1.5 text-[10px] text-emerald-600 font-bold uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Terdeteksi Oleh Sistem Online
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div
            class="bg-white border border-slate-100 rounded-2xl p-12 text-center max-w-md mx-auto space-y-4 shadow-2xs mt-6">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto">
                <i data-lucide="calendar-x" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Belum Ada Jadwal Aktif</h3>
                <p class="text-slate-400 text-xs mt-1">Anda tidak akan terdeteksi di portal pendaftaran online klien sebelum
                    menambahkan hari kerja.</p>
            </div>
            <a href="<?= base_url('dokter/jadwal/tambah') ?>"
                class="inline-flex items-center gap-1 bg-indigo-600 text-white font-bold text-xs px-5 py-2.5 rounded-xl uppercase tracking-wide hover:bg-indigo-700 transition-colors">
                Buka Slot Sekarang
            </a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>