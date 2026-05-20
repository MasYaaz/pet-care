<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Registrasi Paramedis Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-2">
        <a href="<?= base_url('admin/paramedis') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Form Pendaftaran Paramedis Baru</h1>
        <p class="text-slate-400 text-xs mt-1">Daftarkan personel baru untuk memegang kontrol operasional meja loket
            pendaftaran dan kasir.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div
            class="flex items-center gap-3 bg-rose-50 border border-rose-100 p-4 rounded-xl text-rose-800 text-xs font-semibold">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
            <span>
                <?= session()->getFlashdata('error') ?>
            </span>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/paramedis/simpan') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-4">
                <h3
                    class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-50">
                    <i data-lucide="lock" class="w-4 h-4 text-teal-600"></i> Akun & Otoritas Login
                </h3>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Username Staf</label>
                    <input type="text" name="username" value="<?= old('username') ?>" required autocomplete="off"
                        placeholder="contoh: jane_recep"
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Password Awal</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Alamat Email
                        Staf</label>
                    <input type="email" name="email" value="<?= old('email') ?>" required
                        placeholder="jane.doe@petcare.com"
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-4">
                <h3
                    class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-50">
                    <i data-lucide="contact" class="w-4 h-4 text-teal-600"></i> Informasi Staf & Jabatan
                </h3>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Nama Lengkap
                        Staf</label>
                    <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required
                        placeholder="contoh: Jane Doe"
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">No. Handphone /
                            WA</label>
                        <input type="text" name="no_telp" value="<?= old('no_telp') ?>" required placeholder="089988..."
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Penugasan
                            Jabatan</label>
                        <select name="jabatan" required
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none">
                            <option value="" disabled selected>Pilih Penugasan...</option>
                            <option value="Front Desk Resepsionis" <?= old('jabatan') == 'Front Desk Resepsionis' ? 'selected' : '' ?>>Front Desk Resepsionis</option>
                            <option value="Staf Kasir & Keuangan" <?= old('jabatan') == 'Staf Kasir & Keuangan' ? 'selected' : '' ?>>Staf Kasir & Keuangan</option>
                            <option value="Administrasi Farmasi" <?= old('jabatan') == 'Administrasi Farmasi' ? 'selected' : '' ?>>Administrasi Farmasi</option>
                            <option value="Kepala Operasional Loket" <?= old('jabatan') == 'Kepala Operasional Loket' ? 'selected' : '' ?>>Kepala Operasional Loket</option>
                        </select>
                    </div>
                </div>

                <div class="p-4 bg-teal-50/50 border border-teal-100 rounded-xl space-y-2 mt-2">
                    <h4 class="text-[11px] font-bold text-teal-950 uppercase tracking-wider flex items-center gap-1.5">
                        <i data-lucide="info" class="w-3.5 h-3.5 text-teal-600"></i> Hak Otoritas Operasional
                    </h4>
                    <p class="text-slate-500 text-[11px] leading-relaxed">Akun ini didaftarkan dengan <span
                            class="font-bold text-teal-700">Role Paramedis</span>. Pemegang akun memiliki wewenang untuk
                        mencatatkan pasien walk-in, mengatur antrean pemeriksaan, dan memproses transaksi finansial
                        kasir.</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-3">
            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Alamat Rumah /
                    Tinggal</label>
                <textarea name="alamat" rows="2" required placeholder="Tuliskan alamat lengkap tempat tinggal staf..."
                    class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all resize-none"><?= old('alamat') ?></textarea>
            </div>
        </div>

        <div class="flex justify-end items-center gap-3 pt-2">
            <a href="<?= base_url('admin/paramedis') ?>"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">
                Batalkan
            </a>
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm hover:shadow-indigo-100 uppercase tracking-wider">
                Aktifkan Akun Staf
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>