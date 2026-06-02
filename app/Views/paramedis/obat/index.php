<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Gudang Farmasi & Obat<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Manajemen Inventaris Obat</h1>
            <p class="text-slate-400 text-xs mt-1">Pantau pergerakan sisa stok obat apotek, perbarui harga satuan, dan
                input pasokan alkes baru.</p>
        </div>
        <a href="<?= base_url('paramedis/obat/tambah') ?>"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm hover:shadow-indigo-100 uppercase tracking-wider">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Obat / Alkes
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div
            class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-emerald-800 text-xs font-semibold">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
            <span><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div
            class="flex items-center gap-3 bg-rose-50 border border-rose-100 p-4 rounded-xl text-rose-800 text-xs font-semibold">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Logistik Produk Farmasi</h3>
            <span
                class="text-[10px] bg-indigo-50 font-extrabold px-2.5 py-1 rounded-md text-indigo-600 uppercase tracking-wide">
                Total: <?= count($list_obat) ?> Item Terdata
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Obat /
                            Alkes</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Klasifikasi
                            & Takaran</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                            Harga Satuan</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Sisa Stok</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <?php if (empty($list_obat)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i data-lucide="pill" class="w-8 h-8 text-slate-300"></i>
                                    <p>Gudang farmasi kosong. Belum ada obat yang diinput.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list_obat as $o): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                                            <i data-lucide="pill" class="w-4 h-4"></i>
                                        </div>
                                        <span class="text-sm font-bold text-slate-900"><?= esc($o['NAMA_OBAT']) ?></span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-xs font-bold text-slate-500">
                                    <span
                                        class="inline-block bg-slate-100 text-slate-700 px-2 py-1 rounded-md text-[10px] uppercase tracking-wide">
                                        <?= esc($o['JENIS']) ?>
                                    </span>
                                    <span class="text-slate-400 font-normal ml-1">per <?= esc($o['SATUAN']) ?></span>
                                </td>

                                <td class="px-6 py-4 text-xs font-mono font-bold text-slate-900 text-right">
                                    Rp <?= number_format($o['HARGA_SATUAN_OBAT'], 0, ',', '.') ?>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <?php if ($o['STOK'] <= 10): ?>
                                        <span
                                            class="inline-block text-[10px] font-black bg-rose-50 border border-rose-100 text-rose-700 px-2.5 py-1 rounded-md uppercase tracking-wider animate-pulse">
                                            ⚠️ Kritis: <?= esc($o['STOK']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-block text-[10px] font-bold bg-emerald-50 border border-emerald-100 text-emerald-700 px-2.5 py-1 rounded-md">
                                            ✓ Ready: <?= esc($o['STOK']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('paramedis/obat/edit/' . $o['ID_OBAT']) ?>"
                                            class="w-7 h-7 bg-slate-50 text-slate-500 hover:text-indigo-600 border border-slate-200/60 rounded-md flex items-center justify-center transition-all"
                                            title="Edit Produk">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </a>
                                        <a href="<?= base_url('paramedis/obat/hapus/' . $o['ID_OBAT']) ?>"
                                            onclick="return confirm('Hapus produk <?= esc($o['NAMA_OBAT']) ?> dari inventaris gudang?')"
                                            class="w-7 h-7 bg-slate-50 text-slate-500 hover:text-rose-600 border border-slate-200/60 rounded-md flex items-center justify-center transition-all"
                                            title="Hapus Obat">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>