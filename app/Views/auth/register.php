<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien Baru — PetCare</title>
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

<body class="bg-[#FAFAFA] min-h-screen flex items-center justify-center p-6 antialiased">

    <div class="w-full max-w-2xl space-y-6">
        <div class="text-center space-y-2">
            <div
                class="w-10 h-10 bg-indigo-50 border border-indigo-100/50 rounded-xl flex items-center justify-center mx-auto">
                <i data-lucide="stethoscope" class="w-4 h-4 text-indigo-600"></i>
            </div>
            <h2 class="text-xl font-extrabold text-slate-950 tracking-tight">Registrasi Akun <span
                    class="text-indigo-600">PetCare.</span></h2>
            <p class="text-slate-400 text-xs">Lengkapi data diri pemilik dan anabul pertama Anda untuk mulai menggunakan
                layanan kami.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div
                class="bg-rose-50 border border-rose-100 text-rose-700 text-xs font-medium px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-500 shrink-0"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('registerProcess') ?>" method="POST"
            class="bg-white border border-slate-100 p-8 rounded-3xl shadow-xl shadow-slate-100/40 grid grid-cols-1 md:grid-cols-2 gap-6">
            <?= csrf_field() ?>

            <div class="space-y-4">
                <h3
                    class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest border-b border-slate-50 pb-2 flex items-center gap-2">
                    <i data-lucide="user" class="w-3.5 h-3.5"></i> Data Pemilik / Akun
                </h3>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap
                        Pemilik</label>
                    <input type="text" name="nama_lengkap" required placeholder="Contoh: Aflah Mahdi"
                        class="w-full bg-slate-50 text-slate-900 text-xs font-medium px-4 py-3 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">No. Telepon /
                        WhatsApp</label>
                    <input type="text" name="no_telp" required placeholder="Contoh: 08123456789"
                        class="w-full bg-slate-50 text-slate-900 text-xs font-medium px-4 py-3 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Email</label>
                    <input type="email" name="email" required placeholder="alamat@email.com"
                        class="w-full bg-slate-50 text-slate-900 text-xs font-medium px-4 py-3 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Username</label>
                    <input type="text" name="username" required placeholder="Buat nama pengguna..."
                        class="w-full bg-slate-50 text-slate-900 text-xs font-medium px-4 py-3 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter..."
                        class="w-full bg-slate-50 text-slate-900 text-xs font-medium px-4 py-3 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Alamat
                        Rumah</label>
                    <textarea name="alamat" required placeholder="Alamat lengkap tempat tinggal..." rows="2"
                        class="w-full bg-slate-50 text-slate-900 text-xs font-medium px-4 py-3 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all resize-none"></textarea>
                </div>
            </div>

            <div class="space-y-4 flex flex-col justify-between">
                <div class="space-y-4">
                    <h3
                        class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest border-b border-slate-50 pb-2 flex items-center gap-2">
                        <i data-lucide="heart" class="w-3.5 h-3.5"></i> Data Hewan Pertama
                    </h3>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama
                            Hewan</label>
                        <input type="text" name="nama_hewan" required placeholder="Contoh: Milo, Chiki"
                            class="w-full bg-slate-50 text-slate-900 text-xs font-medium px-4 py-3 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jenis
                            Hewan</label>
                        <div class="relative flex items-center">
                            <select name="jenis_hewan" required
                                class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none cursor-pointer text-slate-800">
                                <option value="" disabled selected>Pilih Jenis...</option>
                                <option value="Kucing">Kucing</option>
                                <option value="Anjing">Anjing</option>
                                <option value="Kelinci">Kelinci</option>
                                <option value="Burung">Burung</option>
                                <option value="Reptil/Eksotis">Reptil/Eksotis</option>
                            </select>
                            <i data-lucide="chevron-down"
                                class="w-4 h-4 text-slate-400 absolute right-4 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Ras
                            Hewan</label>
                        <input type="text" name="ras" required placeholder="Contoh: Persia, Domestik"
                            class="w-full bg-slate-50 text-slate-900 text-xs font-medium px-4 py-3 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Lahir
                            Hewan</label>
                        <input type="date" name="tgl_lahir"
                            class="w-full bg-slate-50 text-slate-900 text-xs font-medium px-4 py-3 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                    </div>
                </div>

                <div class="pt-4 md:pt-0">
                    <button type="submit"
                        class="w-full bg-slate-950 hover:bg-indigo-600 text-white text-xs font-bold tracking-wider uppercase py-4 rounded-xl shadow-md transition-all duration-300 cursor-pointer">
                        Selesaikan Pendaftaran
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center">
            <p class="text-xs text-slate-400">Sudah punya akun pasien? <a href="<?= base_url('login') ?>"
                    class="text-indigo-600 font-bold hover:underline">Masuk Portal</a></p>
        </div>
    </div>

    <script> lucide.createIcons(); </script>
</body>

</html>