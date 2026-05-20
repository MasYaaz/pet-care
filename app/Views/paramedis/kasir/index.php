<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Kasir & Billing Finansial
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Billing & Kasir Pembayaran</h1>
            <p class="text-slate-400 text-xs mt-1">Proses pelunasan biaya tindakan medis, administrasi klinik, dan
                penebusan nota obat pasien.</p>
        </div>
        <div
            class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-4 py-2 rounded-xl flex items-center gap-2">
            <i data-lucide="banknote" class="w-4 h-4"></i>
            Kasir Utama Terbuka
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div
            class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-emerald-800 text-xs font-semibold">
            <i data-lucide="check-square" class="w-4 h-4 text-emerald-600 shrink-0"></i>
            <span>
                <?= session()->getFlashdata('success') ?>
            </span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div
            class="flex items-center gap-3 bg-rose-50 border border-rose-100 p-4 rounded-xl text-rose-800 text-xs font-semibold">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
            <span>
                <?= session()->getFlashdata('error') ?>
            </span>
        </div>
    <?php endif; ?>

    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Daftar Invoice Invoice</h3>
            <span
                class="text-[10px] bg-slate-100 font-extrabold px-2.5 py-1 rounded-md text-slate-500 uppercase tracking-wide">
                Sesi Hari Ini:
                <?= date('d M Y') ?>
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-28">No.
                            Invoice</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pasien &
                            Pemilik</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total
                            Tagihan</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Status</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Metode</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <?php if (empty($list_billing)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i data-lucide="receipt" class="w-8 h-8 text-slate-300"></i>
                                    <p>Belum ada nota tagihan yang diterbitkan oleh dokter hari ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list_billing as $bill): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-xs font-mono font-bold text-slate-900">
                                    #INV-
                                    <?= $bill['ID_TAGIHAN'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-900">🐾
                                        <?= esc($bill['NAMA_HEWAN']) ?>
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-medium">Owner:
                                        <?= esc($bill['NAMA_PEMILIK']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-800">
                                    Rp
                                    <?= number_format($bill['TOTAL_BAYAR'], 0, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($bill['STATUS_BAYAR'] === 'Lunas'): ?>
                                        <span
                                            class="inline-block text-[9px] font-extrabold px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-md uppercase tracking-wide">
                                            Lunas
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-block text-[9px] font-extrabold px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-100 rounded-md uppercase tracking-wide animate-pulse">
                                            Belum Bayar
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center text-xs font-medium text-slate-500">
                                    <?= $bill['METODE_BAYAR'] ? esc($bill['METODE_BAYAR']) : '—' ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($bill['STATUS_BAYAR'] === 'Belum Bayar'): ?>
                                        <form action="<?= base_url('paramedis/kasir/bayar/' . $bill['ID_PEMBAYARAN']) ?>"
                                            method="POST" class="flex flex-col sm:flex-row items-center gap-2">
                                            <?= csrf_field() ?>

                                            <select name="id_metode_bayar" required
                                                class="text-[11px] font-semibold px-2 py-1.5 bg-slate-50 border border-slate-200 rounded-lg outline-none">
                                                <option value="1">Tunai</option>
                                                <option value="2">QRIS</option>
                                                <option value="3">Transfer Mandiri</option>
                                            </select>

                                            <input type="number" name="jumlah_bayar" required min="<?= $bill['TOTAL_TAGIHAN'] ?>"
                                                placeholder="Uang bayar..."
                                                class="w-24 text-[11px] font-semibold px-2 py-1.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-emerald-500">

                                            <button type="submit"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wider transition-all cursor-pointer">
                                                Selesai
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="flex items-center justify-center">
                                            <button onclick="alert('Membuka struk PDF thermal...')"
                                                class="border border-slate-200 text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 text-[10px] font-bold px-4 py-1.5 rounded-lg transition-all flex items-center gap-1 cursor-pointer">
                                                <i data-lucide="printer" class="w-3.5 h-3.5"></i> Cetak Kuitansi
                                            </button>
                                        </div>
                                    <?php endif; ?>
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