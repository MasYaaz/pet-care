<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - PetCare</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    <link rel="icon" href="<?= base_url('favicon-light.svg'); ?>" media="(prefers-color-scheme: light)">
    <link rel="icon" href="<?= base_url('favicon-dark.svg'); ?>" media="(prefers-color-scheme: dark)">
</head>

<body class="bg-[#FAFAFA] text-slate-900 flex h-screen overflow-hidden antialiased">

    <aside class="w-64 bg-white border-r border-slate-100 flex flex-col shrink-0">
        <div class="p-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="stethoscope" class="w-4 h-4 text-white"></i>
                </div>
                <span class="font-extrabold text-lg tracking-tight">pet<span class="text-indigo-600">care.</span></span>
            </div>
        </div>

        <nav class="flex-grow px-4 space-y-1">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mb-2">Main Menu</p>

            <a href="<?= base_url('dashboard') ?>"
                class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('dashboard*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </a>

            <?php if (session()->get('id_role') == 2): ?>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mt-6 mb-2">Operasional Klinik
                </p>

                <a href="<?= base_url('paramedis/pasien') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('paramedis/pasien*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="users" class="w-4 h-4"></i> Data Pasien
                </a>

                <a href="<?= base_url('paramedis/antrean') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('paramedis/antrean*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="calendar" class="w-4 h-4"></i> Registrasi Antrean
                </a>

                <a href="<?= base_url('paramedis/kasir') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('paramedis/kasir*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="credit-card" class="w-4 h-4"></i> Kasir & Billing
                </a>

                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mt-8 mb-2">Gudang</p>
                <a href="<?= base_url('paramedis/obat') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all text-slate-500 hover:bg-slate-50 hover:text-slate-900">
                    <i data-lucide="pill" class="w-4 h-4"></i> Manajemen Obat
                </a>
            <?php endif; ?>

            <?php if (session()->get('id_role') == 4): ?>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mt-6 mb-2">Manajemen Utama</p>

                <a href="<?= base_url('admin/pasien') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('admin/pasien*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="paw-print" class="w-4 h-4"></i> Kelola Data Pasien
                </a>

                <a href="<?= base_url('admin/dokter') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('admin/dokter*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="shield-alert" class="w-4 h-4"></i> Kelola Akun Dokter
                </a>

                <a href="<?= base_url('admin/paramedis') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('admin/paramedis*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="contact" class="w-4 h-4"></i> Kelola Akun Paramedis
                </a>
            <?php endif; ?>

            <?php if (session()->get('id_role') == 1): ?>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mt-6 mb-2">Pemeriksaan Medis
                </p>

                <a href="<?= base_url('dokter/ruang-tunggu') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= (url_is('dokter/ruang-tunggu*') || url_is('dokter/rekam-medis*')) ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="stethoscope" class="w-4 h-4"></i> Ruang Tunggu Medis
                </a>

                <a href="<?= base_url('dokter/jadwal') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('dokter/jadwal*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="calendar-days" class="w-4 h-4"></i> Atur Jadwal Praktik
                </a>
            <?php endif; ?>

            <?php if (session()->get('id_role') == 3): ?>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mt-6 mb-2">Portal Pet Owner
                </p>

                <a href="<?= base_url('pasien/anabul') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('pasien/anabul*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="smile" class="w-4 h-4"></i> Profil Anabulku
                </a>

                <a href="<?= base_url('pasien/booking') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('pasien/booking*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="bookmark" class="w-4 h-4"></i> Booking Jadwal
                </a>

                <a href="<?= base_url('pasien/riwayat-medis') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('pasien/riwayat-medis*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="history" class="w-4 h-4"></i> Riwayat Klinis
                </a>

                <a href="<?= base_url('pasien/riwayat-pembayaran') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all <?= url_is('pasien/riwayat-pembayaran*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i data-lucide="receipt" class="w-4 h-4"></i> Invoice Kasir
                </a>
            <?php endif; ?>
        </nav>

        <div class="p-4 mt-auto border-t border-slate-50">
            <a href="<?= base_url('logout') ?>"
                class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar Sistem
            </a>
        </div>
    </aside>

    <main class="flex-grow flex flex-col overflow-hidden">
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-8 shrink-0">
            <h2 class="font-bold text-slate-800 tracking-tight">Kanal Internal</h2>

            <a href="<?= base_url('profil/edit') ?>"
                class="flex items-center gap-4 hover:opacity-80 transition-opacity group">
                <div class="text-right hidden sm:block">
                    <p
                        class="text-xs font-bold text-slate-900 leading-none group-hover:text-indigo-600 transition-colors">
                        <?= session()->get('nama_lengkap') ?>
                    </p>
                    <p class="text-[10px] font-semibold text-indigo-600 uppercase tracking-wider mt-1">
                        <?= session()->get('nama_role') ?>
                    </p>
                </div>

                <?php
                // Logika pendeteksian avatar fisik pengguna di header navigasi
                $idHeaderUser = session()->get('id_pengguna');
                $headerAvatar = 'uploads/avatars/' . $idHeaderUser . '.jpg';
                if (!file_exists(FCPATH . $headerAvatar)) {
                    $headerAvatar = 'uploads/avatars/' . $idHeaderUser . '.png';
                }
                if (!file_exists(FCPATH . $headerAvatar)) {
                    $headerAvatar = 'uploads/avatars/' . $idHeaderUser . '.jpeg';
                }
                $adaAvatar = file_exists(FCPATH . $headerAvatar);
                ?>

                <div
                    class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center border border-slate-200 overflow-hidden group-hover:border-indigo-300 transition-colors">
                    <?php if ($adaAvatar): ?>
                        <img src="<?= base_url($headerAvatar) . '?v=' . time() ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <i data-lucide="user"
                            class="w-5 h-5 text-slate-400 group-hover:text-indigo-600 transition-colors"></i>
                    <?php endif; ?>
                </div>
            </a>
        </header>

        <div class="flex-grow overflow-y-auto p-8">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <script> lucide.createIcons(); </script>
</body>

</html>