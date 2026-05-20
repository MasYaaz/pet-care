<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Registrasi Pasien Walk-in<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-2">
        <a href="<?= base_url('paramedis/pasien') ?>" class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Pasien
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Registrasi Pemilik & Hewan Baru</h1>
        <p class="text-slate-400 text-xs mt-1">Gunakan form ini jika pelanggan baru pertama kali berkunjung untuk mendaftarkan akun sekaligus hewan peliharaannya.</p>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="flex items-center gap-3 bg-rose-50 border border-rose-100 p-4 rounded-xl text-rose-800 text-xs font-semibold">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('paramedis/pasien/simpan') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-4">
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-50">
                    <i data-lucide="user" class="w-4 h-4 text-emerald-600"></i> Data Pemilik (Owner)
                </h3>
                
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Nama Lengkap Pemilik</label>
                    <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required
                           placeholder="contoh: Ahmad Subarjo"
                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">No. HP / WhatsApp Aktif</label>
                    <input type="text" name="no_telp" value="<?= old('no_telp') ?>" required
                           placeholder="0812XXXXXXXX"
                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="<?= old('email') ?>" required
                           placeholder="ahmad@email.com"
                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-50">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Username Akun</label>
                        <input type="text" name="username" value="<?= old('username') ?>" required
                               placeholder="ahmad123"
                               class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Password</label>
                        <input type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-4">
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-50">
                    <i data-lucide="paw-print" class="w-4 h-4 text-emerald-600"></i> Identitas Hewan (Anabul)
                </h3>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Nama Hewan</label>
                    <input type="text" name="nama_hewan" value="<?= old('nama_hewan') ?>" required
                           placeholder="contoh: Snowy / Cimot"
                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Jenis Hewan</label>
                        <select name="jenis_hewan" required
                                class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all appearance-none">
                            <option value="" disabled selected>Pilih Jenis...</option>
                            <option value="Kucing" <?= old('jenis_hewan') == 'Kucing' ? 'selected' : '' ?>>Kucing</option>
                            <option value="Anjing" <?= old('jenis_hewan') == 'Anjing' ? 'selected' : '' ?>>Anjing</option>
                            <option value="Kelinci" <?= old('jenis_hewan') == 'Kelinci' ? 'selected' : '' ?>>Kelinci</option>
                            <option value="Burung" <?= old('jenis_hewan') == 'Burung' ? 'selected' : '' ?>>Burung</option>
                            <option value="Reptil/Eksotis" <?= old('jenis_hewan') == 'Reptil/Eksotis' ? 'selected' : '' ?>>Reptil/Eksotis</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Ras Hewan</label>
                        <input type="text" name="ras" value="<?= old('ras') ?>" required
                               placeholder="contoh: Persia / Kampung / Golden"
                               class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Tanggal Lahir Hewan (Perkiraan)</label>
                    <input type="date" name="tgl_lahir" value="<?= old('tgl_lahir') ?>" required
                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-3">
            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Alamat Lengkap Pemilik</label>
                <textarea name="alamat" rows="2" required placeholder="Tuliskan alamat tinggal pemilik hewan saat ini..."
                          class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition-all resize-none"><?= old('alamat') ?></textarea>
            </div>
        </div>

        <div class="flex justify-end items-center gap-3 pt-2">
            <a href="<?= base_url('paramedis/pasien') ?>" 
               class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">
                Batalkan
            </a>
            <button type="submit" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm hover:shadow-emerald-100 uppercase tracking-wider">
                Selesaikan Pendaftaran
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>