<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Dashboard Utama<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-8">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-950 tracking-tight">Selamat Datang,
                <?= session()->get('nama_lengkap') ?>!
            </h1>
            <p class="text-slate-400 text-sm mt-1">Portal Internal • Hak akses: <span
                    class="text-indigo-600 font-semibold"><?= session()->get('nama_role') ?></span></p>
        </div>
        <div
            class="text-xs font-semibold text-slate-500 bg-slate-50 border border-slate-200/60 px-4 py-2 rounded-xl flex items-center gap-2">
            <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
            Situs Manajemen Utama
        </div>
    </div>

    <?php if (session()->get('id_role') == 2): ?>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center"><i
                        data-lucide="users" class="w-5 h-5"></i></div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900"><?= $antrean_baru ?></h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Antrean Tunggu Hari Ini</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center"><i
                        data-lucide="heart" class="w-5 h-5"></i></div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900"><?= $total_pasien ?></h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Total Hewan Terdaftar</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3">
                <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center"><i
                        data-lucide="alert-triangle" class="w-5 h-5"></i></div>
                <div>
                    <h3 class="text-2xl font-black text-rose-600"><?= $obat_kritis ?></h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Stok Farmasi Menipis</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->get('id_role') == 1): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div
                class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between group hover:border-indigo-500/20 transition-all">
                <div class="space-y-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Pasien Menunggu Anda</p>
                    <h3 class="text-3xl font-black text-slate-900"><?= $antrean_baru ?> <span
                            class="text-xs font-normal text-slate-400">Ekor</span></h3>
                </div>
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center"><i
                        data-lucide="folder-heart" class="w-6 h-6"></i></div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Tindakan Medis Selesai</p>
                    <h3 class="text-3xl font-black text-slate-900">0 <span
                            class="text-xs font-normal text-slate-400">Sesi</span></h3>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center"><i
                        data-lucide="check-circle" class="w-6 h-6"></i></div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->get('id_role') == 3): ?>
        <div
            class="bg-white border border-slate-100 rounded-2xl p-8 flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="space-y-2 text-center sm:text-left">
                <h3 class="text-lg font-bold text-slate-900">Ingin Melakukan Check-up Berkala?</h3>
                <p class="text-slate-400 text-xs max-w-sm">Pilih dokter andalan, tentukan hari kunjungan, dan dapatkan nomor
                    antrean tanpa ribet.</p>
            </div>
            <button
                class="bg-indigo-600 text-white text-xs font-bold px-6 py-4 rounded-full hover:bg-slate-950 transition-all shrink-0 uppercase tracking-wider">
                Booking Jadwal Sekarang
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->get('id_role') == 4): ?>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-3">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center"><i
                        data-lucide="stethoscope" class="w-5 h-5"></i></div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900"><?= $total_dokter ?? 0 ?></h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Dokter Hewan Aktif</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-3">
                <div class="w-10 h-10 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center"><i
                        data-lucide="contact" class="w-5 h-5"></i></div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900"><?= $total_paramedis ?? 0 ?></h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Paramedis / Staf Aktif</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-3">
                <div class="w-10 h-10 bg-slate-50 text-slate-600 rounded-xl flex items-center justify-center"><i
                        data-lucide="shield-check" class="w-5 h-5"></i></div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900"><?= $total_pengguna ?? 0 ?></h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Total Akun Sistem</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xs space-y-4">
            <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <i data-lucide="sliders" class="w-4 h-4 text-indigo-600"></i> Kendali Cepat Arsitektur Sistem
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="<?= base_url('admin/dokter/tambah') ?>"
                    class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200/60 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-900 transition-all group">
                    <div
                        class="w-8 h-8 bg-white border border-slate-200 text-slate-700 rounded-lg flex items-center justify-center group-hover:border-indigo-200 group-hover:text-indigo-600">
                        <i data-lucide="user-cog" class="w-4 h-4"></i>
                    </div>
                    <span class="text-xs font-bold">Daftarkan & Konfigurasi Dokter Baru</span>
                </a>
                <a href="<?= base_url('admin/paramedis/tambah') ?>"
                    class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200/60 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-900 transition-all group">
                    <div
                        class="w-8 h-8 bg-white border border-slate-200 text-slate-700 rounded-lg flex items-center justify-center group-hover:border-indigo-200 group-hover:text-indigo-600">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                    </div>
                    <span class="text-xs font-bold">Daftarkan Akun Staf Paramedis Baru</span>
                </a>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->get('id_role') == 1 || session()->get('id_role') == 2): ?>
        <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-sm">Aktivitas Pasien Terkini</h3>
                <span
                    class="text-[10px] bg-slate-100 font-bold px-2.5 py-1 rounded-md text-slate-500 uppercase tracking-wide">Live
                    Log</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Waktu</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Hewan
                            </th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pemilik
                            </th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if (empty($list_antrean)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-xs text-slate-400 font-medium">Belum ada
                                    aktivitas antrean pasien masuk.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($list_antrean as $antre): ?>
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-6 py-4 text-xs font-semibold text-slate-500">
                                        <?= date('H:i', strtotime($antre['CREATED_AT'])) ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-800"><?= $antre['NAMA_HEWAN'] ?></td>
                                    <td class="px-6 py-4 text-xs font-medium text-slate-400"><?= $antre['NAMA_PEMILIK'] ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="bg-amber-50 text-amber-700 text-[9px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wide">
                                            <?= $antre['STATUS_RESERVASI'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>