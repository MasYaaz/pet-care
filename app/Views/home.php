<?= $this->extend('layouts/master') ?>

<?= $this->section('title') ?>Klinik Hewan Modern & Terpercaya<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section
    class="max-w-6xl mx-auto px-6 pt-16 pb-24 md:pt-24 md:pb-36 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
        <div
            class="inline-flex items-center gap-2 bg-indigo-50/60 border border-indigo-100/50 text-indigo-700 text-[11px] font-bold tracking-widest uppercase px-4 py-1.5 rounded-full">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-ping"></span>
            Klinik Hewan Digital Modern
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-950 tracking-tight leading-[1.1]">
            Standardisasi Baru Perawatan <span class="text-indigo-600 font-medium italic">Anabul.</span>
        </h1>
        <p class="text-slate-500 text-base sm:text-lg max-w-xl mx-auto lg:mx-0 font-normal leading-relaxed">
            Menyatukan keahlian medis veteriner profesional dengan transparansi data rekam medis terintegrasi demi
            kenyamanan penuh hewan peliharaan Anda.
        </p>
        <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
            <a href="#cek-status"
                class="bg-indigo-600 text-white text-xs font-bold tracking-wider uppercase px-7 py-4 rounded-full hover:bg-slate-950 hover:shadow-xl hover:shadow-slate-200 transition-all duration-300 flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i> Lacak Antrean Kunjungan
            </a>
            <a href="#jadwal"
                class="bg-white border border-slate-200 text-slate-700 text-xs font-bold tracking-wider uppercase px-7 py-4 rounded-full hover:bg-slate-50 transition-all duration-300 flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4"></i> Jadwal Praktik Dokter
            </a>
        </div>
    </div>

    <div class="lg:col-span-5 hidden lg:flex justify-center relative">
        <div
            class="w-72 h-72 bg-gradient-to-tr from-indigo-50 to-violet-100 rounded-full blur-3xl absolute -z-10 opacity-70">
        </div>
        <div
            class="w-56 h-56 border border-slate-100 bg-white shadow-xl shadow-slate-100 rounded-3xl flex items-center justify-center group hover:scale-105 transition-transform duration-500">
            <i data-lucide="shield-check"
                class="w-24 h-24 text-indigo-500 stroke-[1.25] group-hover:text-indigo-600 transition-colors"></i>
        </div>
    </div>
</section>

<section id="layanan" class="border-t border-slate-100 bg-white py-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-4">
            <div>
                <span
                    class="text-indigo-600 text-[11px] font-bold tracking-widest uppercase block mb-2">Fasilitas</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 tracking-tight">Layanan Medis & Estimasi
                    Biaya</h2>
            </div>
            <p class="text-slate-400 text-sm max-w-xs">Tarif penanganan transparan tanpa biaya tambahan tersembunyi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($tindakan as $t): ?>
                <div
                    class="border border-slate-100 bg-white p-7 rounded-2xl hover:border-indigo-500/30 hover:shadow-xl hover:shadow-slate-100/80 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div
                            class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-lg mb-6 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors duration-300">
                            <i data-lucide="stethoscope"
                                class="w-5 h-5 text-slate-400 group-hover:text-indigo-600 transition-colors"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 tracking-tight mb-2"><?= $t['NAMA_TINDAKAN'] ?></h3>
                        <p class="text-slate-400 text-xs leading-relaxed mb-6 font-normal"><?= $t['DESKRIPSI'] ?></p>
                    </div>
                    <div class="pt-4 border-t border-slate-50">
                        <span class="text-[10px] text-slate-400 font-bold tracking-wider uppercase block mb-0.5">Biaya
                            Terstandar:</span>
                        <p class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">Rp
                            <?= number_format($t['HARGA'], 0, ',', '.') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="jadwal" class="border-t border-slate-100 py-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-16 space-y-2">
            <span class="text-indigo-600 text-[11px] font-bold tracking-widest uppercase block">Veterinary Team</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 tracking-tight">Dokter Spesialis Aktif</h2>
            <p class="text-slate-400 text-sm font-normal">Silakan pilih jadwal kedatangan terbaik untuk penanganan
                anabul.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($jadwal_dokter as $jd): ?>
                <div
                    class="bg-white border border-slate-100 rounded-2xl p-7 hover:shadow-lg hover:shadow-slate-100/50 transition-all duration-300 flex flex-col justify-between">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-11 h-11 bg-slate-950 text-white rounded-full flex items-center justify-center text-xs font-bold tracking-wide uppercase">
                            <?= substr($jd['NAMA_DOKTER'], 0, 2) ?>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm tracking-tight"><?= $jd['NAMA_DOKTER'] ?></h3>
                            <p class="text-[11px] font-semibold text-slate-400 tracking-wider uppercase mt-0.5">
                                <?= $jd['SPESIALISASI'] ?></p>
                        </div>
                    </div>

                    <div class="space-y-2.5 pt-4 border-t border-slate-50 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-medium flex items-center gap-1"><i data-lucide="calendar-days"
                                    class="w-3.5 h-3.5"></i> Hari Kerja</span>
                            <span
                                class="font-bold text-slate-800 bg-slate-50 px-2.5 py-1 rounded-md"><?= $jd['HARI'] ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-medium flex items-center gap-1"><i data-lucide="activity"
                                    class="w-3.5 h-3.5"></i> Sesi Jam</span>
                            <span class="font-semibold text-slate-700"><?= substr($jd['JAM_MULAI'], 0, 5) ?> -
                                <?= substr($jd['JAM_SELESAI'], 0, 5) ?> WIB</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-medium flex items-center gap-1"><i data-lucide="users"
                                    class="w-3.5 h-3.5"></i> Sisa Slot Pasien</span>
                            <span class="text-indigo-600 font-bold"><?= $jd['KUOTA'] ?> Kuota</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="cek-status" class="border-t border-slate-100 bg-white py-24">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <div class="space-y-4 mb-10">
            <span class="text-indigo-600 text-[11px] font-bold tracking-widest uppercase block">Live Tracking</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 tracking-tight">Pantau Antrean Real-time</h2>
            <p class="text-slate-400 text-sm max-w-sm mx-auto font-normal">Periksa progres pemeriksaan medis anabul Anda
                tanpa perlu mengantre lama di ruang tunggu.</p>
        </div>

        <form
            class="flex flex-col sm:flex-row gap-3 bg-slate-50 p-2 rounded-2xl border border-slate-200/60 max-w-lg mx-auto transition-all focus-within:border-indigo-500 focus-within:bg-white focus-within:shadow-xl focus-within:shadow-indigo-50/50">
            <input type="text" placeholder="Masukkan Kode Transaksi / ID Reservasi..."
                class="bg-transparent text-slate-900 px-4 py-3.5 rounded-xl flex-grow focus:outline-none font-medium placeholder-slate-400 text-xs tracking-wide">
            <button type="submit"
                class="bg-slate-950 hover:bg-indigo-600 text-white text-[11px] font-bold tracking-wider uppercase px-6 py-3.5 rounded-xl transition-all duration-300 shrink-0 flex items-center justify-center gap-1.5">
                <i data-lucide="search" class="w-3.5 h-3.5"></i> Cari Data Pasien
            </button>
        </form>
    </div>
</section>
<?= $this->endSection() ?>