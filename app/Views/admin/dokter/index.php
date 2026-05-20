<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Data Dokter
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Daftar Dokter Hewan</h1>
            <p class="text-slate-400 text-xs mt-1">Kelola hak akses, informasi kompetensi, dan nomor STR para tenaga
                medis aktif.</p>
        </div>
        <a href="<?= base_url('admin/dokter/tambah') ?>"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm hover:shadow-indigo-100 uppercase tracking-wider">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Dokter Baru
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
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Tenaga Medis Terdaftar</h3>
            <span
                class="text-[10px] bg-indigo-50 font-extrabold px-2.5 py-1 rounded-md text-indigo-600 uppercase tracking-wide">
                Total:
                <?= count($list_dokter) ?> Dokter
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Dokter
                        </th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kontak &
                            Email</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Spesialisasi</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">No. STR
                        </th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <?php if (empty($list_dokter)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i data-lucide="users" class="w-8 h-8 text-slate-300"></i>
                                    <p>Belum ada data dokter yang didaftarkan ke sistem.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list_dokter as $dokter): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 bg-indigo-50 border border-indigo-100 text-indigo-600 font-bold rounded-lg text-xs flex items-center justify-center">
                                            <?= strtoupper(substr($dokter['NAMA_LENGKAP'], 0, 2)) ?>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">
                                                <?= esc($dokter['NAMA_LENGKAP']) ?>
                                            </p>
                                            <p class="text-[11px] text-slate-400 font-medium">Username: @
                                                <?= esc($dokter['USERNAME']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    <p class="font-semibold text-slate-800">
                                        <?= esc($dokter['EMAIL']) ?>
                                    </p>
                                    <p class="text-slate-400 mt-0.5">
                                        <?= esc($dokter['NO_TELP']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-indigo-50/60 text-indigo-700 text-[10px] font-bold px-2.5 py-1 rounded-md">
                                        <?= esc($dokter['SPESIALISASI']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs font-mono font-medium text-slate-500">
                                    <?= esc($dokter['NO_STR']) ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#"
                                            class="w-7 h-7 bg-slate-50 text-slate-500 hover:text-indigo-600 border border-slate-200/60 rounded-md flex items-center justify-center transition-all"
                                            title="Edit Profil">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </a>
                                        <a href="#"
                                            class="w-7 h-7 bg-slate-50 text-slate-500 hover:text-rose-600 border border-slate-200/60 rounded-md flex items-center justify-center transition-all"
                                            title="Blokir Akun">
                                            <i data-lucide="ban" class="w-3.5 h-3.5"></i>
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