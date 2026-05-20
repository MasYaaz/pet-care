<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PetCare</title>
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

<body class="bg-[#FAFAFA] min-h-screen flex items-center justify-center p-6 antialiased">

    <div class="w-full max-w-sm space-y-8">
        <div class="text-center space-y-3">
            <div
                class="w-11 h-11 bg-indigo-50 border border-indigo-100/50 rounded-xl flex items-center justify-center mx-auto">
                <i data-lucide="stethoscope" class="w-5 h-5 text-indigo-600"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-950 tracking-tight">Portal <span
                    class="text-indigo-600">PetCare.</span></h2>
            <p class="text-slate-400 text-xs">Masukkan Username dan password anda.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div
                class="bg-rose-50 border border-rose-100 text-rose-700 text-xs font-medium px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-500 shrink-0"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('loginProcess') ?>" method="POST"
            class="bg-white border border-slate-100 p-8 rounded-3xl shadow-xl shadow-slate-100/50 space-y-5">
            <?= csrf_field() ?>

            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Username</label>
                <div class="relative flex items-center">
                    <i data-lucide="user" class="w-4 h-4 text-slate-300 absolute left-4"></i>
                    <input type="text" name="username" required placeholder="Masukkan username..."
                        class="w-full bg-slate-50 text-slate-900 text-xs font-medium pl-11 pr-4 py-3.5 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                </div>
            </div>

            <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Password</label>
                </div>
                <div class="relative flex items-center">
                    <i data-lucide="lock" class="w-4 h-4 text-slate-300 absolute left-4"></i>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full bg-slate-50 text-slate-900 text-xs font-medium pl-11 pr-4 py-3.5 rounded-xl border border-slate-200/60 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-slate-950 hover:bg-indigo-600 text-white text-xs font-bold tracking-wider uppercase py-4 rounded-xl shadow-md transition-all duration-300 cursor-pointer mt-2">
                Masuk Sistem
            </button>
        </form>

        <div class="text-center">
            <a href="<?= base_url('/') ?>"
                class="text-slate-400 hover:text-slate-900 text-xs inline-flex items-center gap-1 transition-colors">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Beranda Umum
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>