<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Riwayat Pasien Diperiksa
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-5xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Riwayat Pemeriksaan Pasien</h1>
            <p class="text-slate-400 text-xs mt-1">Daftar keseluruhan arsip rekam medis anabul yang pernah Anda tangani.
            </p>
        </div>
        <a href="<?= base_url('dokter/ruang-tunggu') ?>"
            class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-5 py-3 rounded-xl transition-all uppercase tracking-wider flex items-center gap-1.5 h-fit w-fit">
            <i data-lucide="door-open" class="w-4 h-4"></i> Ruang Tunggu
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div
            class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-emerald-800 text-xs font-semibold">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
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

    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead
                    class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="p-4 pl-6">Tanggal Periksa</th>
                        <th class="p-4">Nama Pasien / Pemilik</th>
                        <th class="p-4">Diagnosis Penyakit</th>
                        <th class="p-4 text-center">Status Billing</th>
                        <th class="p-4 text-center pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-semibold text-slate-700">
                    <?php if (!empty($list_riwayat)):
                        foreach ($list_riwayat as $row): ?>
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <td class="p-4 pl-6 text-slate-500 font-medium">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>
                                            <?= date('d M Y, H:i', strtotime($row['TANGGAL_PERIKSA'])) ?> WIB
                                        </span>
                                    </div>
                                </td>

                                <td class="p-4">
                                    <div class="text-slate-900 font-bold">🐾
                                        <?= esc($row['NAMA_HEWAN']) ?>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-medium mt-0.5">Pemilik:
                                        <?= esc($row['NAMA_PEMILIK']) ?>
                                    </div>
                                </td>

                                <td class="p-4 text-slate-600 font-medium max-w-xs truncate">
                                    <?= esc($row['DIAGNOSIS']) ?>
                                </td>

                                <td class="p-4 text-center">
                                    <?php
                                    $db = \Config\Database::connect();
                                    $pay = $db->table('PEMBAYARAN')->where('ID_RESERVASI', $row['ID_RESERVASI'])->get()->getRowArray();
                                    $statusBayar = $pay ? strtolower(trim($pay['STATUS_BAYAR'])) : 'belum bayar';
                                    ?>
                                    <?php if ($statusBayar === 'lunas'): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            Lunas
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                            Belum Bayar
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 text-center pr-6">
                                    <?php if ($statusBayar === 'lunas'): ?>
                                        <button disabled title="Rekam medis yang sudah lunas tidak dapat diubah"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 text-slate-400 rounded-lg text-[11px] font-bold cursor-not-allowed opacity-60">
                                            <i data-lucide="lock" class="w-3.5 h-3.5"></i> Terkunci
                                        </button>
                                    <?php else: ?>
                                        <a href="<?= base_url('dokter/rekam-medis/edit/' . $row['ID_REKAM']) ?>"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-[11px] font-bold transition-all">
                                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i> Edit Rekam
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i data-lucide="folder-open" class="w-8 h-8 text-slate-300"></i>
                                    <p class="text-xs font-bold text-slate-500">Belum ada riwayat rekam medis</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>