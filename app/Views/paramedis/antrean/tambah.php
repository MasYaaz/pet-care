<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Check-in Kunjungan Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-2xl mx-auto">
    <div>
        <a href="<?= base_url('paramedis/antrean') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Antrean
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Pendaftaran & Cetak Karcis Antrean</h1>
        <p class="text-slate-400 text-xs mt-1">Alokasikan pasien ke jadwal dokter hewan yang sedang aktif hari ini.</p>
    </div>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('paramedis/antrean/simpan') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Pilih Pasien Hewan
                    Terdaftar</label>
                <div class="relative flex items-center">
                    <select name="id_pasien" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-100 outline-none transition-all appearance-none cursor-pointer text-slate-800">
                        <option value="" disabled selected>Cari nama anabul / nama pemilik...</option>
                        <?php foreach ($pasien as $p): ?>
                            <option value="<?= $p['ID_PASIEN'] ?>">
                                🐾 <?= esc($p['NAMA_HEWAN']) ?> — [Pemilik: <?= esc($p['NAMA_PEMILIK']) ?>]
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i data-lucide="chevron-down"
                        class="w-4 h-4 text-slate-400 absolute right-4 pointer-events-none"></i>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Anabul belum terdaftar? <a
                        href="<?= base_url('paramedis/pasien/tambah') ?>"
                        class="text-indigo-600 font-bold hover:underline">Registrasi data pasien baru dahulu</a>.</p>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Dokter Hewan Tujuan /
                    Ruang Praktik</label>
                <div class="relative flex items-center">
                    <select name="id_jadwal" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-100 outline-none transition-all appearance-none cursor-pointer text-slate-800">
                        <option value="" disabled selected>Pilih Sesi & Dokter Hewan Aktif...</option>

                        <?php foreach ($jadwal_dokter as $j): ?>
                            <option value="<?= $j['ID_JADWAL'] ?>">
                                👨‍⚕️ <?= esc($j['NAMA_DOKTER']) ?> — [Hari <?= esc($j['HARI']) ?>:
                                <?= date('H:i', strtotime($j['JAM_MULAI'])) ?> -
                                <?= date('H:i', strtotime($j['JAM_SELESAI'])) ?>]
                            </option>
                        <?php endforeach; ?>

                    </select>
                    <i data-lucide="chevron-down"
                        class="w-4 h-4 text-slate-400 absolute right-4 pointer-events-none"></i>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Keluhan Awal / Gejala
                    Klinis Fisik</label>
                <textarea name="keluhan" rows="3" required
                    placeholder="Contoh: Kucing lemas tidak mau makan selama 2 hari, muntah busa kuning tadi pagi..."
                    class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-100 outline-none transition-all resize-none text-slate-800"></textarea>
            </div>

            <div class="p-4 bg-amber-50/60 border border-amber-100 rounded-xl flex items-start gap-3 mt-2">
                <i data-lucide="printer" class="w-4 h-4 text-amber-600 shrink-0 mt-0.5"></i>
                <div class="space-y-0.5">
                    <h5 class="text-[11px] font-bold text-amber-950 uppercase tracking-wider">Auto-Generate Antrean</h5>
                    <p class="text-slate-500 text-[10px] leading-relaxed">Sistem akan mengalkulasi total antrean dokter
                        tersebut secara otomatis pada hari ini, memplot nomor urut terkini, dan siap dicetak melalui
                        printer thermal loket.</p>
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('paramedis/antrean') ?>"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">
                    Kembali
                </a>
                <button type="submit"
                    class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm hover:shadow-amber-100 uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="ticket-plus" class="w-4 h-4"></i> Cetak Karcis & Check-in
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>