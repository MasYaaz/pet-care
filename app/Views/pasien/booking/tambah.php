<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Booking Jadwal Dokter
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-2xl mx-auto">
    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Ajukan Booking Jadwal Dokter</h1>
        <p class="text-slate-400 text-xs mt-1">Pilih anabul Anda, tentukan sesi praktik dokter hewan andalan, dan buat
            janji temu kunjungan.</p>
    </div>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('pasien/booking/simpan') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Pilih Anabul
                    Anda</label>
                <div class="relative flex items-center">
                    <select name="id_pasien" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none cursor-pointer text-slate-800">
                        <option value="" disabled selected>Pilih peliharaan Anda...</option>
                        <?php foreach ($my_anabul as $pet): ?>
                            <option value="<?= $pet['ID_PASIEN'] ?>">
                                🐾
                                <?= esc($pet['NAMA_HEWAN']) ?> (
                                <?= esc($pet['JENIS_HEWAN']) ?> —
                                <?= esc($pet['RAS']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i data-lucide="chevron-down"
                        class="w-4 h-4 text-slate-400 absolute right-4 pointer-events-none"></i>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Pilih Dokter & Sesi
                    Praktik</label>
                <div class="relative flex items-center">
                    <select name="id_jadwal" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none cursor-pointer text-slate-800">
                        <option value="" disabled selected>Pilih Sesi & Dokter Hewan...</option>
                        <?php foreach ($jadwal_dokter as $j): ?>
                            <option value="<?= $j['ID_JADWAL'] ?>">
                                👨‍⚕️
                                <?= esc($j['NAMA_DOKTER']) ?> — [Hari
                                <?= esc($j['HARI']) ?>:
                                <?= esc($j['JAM_MULAI']) ?> -
                                <?= esc($j['JAM_SELESAI']) ?>]
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i data-lucide="chevron-down"
                        class="w-4 h-4 text-slate-400 absolute right-4 pointer-events-none"></i>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Tanggal Rencana
                    Kunjungan</label>
                <input type="date" name="tanggal_kunjungan" min="<?= date('Y-m-d') ?>" required
                    class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all text-slate-800">
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Tulis Keluhan / Gejala
                    Sakit Anabul</label>
                <textarea name="keluhan" rows="3" required
                    placeholder="Ceritakan kondisi atau tujuan kunjungan Anda (misal: Mau vaksin tahunan, atau anabul sedang gatal-gatal rontok parah...)"
                    class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all resize-none text-slate-800"></textarea>
            </div>

            <div class="p-4 bg-indigo-50/60 border border-indigo-100 rounded-xl flex items-start gap-3 mt-2">
                <i data-lucide="info" class="w-4 h-4 text-indigo-600 shrink-0 mt-0.5"></i>
                <div class="space-y-0.5">
                    <h5 class="text-[11px] font-bold text-indigo-950 uppercase tracking-wider">Konfirmasi Otomatis</h5>
                    <p class="text-slate-500 text-[10px] leading-relaxed">Pengajuan janji temu Anda akan langsung
                        tersinkronisasi ke dashboard staf klinik. Anda cukup datang ke meja loket pendaftaran sesuai
                        dengan hari pilihan Anda untuk mengambil nomor urut fisik.</p>
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('dashboard') ?>"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">
                    Batal
                </a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm hover:shadow-indigo-100 uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="bookmark-check" class="w-4 h-4"></i> Ajukan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>