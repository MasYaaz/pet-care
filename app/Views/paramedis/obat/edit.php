<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Pembaruan Berkas Obat
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
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Penyesuaian & Stok Opname</h1>
        <p class="text-slate-400 text-xs mt-1">Lakukan revisi berkas harga jual atau perbarui angka stok fisik obat
            sesuai hasil audit berkala apotek.</p>
    </div>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('paramedis/obat/update/' . $obat['ID_OBAT']) ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Nama Obat / Alat
                    Medis</label>
                <input type="text" name="nama_obat" value="<?= esc($obat['NAMA_OBAT']) ?>" required
                    class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Jenis Obat</label>
                    <input type="text" name="jenis" value="<?= esc($obat['JENIS']) ?>" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Satuan
                        Takaran</label>
                    <input type="text" name="satuan" value="<?= esc($obat['SATUAN']) ?>" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('paramedis/obat') ?>"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3 rounded-xl transition-all uppercase tracking-wider">Batal</a>
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>