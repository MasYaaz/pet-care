<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Tambah Hewan Baru
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
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Registrasi Anggota Hewan Baru</h1>
        <p class="text-slate-400 text-xs mt-1">Tambahkan profil hewan peliharaan Anda yang lain untuk mempermudah
            manajemen rekam medis klinik.</p>
    </div>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('pasien/anabul/simpan') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Nama Hewan</label>
                <input type="text" name="nama_hewan" required placeholder="Contoh: Milo / Chiki"
                    class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all text-slate-800">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Jenis
                        Hewan</label>
                    <div class="relative flex items-center">
                        <select name="jenis_hewan" required
                            class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none cursor-pointer text-slate-800">
                            <option value="" disabled selected>Pilih Jenis...</option>
                            <option value="Kucing">Kucing</option>
                            <option value="Anjing">Anjing</option>
                            <option value="Kelinci">Kelinci</option>
                            <option value="Burung">Burung</option>
                            <option value="Reptil/Eksotis">Reptil/Eksotis</option>
                        </select>
                        <i data-lucide="chevron-down"
                            class="w-4 h-4 text-slate-400 absolute right-4 pointer-events-none"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Ras /
                        Breed</label>
                    <input type="text" name="ras" required placeholder="Contoh: Persia, Domestik, Anggora"
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Tanggal Lahir
                    (Perkiraan)</label>
                <input type="date" name="tgl_lahir" max="<?= date('Y-m-d') ?>
                    class=" w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl
                    focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none
                    transition-all text-slate-800">
            </div>

            <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('pasien/anabul') ?>"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">
                    Batal
                </a>
                <button type="submit"
                    class="bg-slate-950 hover:bg-indigo-600 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Profil Hewan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>