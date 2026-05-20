<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Profil Anabul
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-xl mx-auto">
    <div>
        <a href="<?= base_url('pasien/anabul') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Profil Anabul
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Perbarui Profil
            <?= esc($anabul['NAMA_HEWAN']) ?>
        </h1>
        <p class="text-slate-400 text-xs mt-1">Sesuaikan informasi berkas kartu digital anabul Anda jika terdapat
            kekeliruan data.</p>
    </div>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('pasien/anabul/update/' . $anabul['ID_PASIEN']) ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Nama Hewan</label>
                <input type="text" name="nama_hewan" required value="<?= esc($anabul['NAMA_HEWAN']) ?>"
                    class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all text-slate-800">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Jenis
                        Hewan</label>
                    <div class="relative flex items-center">
                        <select name="jenis_hewan" required
                            class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none cursor-pointer text-slate-800">
                            <option value="Kucing" <?= $anabul['JENIS_HEWAN'] === 'Kucing' ? 'selected' : '' ?>>Kucing
                            </option>
                            <option value="Anjing" <?= $anabul['JENIS_HEWAN'] === 'Anjing' ? 'selected' : '' ?>>Anjing
                            </option>
                            <option value="Kelinci" <?= $anabul['JENIS_HEWAN'] === 'Kelinci' ? 'selected' : '' ?>>Kelinci
                            </option>
                            <option value="Burung" <?= $anabul['JENIS_HEWAN'] === 'Burung' ? 'selected' : '' ?>>Burung
                            </option>
                            <option value="Reptil/Eksotis" <?= $anabul['JENIS_HEWAN'] === 'Reptil/Eksotis' ? 'selected' : '' ?>>Reptil/Eksotis</option>
                        </select>
                        <i data-lucide="chevron-down"
                            class="w-4 h-4 text-slate-400 absolute right-4 pointer-events-none"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Ras /
                        Breed</label>
                    <input type="text" name="ras" required value="<?= esc($anabul['RAS']) ?>"
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Tanggal Lahir
                    (Perkiraan)</label>
                <input type="date" name="tgl_lahir" max="<?= date('Y-m-d') ?>" required
                    value="<?= date('Y-m-d', strtotime($anabul['TGL_LAHIR'])) ?>"
                    class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all text-slate-800">
            </div>

            <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('pasien/anabul') ?>"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">
                    Batal
                </a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm hover:shadow-indigo-100 uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>