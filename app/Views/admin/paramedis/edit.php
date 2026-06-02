<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Modifikasi Akun Paramedis
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-3xl mx-auto">
    <div>
        <a href="<?= base_url('admin/paramedis') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Manajemen
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Perbarui Profil Staf Operasional</h1>
        <p class="text-slate-400 text-xs mt-1">Ubah data identitas personel, kredensial log masuk, atau mutasi pembagian
            divisi jabatan loket.</p>
    </div>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('admin/paramedis/update/' . $paramedis['ID_PARAMEDIS']) ?>" method="POST"
            class="space-y-5">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-1 sm:col-span-2">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Nama Lengkap
                        Personel</label>
                    <input type="text" name="nama_lengkap" value="<?= esc($paramedis['NAMA_LENGKAP']) ?>" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Username
                        Akses</label>
                    <input type="text" name="username" value="<?= esc($paramedis['USERNAME']) ?>" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Email Perusahaan /
                        Pribadi</label>
                    <input type="email" name="email" value="<?= esc($paramedis['EMAIL']) ?>" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Nomor HP Ring
                        internal</label>
                    <input type="text" name="no_telp" value="<?= esc($paramedis['NO_TELP']) ?>" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Setel Ulang Sandi
                        Akun <span class="text-slate-400 font-normal lowercase">(Opsional)</span></label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah"
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Penugasan Jabatan
                        / Divisi</label>
                    <div class="relative flex items-center">
                        <select name="jabatan" required
                            class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer text-slate-800">
                            <?php
                            $listJabatan = ['Front Office / Resepsionis', 'Kasir Utama Klinik', 'Apoteker / Farmasi', 'Perawat Veteriner Senior'];
                            foreach ($listJabatan as $j):
                                ?>
                                <option value="<?= $j ?>" <?= ($paramedis['JABATAN'] === $j) ? 'selected' : '' ?>>
                                    <?= $j ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i data-lucide="chevron-down"
                            class="w-4 h-4 text-slate-400 absolute right-4 pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Alamat Rumah
                        Tinggal</label>
                    <textarea name="alamat" rows="3" required
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all resize-none text-slate-800"><?= esc($paramedis['ALAMAT']) ?></textarea>
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('admin/paramedis') ?>"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">
                    Batal
                </a>
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Mutasi Staf
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>