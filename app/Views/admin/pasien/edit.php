<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Koreksi Berkas Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-3xl mx-auto">
    <div>
        <a href="<?= base_url('admin/pasien') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke List
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Koreksi Berkas Rekam Owner & Pasien</h1>
        <p class="text-slate-400 text-xs mt-1">Lakukan pembaruan atau koreksi kesalahan input identitas pemilik serta
            fisik anabul terkait.</p>
    </div>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('admin/pasien/update/' . $pasien['ID_PASIEN']) ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="space-y-4">
                <h3
                    class="text-xs font-black text-indigo-600 uppercase tracking-wider pb-1 border-b border-slate-100 flex items-center gap-1.5">
                    <i data-lucide="user" class="w-4 h-4"></i> 1. Informasi Akun Pemilik (Pet Owner)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Nama Lengkap
                            Owner</label>
                        <input type="text" name="nama_lengkap" value="<?= esc($pasien['NAMA_LENGKAP']) ?>" required
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Username
                            Portal</label>
                        <input type="text" name="username" value="<?= esc($pasien['USERNAME']) ?>" required
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">No. Telepon /
                            WA</label>
                        <input type="text" name="no_telp" value="<?= esc($pasien['NO_TELP']) ?>" required
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Email
                            Aktif</label>
                        <input type="email" name="email" value="<?= esc($pasien['EMAIL']) ?>" required
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Ganti Password
                            Akun <span class="text-slate-400 font-normal lowercase">(Opsional)</span></label>
                        <input type="password" name="password" placeholder="Kosongkan jika owner tak minta reset"
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Alamat Rumah
                            Owner</label>
                        <textarea name="alamat" rows="2" required
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all resize-none text-slate-800"><?= esc($pasien['ALAMAT']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-slate-100">
                <h3
                    class="text-xs font-black text-indigo-600 uppercase tracking-wider pb-1 border-b border-slate-100 flex items-center gap-1.5">
                    <i data-lucide="smile" class="w-4 h-4"></i> 2. Profil Fisik Pasien Hewan (Anabul)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Nama Pasien
                            Hewan</label>
                        <input type="text" name="nama_hewan" value="<?= esc($pasien['NAMA_HEWAN']) ?>" required
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Jenis
                            Hewan</label>
                        <input type="text" name="jenis_hewan" value="<?= esc($pasien['JENIS_HEWAN']) ?>" required
                            placeholder="Kucing, Anjing, Kelinci, dsb"
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Ras /
                            Varietas</label>
                        <input type="text" name="ras" value="<?= esc($pasien['RAS']) ?>" required
                            placeholder="Persia, Kampung, Golden, dsb"
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Tanggal Lahir
                            Anabul</label>
                        <input type="date" name="tgl_lahir" max="<?= date('Y-m-d') ?>" required
                            value="<?= date('Y-m-d', strtotime($pasien['TGL_LAHIR'])) ?>"
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('admin/pasien') ?>"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3 rounded-xl transition-all uppercase tracking-wider">Batal</a>
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-8 py-3 rounded-xl transition-all shadow-sm uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i> Perbarui Berkas
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>