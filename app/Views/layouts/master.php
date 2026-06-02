<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> — PetCare</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="icon" href="<?= base_url('favicon-light.svg'); ?>" media="(prefers-color-scheme: light)">
    <link rel="icon" href="<?= base_url('favicon-dark.svg'); ?>" media="(prefers-color-scheme: dark)">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body
    class="bg-[#FAFAFA] text-slate-900 flex flex-col min-h-screen selection:bg-indigo-100 selection:text-indigo-900 antialiased">

    <!-- STICKY NAVBAR -->
    <nav
        class="bg-white/70 sticky top-0 z-50 backdrop-blur-md border-b border-slate-100/80 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex justify-between h-20">
                <!-- LOGO UTAMA -->
                <div class="flex items-center gap-3 group cursor-pointer"
                    onclick="window.location.href='<?= base_url() ?>'">
                    <div
                        class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center border border-indigo-100/50 transition-colors group-hover:bg-indigo-600 duration-300">
                        <i data-lucide="stethoscope"
                            class="w-4 h-4 text-indigo-600 transition-colors group-hover:text-white duration-300"></i>
                    </div>
                    <span
                        class="font-extrabold text-xl tracking-tight bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                        pet<span class="text-indigo-600">care.</span>
                    </span>
                </div>

                <!-- NAVIGASI DESKTOP (TERSEMBUNYI DI MOBILE) -->
                <div
                    class="hidden md:flex items-center gap-10 text-[13px] font-semibold tracking-wide uppercase text-slate-500">
                    <a href="<?= base_url() ?>" class="text-indigo-600 transition-colors">Beranda</a>
                    <a href="#layanan" class="hover:text-slate-900 transition-colors">Layanan</a>
                    <a href="#jadwal" class="hover:text-slate-900 transition-colors">Jadwal Dokter</a>
                    <a href="#kontak" class="hover:text-slate-900 transition-colors">Kontak</a>
                </div>

                <!-- TOMBOL LOGIN / DASHBOARD (DESKTOP) -->
                <div class="hidden md:flex items-center gap-3">
                    <?php if (session()->get('logged_in')): ?>
                        <div class="flex items-center gap-4">
                            <div class="text-right hidden sm:block">
                                <p class="text-[11px] text-slate-400 font-medium leading-none">Halo, Selamat datang</p>
                                <p class="text-xs font-bold text-slate-900 mt-1"><?= session()->get('nama_lengkap') ?></p>
                            </div>
                            <a href="<?= base_url('dashboard') ?>"
                                class="bg-indigo-600 text-white text-[12px] font-bold tracking-wide uppercase px-5 py-2.5 rounded-full hover:bg-slate-950 transition-all duration-300 shadow-sm flex items-center gap-2">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                Dashboard Anda
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>"
                            class="text-slate-600 hover:text-slate-900 text-[12px] font-bold tracking-wide uppercase px-4 py-2.5 transition-colors flex items-center gap-1.5">
                            <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                            Masuk
                        </a>
                        <a href="<?= base_url('register') ?>"
                            class="bg-slate-950 text-white text-[12px] font-bold tracking-wide uppercase px-5 py-2.5 rounded-full hover:bg-indigo-600 transition-all duration-300 shadow-xs flex items-center gap-1.5">
                            <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                            Daftar Pasien
                        </a>
                    <?php endif; ?>
                </div>

                <!-- HAMBURGER BUTTON (HANYA MUNCUL DI MOBILE) -->
                <div class="flex items-center md:hidden">
                    <button type="button" id="hamburger-btn"
                        class="p-2 text-slate-600 hover:text-slate-900 outline-none cursor-pointer">
                        <i data-lucide="menu" id="menu-icon" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- DROPDOWN MENU MOBILE (COLLAPSIBLE) -->
        <div id="mobile-menu"
            class="hidden md:hidden absolute top-20 left-0 w-full bg-white/95 backdrop-blur-md px-6 py-6 space-y-5 border-b border-slate-100 shadow-xl z-50 animate-fade-in">
            <div class="flex flex-col gap-4 text-xs font-bold uppercase tracking-wider text-slate-600">
                <a href="<?= base_url() ?>" class="text-indigo-600 py-1" onclick="toggleMenu()">Beranda</a>
                <a href="#layanan" class="hover:text-slate-900 py-1" onclick="toggleMenu()">Layanan</a>
                <a href="#jadwal" class="hover:text-slate-900 py-1" onclick="toggleMenu()">Jadwal Dokter</a>
                <a href="#kontak" class="hover:text-slate-900 py-1" onclick="toggleMenu()">Kontak</a>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <?php if (session()->get('logged_in')): ?>
                    <div class="space-y-3">
                        <div>
                            <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Akun Terdaftar:</p>
                            <p class="text-xs font-extrabold text-slate-900 mt-0.5"><?= session()->get('nama_lengkap') ?>
                            </p>
                        </div>
                        <a href="<?= base_url('dashboard') ?>"
                            class="w-full justify-center bg-indigo-600 text-white text-[11px] font-bold tracking-wide uppercase py-3 rounded-xl hover:bg-slate-950 transition-all shadow-sm flex items-center gap-2">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                            Masuk ke Dashboard
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="<?= base_url('login') ?>"
                            class="w-full justify-center text-slate-700 bg-slate-50 border border-slate-200/60 text-[11px] font-bold tracking-wide uppercase py-3 rounded-xl flex items-center gap-1.5">
                            <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                            Masuk
                        </a>
                        <a href="<?= base_url('register') ?>"
                            class="w-full justify-center bg-slate-950 text-white text-[11px] font-bold tracking-wide uppercase py-3 rounded-xl flex items-center gap-1.5">
                            <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                            Daftar
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- CONTENT BODY -->
    <main class="flex-grow">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- FOOTER -->
    <footer id="kontak" class="bg-white border-t border-slate-100 pt-20 pb-10">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 text-slate-500 text-sm mb-16">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center border border-slate-200/60">
                        <i data-lucide="stethoscope" class="w-3.5 h-3.5 text-indigo-600"></i>
                    </div>
                    <span class="font-extrabold text-lg tracking-tight text-slate-900">petcare.</span>
                </div>
                <p class="leading-relaxed text-slate-400 max-w-xs">
                    Infrastruktur perawatan kesehatan hewan peliharaan berbasis digital dengan standar pelayanan premium
                    dan transparan.
                </p>
            </div>
            <div class="space-y-3">
                <h4 class="text-slate-900 font-bold tracking-wider text-xs uppercase flex items-center gap-1.5">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i> Jam Operasional
                </h4>
                <div class="space-y-1.5 text-slate-400">
                    <p class="flex justify-between"><span>Senin - Sabtu</span> <span
                            class="text-slate-600 font-medium">08.00 - 20.00</span></p>
                    <p class="flex justify-between"><span>Minggu / Libur</span> <span
                            class="text-slate-600 font-medium">09.00 - 15.00</span></p>
                    <p class="text-indigo-600 font-semibold mt-2 flex items-center gap-1"><span>•</span> Gawat Darurat
                        24 Jam On-Call</p>
                </div>
            </div>
            <div class="space-y-3">
                <h4 class="text-slate-900 font-bold tracking-wider text-xs uppercase flex items-center gap-1.5">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> Lokasi & Kontak
                </h4>
                <div class="space-y-1.5 text-slate-400">
                    <p class="text-slate-600 font-medium flex items-center gap-1.5">Raya Gubeng No. 10, Surabaya</p>
                    <p class="flex items-center gap-1.5 text-slate-500">
                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i> (031) 555-1234
                    </p>
                    <p class="text-emerald-600 font-medium flex items-center gap-1.5">
                        <i data-lucide="message-square" class="w-3.5 h-3.5 text-emerald-500"></i> WhatsApp: +62
                        812-3456-7890
                    </p>
                </div>
            </div>
        </div>
        <div
            class="max-w-6xl mx-auto px-6 border-t border-slate-100 pt-8 flex flex-col sm:flex-row justify-between text-xs text-slate-400 gap-4">
            <p>&copy; <?= date('Y') ?> PetCare Indonesia. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-slate-900">Privacy Policy</a>
                <a href="#" class="hover:text-slate-900">Terms of Service</a>
            </div>
        </div>
    </footer>

    <!-- ENGINE RESPONSIVITAS MOBILE -->
    <script>
        // Inisialisasi awal ikon Lucide
        lucide.createIcons();

        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        // Fungsi Buka-Tutup Menu Mobile
        function toggleMenu() {
            const isHidden = mobileMenu.classList.contains('hidden');

            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                // Ganti ikon hamburger menjadi ikon penutup "X" (close)
                hamburgerBtn.innerHTML = `<i data-lucide="x" id="menu-icon" class="w-6 h-6"></i>`;
            } else {
                mobileMenu.classList.add('hidden');
                // Kembalikan menjadi ikon hamburger biasa
                hamburgerBtn.innerHTML = `<i data-lucide="menu" id="menu-icon" class="w-6 h-6"></i>`;
            }
            // Render ulang komponen ikon Lucide yang baru disuntikkan
            lucide.createIcons();
        }

        hamburgerBtn.addEventListener('click', toggleMenu);
    </script>
</body>

</html>