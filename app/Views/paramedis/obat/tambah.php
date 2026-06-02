<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Registrasi Obat Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-xl mx-auto">
    <div>
        <a href="<?= base_url('paramedis/obat') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Logistik
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Input Ketersediaan Farmasi Baru</h1>
        <p class="text-slate-400 text-xs mt-1">Tambahkan entitas obat, vitamin, cairan infus, atau alkes medis baru ke
            database apotek klinik.</p>
    </div>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('paramedis/obat/simpan') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Nama Obat / Alat
                    Medis</label>
                <input type="text" name="nama_obat" required
                    placeholder="Contoh: Amoxicillin Drop 10ml, Kain Kasa, dll."
                    class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Jenis Obat</label>
                    <input type="text" name="jenis" required placeholder="Contoh: Tablet, Drop, Cair, Salep"
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Satuan
                        Takaran</label>
                    <input type="text" name="satuan" required placeholder="Contoh: Botol, Strip, Tube, Pcs"
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('paramedis/obat') ?>"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">Batal</a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="check" class="w-4 h-4"></i> Daftarkan Produk
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>