<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Profil Anabulku
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Keluarga Hewan Peliharaanku</h1>
            <p class="text-slate-400 text-xs mt-1">Daftar kartu identitas digital dan rekam data anabul kesayangan Anda.
            </p>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="<?= base_url('pasien/anabul/tambah') ?>"
                class="inline-flex items-center justify-center gap-2 bg-slate-950 hover:bg-slate-800 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm uppercase tracking-wider w-full sm:w-auto">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Hewan
            </a>
            <a href="<?= base_url('pasien/booking') ?>"
                class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm hover:shadow-indigo-100 uppercase tracking-wider w-full sm:w-auto">
                <i data-lucide="calendar" class="w-4 h-4"></i> Booking Jadwal
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div
            class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-emerald-800 text-xs font-semibold mt-4">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
            <span><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php if (empty($my_anabul)): ?>
            <div
                class="col-span-full bg-white border border-slate-100 rounded-3xl p-12 text-center text-xs text-slate-400 font-medium">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <i data-lucide="paw-print" class="w-10 h-10 text-slate-300"></i>
                    <p>Belum ada data hewan peliharaan yang terikat di akun Anda.</p>
                    <p class="text-[11px] text-slate-400 max-w-xs mx-auto">Silakan hubungi staf paramedis di loket klinik
                        untuk mendaftarkan atau mengaitkan anabul baru Anda.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($my_anabul as $pet): ?>
                <div
                    class="bg-white border border-slate-100 rounded-3xl shadow-xs overflow-hidden hover:border-indigo-200 transition-all group flex flex-col justify-between">
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <div
                                class="w-12 h-12 bg-indigo-50 border border-indigo-100/50 rounded-2xl text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                <i data-lucide="smile" class="w-6 h-6"></i>
                            </div>
                            <span
                                class="text-[10px] bg-slate-100 font-extrabold px-2.5 py-1 rounded-md text-slate-600 uppercase tracking-wide">
                                <?= esc($pet['JENIS_HEWAN']) ?>
                            </span>
                        </div>

                        <div class="space-y-1">
                            <h3 class="text-base font-black text-slate-900 tracking-tight">
                                <?= esc($pet['NAMA_HEWAN']) ?>
                            </h3>
                            <p class="text-xs text-slate-400 font-medium">Ras: <span class="text-slate-700 font-semibold">
                                    <?= esc($pet['RAS']) ?>
                                </span></p>
                        </div>

                        <div class="pt-3 border-t border-slate-50 flex items-center gap-2 text-xs text-slate-400">
                            <i data-lucide="cake" class="w-4 h-4 text-slate-300"></i>
                            <span>Lahir: <b class="text-slate-600 font-semibold">
                                    <?= date('d M Y', strtotime($pet['TGL_LAHIR'])) ?>
                                </b></span>
                        </div>
                    </div>
                    <div class="bg-slate-50/50 p-4 border-t border-slate-50 flex justify-between items-center gap-2">
                        <div class="flex items-center gap-3">
                            <a href="<?= base_url('pasien/anabul/hapus/' . $pet['ID_PASIEN']) ?>"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus profil <?= esc($pet['NAMA_HEWAN']) ?>?')"
                                class="text-[11px] font-bold text-slate-400 hover:text-rose-600 flex items-center gap-1 transition-colors group/hapus">
                                <i data-lucide="trash-2"
                                    class="w-3.5 h-3.5 text-slate-300 group-hover/hapus:text-rose-500 transition-colors"></i>
                                <span>Hapus</span>
                            </a>

                            <a href="<?= base_url('pasien/anabul/edit/' . $pet['ID_PASIEN']) ?>"
                                class="text-[11px] font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors group/edit">
                                <i data-lucide="edit-3"
                                    class="w-3.5 h-3.5 text-slate-300 group-hover/edit:text-slate-700 transition-colors"></i>
                                <span>Edit</span>
                            </a>
                        </div>

                        <a href="<?= base_url('pasien/riwayat-medis') ?>"
                            class="text-[11px] font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors shrink-0">
                            Riwayat Medis <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>