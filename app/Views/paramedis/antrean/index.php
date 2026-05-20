<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Registrasi & Monitor Antrean
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Monitor Antrean Hari Ini</h1>
            <p class="text-slate-400 text-xs mt-1">Pantau sirkulasi kunjungan, panggil nomor urut pasien, dan arahkan ke
                ruang dokter terkait.</p>
        </div>
        <a href="<?= base_url('paramedis/antrean/tambah') ?>"
            class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm hover:shadow-amber-100 uppercase tracking-wider">
            <i data-lucide="calendar-plus" class="w-4 h-4"></i> Check-in Kunjungan Baru
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div
            class="flex items-center gap-3 bg-amber-50 border border-amber-200 p-4 rounded-xl text-amber-900 text-xs font-semibold">
            <i data-lucide="printer" class="w-4 h-4 text-amber-600 shrink-0"></i>
            <span>
                <?= session()->getFlashdata('success') ?>
            </span>
        </div>
    <?php endif; ?>

    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Alur Antrean Berjalan</h3>
            <span
                class="text-[10px] bg-slate-100 font-extrabold px-2.5 py-1 rounded-md text-slate-500 uppercase tracking-wide">
                Tanggal:
                <?= date('d F Y') ?>
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75">
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-24">
                            No. Urut</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pasien
                            (Anabul)</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Dokter
                            Pemeriksa</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Keluhan
                            Utama</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Status</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <?php if (empty($list_antrean)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i data-lucide="clock-3" class="w-8 h-8 text-slate-300"></i>
                                    <p>Belum ada pasien yang melakukan check-in loket hari ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list_antrean as $antre): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-block text-base font-black px-3 py-1 bg-amber-50 text-amber-700 rounded-xl border border-amber-100 font-mono">
                                        A-
                                        <?= sprintf("%02d", $antre['NOMOR_ANTREAN']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-900">
                                        <?= esc($antre['NAMA_HEWAN']) ?>
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-medium">Pemilik:
                                        <?= esc($antre['NAMA_DOKTER']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                        <?= esc($antre['NAMA_DOKTER']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">
                                    <?= esc($antre['KELUHAN_AWAL']) ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php
                                    $status = esc($antre['STATUS_RESERVASI']);
                                    $badgeColor = 'bg-amber-50 text-amber-700 border-amber-100';
                                    if ($status == 'Diperiksa')
                                        $badgeColor = 'bg-indigo-50 text-indigo-700 border-indigo-100';
                                    if ($status == 'Selesai')
                                        $badgeColor = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                    ?>
                                    <span
                                        class="text-[9px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wide border <?= $badgeColor ?>">
                                        <?= $status ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button
                                            class="w-7 h-7 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white border border-amber-200/60 rounded-md flex items-center justify-center transition-all shadow-2xs"
                                            title="Panggil Suara Loket">
                                            <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                        <button
                                            class="w-7 h-7 bg-slate-50 text-slate-500 hover:text-indigo-600 border border-slate-200/60 rounded-md flex items-center justify-center transition-all"
                                            title="Ubah Penjadwalan">
                                            <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                                        </button>
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