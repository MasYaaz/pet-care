<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Registrasi Dokter Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-2">
        <a href="<?= base_url('admin/dokter') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Form Pendaftaran Dokter Baru</h1>
        <p class="text-slate-400 text-xs mt-1">Sistem akan otomatis membuatkan akun induk pengguna sekaligus entitas
            klinis medis.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div
            class="flex items-center gap-3 bg-rose-50 border border-rose-100 p-4 rounded-xl text-rose-800 text-xs font-semibold">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/dokter/simpan') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-4">
                <h3
                    class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-50">
                    <i data-lucide="key-round" class="w-4 h-4 text-indigo-600"></i> Kredensial & Akun Login
                </h3>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Username</label>
                    <input type="text" name="username" value="<?= old('username') ?>" required autocomplete="off"
                        placeholder="contoh: drh_johndoe"
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Password Awal</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                    <p class="text-[10px] text-slate-400 mt-0.5">Dapat diubah secara mandiri oleh dokter bersangkutan
                        via profil.</p>
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Alamat Email
                        Resmi</label>
                    <input type="email" name="email" value="<?= old('email') ?>" required
                        placeholder="johndoe@petcare.com"
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-4">
                <h3
                    class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-50">
                    <i data-lucide="activity" class="w-4 h-4 text-indigo-600"></i> Informasi Medis & Kontak
                </h3>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Nama Lengkap beserta
                        Gelar</label>
                    <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required
                        placeholder="contoh: drh. John Doe, M.Si."
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">No. Handphone /
                            WA</label>
                        <input type="text" name="no_telp" value="<?= old('no_telp') ?>" required placeholder="081234..."
                            class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Nomor STR
                            Aktif</label>
                        <input type="text" name="no_str" value="<?= old('no_str') ?>" required
                            placeholder="STR-XXXX-XXXX"
                            class="w-full text-xs font-semibold font-mono px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Spesialisasi
                        Klinis</label>
                    <select name="spesialisasi" required
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none">
                        <option value="" disabled selected>Pilih Bidang Keahlian...</option>
                        <option value="Bedah & Hewan Kecil" <?= old('spesialisasi') == 'Bedah & Hewan Kecil' ? 'selected' : '' ?>>Bedah & Hewan Kecil</option>
                        <option value="Penyakit Dalam Hewan" <?= old('spesialisasi') == 'Penyakit Dalam Hewan' ? 'selected' : '' ?>>Penyakit Dalam Hewan</option>
                        <option value="Eksotis & Satwa Liar" <?= old('spesialisasi') == 'Eksotis & Satwa Liar' ? 'selected' : '' ?>>Eksotis & Satwa Liar</option>
                        <option value="Dokter Umum Hewan" <?= old('spesialisasi') == 'Dokter Umum Hewan' ? 'selected' : '' ?>>Dokter Umum Hewan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-3">
            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Alamat Rumah /
                    Domisili</label>
                <textarea name="alamat" rows="2" required placeholder="Tuliskan alamat lengkap dokter..."
                    class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all resize-none"><?= old('alamat') ?></textarea>
            </div>
        </div>

        <div class="flex justify-end items-center gap-3 pt-2">
            <a href="<?= base_url('admin/dokter') ?>"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">
                Batalkan
            </a>
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm hover:shadow-indigo-100 uppercase tracking-wider">
                Simpan & Aktifkan Akun
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>