<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Ruang Tunggu Medis
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Ruang Tunggu Pasien Anda</h1>
            <p class="text-slate-400 text-xs mt-1">Daftar pasien (anabul) yang dijadwalkan berkunjung ke ruang praktik
                Anda hari ini.</p>
        </div>
        <span
            class="text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-xl flex items-center gap-2">
            <span class="w-2 h-2 bg-indigo-500 rounded-full animate-ping"></span>
            Sesi Praktik Aktif
        </span>
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

    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Antrean Pemeriksaan Hari Ini</h3>
            <span
                class="text-[10px] bg-slate-100 font-extrabold px-2.5 py-1 rounded-md text-slate-500 uppercase tracking-wide">
                Total:
                <?= count($list_antrean) ?> Antrean
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75">
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-24">
                            Nomor</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pasien
                            Hewan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jenis & Ras
                        </th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama
                            Pemilik</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Keluhan
                            Awal Loket</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <?php if (empty($list_antrean)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i data-lucide="smile" class="w-8 h-8 text-slate-300"></i>
                                    <p>Bagus! Semua antrean pasien Anda hari ini sudah selesai diperiksa.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($list_antrean as $antre): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-block text-xs font-black font-mono px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg">
                                        #
                                        <?= $no++ ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-900">🐾
                                        <?= esc($antre['NAMA_HEWAN']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    <span class="bg-indigo-50 text-indigo-700 text-[10px] font-bold px-2 py-0.5 rounded">
                                        <?= esc($antre['JENIS_HEWAN']) ?>
                                    </span>
                                    <p class="text-slate-400 text-[11px] mt-0.5">
                                        <?= esc($antre['RAS']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-slate-800">
                                    <?= esc($antre['NAMA_PEMILIK']) ?>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">
                                    <?= esc($antre['KELUHAN']) ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?= base_url('dokter/rekam-medis/periksa/' . $antre['ID_RESERVASI']) ?>"
                                        class="inline-flex items-center gap-1 bg-indigo-600 hover:bg-indigo-700 text-white text-[11px] font-bold px-3 py-2 rounded-xl transition-all shadow-2xs uppercase tracking-wider">
                                        <i data-lucide="stethoscope" class="w-3.5 h-3.5"></i> Periksa Pasien
                                    </a>
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