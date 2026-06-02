<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Data Pasien Anabul
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Data Pasien & Pet Owner</h1>
        <p class="text-slate-400 text-xs mt-1">Gunakan halaman ini untuk melakukan koreksi typo data atau menghapus
            berkas pasien yang salah input oleh loket.</p>
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

    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Master Berkas Pasien</h3>
            <span
                class="text-[10px] bg-indigo-50 font-extrabold px-2.5 py-1 rounded-md text-indigo-600 uppercase tracking-wide">
                Total:
                <?= count($list_pasien) ?> Pasien
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pasien
                            Anabul</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama
                            Pemilik (Owner)</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kontak
                            Telepon & Email</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <?php if (empty($list_pasien)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-xs text-slate-400 font-medium">
                                <p>Belum ada data pasien/anabul terdaftar di database.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list_pasien as $p): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-base">🐾</span>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">
                                                <?= esc($p['NAMA_HEWAN']) ?>
                                            </p>
                                            <p class="text-[10px] text-slate-400 font-normal">
                                                <?= esc($p['JENIS_HEWAN']) ?> •
                                                <?= esc($p['RAS']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-slate-800">
                                    <p>
                                        <?= esc($p['NAMA_LENGKAP']) ?>
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-normal mt-0.5">@
                                        <?= esc($p['USERNAME']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    <p class="font-semibold text-slate-800">
                                        <?= esc($p['EMAIL']) ?>
                                    </p>
                                    <p class="text-slate-400 mt-0.5">
                                        <?= esc($p['NO_TELP']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('admin/pasien/edit/' . $p['ID_PASIEN']) ?>"
                                            class="w-7 h-7 bg-slate-50 text-slate-500 hover:text-indigo-600 border border-slate-200/60 rounded-md flex items-center justify-center transition-all">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </a>
                                        <a href="<?= base_url('admin/pasien/hapus/' . $p['ID_PASIEN']) ?>"
                                            onclick="return confirm('Hapus profil anabul <?= esc($p['NAMA_HEWAN']) ?> beserta akun login pemiliknya?')"
                                            class="w-7 h-7 bg-slate-50 text-slate-500 hover:text-rose-600 border border-slate-200/60 rounded-md flex items-center justify-center transition-all">
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