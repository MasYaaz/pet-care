<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> — Admin PetCare</title>
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
                class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-xl">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </a>

            <?php if (session()->get('id_role') == 2): ?>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mt-6 mb-2">Operasional Klinik
                </p>

                <a href="<?= base_url('paramedis/pasien') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="users" class="w-4 h-4"></i> Data Pasien
                </a>

                <a href="<?= base_url('paramedis/antrean') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="calendar" class="w-4 h-4"></i> Registrasi Antrean
                </a>

                <a href="<?= base_url('paramedis/kasir') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="credit-card" class="w-4 h-4"></i> Kasir & Billing
                </a>
            <?php endif; ?>

            <?php if (session()->get('id_role') == 4): ?>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mt-6 mb-2">Manajemen Utama</p>

                <a href="<?= base_url('admin/dokter') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="shield-alert" class="w-4 h-4"></i> Kelola Akun Dokter
                </a>

                <a href="<?= base_url('admin/paramedis') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="contact" class="w-4 h-4"></i> Kelola Akun Paramedis
                </a>
            <?php endif; ?>

            <?php if (session()->get('id_role') == 1): ?>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="stethoscope" class="w-4 h-4"></i> Ruang Tunggu Medis
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="clipboard-list" class="w-4 h-4"></i> Input Rekam Medis
                </a>
            <?php endif; ?>

            <?php if (session()->get('id_role') == 3): ?>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mt-6 mb-2">Portal Pet Owner
                </p>

                <a href="<?= base_url('pasien/anabul') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="smile" class="w-4 h-4"></i> Profil Anabulku
                </a>

                <a href="<?= base_url('pasien/booking') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="bookmark" class="w-4 h-4"></i> Booking Jadwal
                </a>
            <?php endif; ?>

            <?php if (session()->get('id_role') == 1 || session()->get('id_role') == 2): ?>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mt-8 mb-2">Gudang</p>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all">
                    <i data-lucide="pill" class="w-4 h-4"></i> Manajemen Obat
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
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-slate-900 leading-none"><?= session()->get('nama_lengkap') ?></p>
                    <p class="text-[10px] font-semibold text-indigo-600 uppercase tracking-wider mt-1">
                        <?= session()->get('nama_role') ?>
                    </p>
                </div>
                <div
                    class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center border border-slate-200">
                    <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                </div>
            </div>
        </header>

        <div class="flex-grow overflow-y-auto p-8">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <script> lucide.createIcons(); </script>
</body>

</html>