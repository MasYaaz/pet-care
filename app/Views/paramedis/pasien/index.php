<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Data Pasien & Pemilik
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Master Data Pasien (Anabul)</h1>
            <p class="text-slate-400 text-xs mt-1">Daftar seluruh pasien hewan yang terregistrasi beserta data
                penanggung jawab (pemilik).</p>
        </div>
        <a href="<?= base_url('paramedis/pasien/tambah') ?>"
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm hover:shadow-emerald-100 uppercase tracking-wider">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Registrasi Pasien Walk-in
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

    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Kartu Rekam Pasien</h3>
            <span
                class="text-[10px] bg-emerald-50 font-extrabold px-2.5 py-1 rounded-md text-emerald-700 uppercase tracking-wide">
                Terdaftar:
                <?= count($list_pasien) ?> Pasien
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Identitas
                            Hewan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jenis & Ras
                        </th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pemilik /
                            Penanggung Jawab</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kontak
                            Pemilik</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <?php if (empty($list_pasien)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i data-lucide="paw-print" class="w-8 h-8 text-slate-300"></i>
                                    <p>Belum ada data pasien hewan yang tercatat di loket.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list_pasien as $pasien): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                                            <i data-lucide="heart-pulse" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">
                                                <?= esc($pasien['NAMA_HEWAN']) ?>
                                            </p>
                                            <p class="text-[10px] text-slate-400 font-medium">Tgl Lahir:
                                                <?= date('d M Y', strtotime($pasien['TGL_LAHIR'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    <span class="bg-slate-100 text-slate-800 text-[10px] font-bold px-2 py-0.5 rounded">
                                        <?= esc($pasien['JENIS_HEWAN']) ?>
                                    </span>
                                    <p class="text-slate-400 text-[11px] mt-0.5">
                                        <?= esc($pasien['RAS']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold text-slate-800">
                                        <?= esc($pasien['NAMA_LENGKAP']) ?>
                                    </p>
                                    <p class="text-[10px] text-slate-400">ID Akun: @
                                        <?= esc($pasien['USERNAME']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-slate-600">
                                    <?= esc($pasien['NO_TELP']) ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#"
                                            class="w-7 h-7 bg-slate-50 text-slate-500 hover:text-emerald-600 border border-slate-200/60 rounded-md flex items-center justify-center transition-all"
                                            title="Tambah Antrean">
                                            <i data-lucide="calendar-plus" class="w-3.5 h-3.5"></i>
                                        </a>
                                        <a href="#"
                                            class="w-7 h-7 bg-slate-50 text-slate-500 hover:text-indigo-600 border border-slate-200/60 rounded-md flex items-center justify-center transition-all"
                                            title="Detail Pasien">
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
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