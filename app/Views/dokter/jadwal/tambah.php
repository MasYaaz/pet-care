<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Buka Jadwal Praktik
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-xl mx-auto">
    <div>
        <a href="<?= base_url('dokter/jadwal') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke List Jadwal
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Buka Slot Operasional Baru</h1>
        <p class="text-slate-400 text-xs mt-1">Tambahkan hari ketersediaan Anda di klinik agar sistem reservasi online
            klien dapat mendeteksi jadwal Anda.</p>
    </div>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('dokter/jadwal/simpan') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Hari Kerja
                    Praktik</label>
                <div class="relative flex items-center">
                    <select name="hari" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none cursor-pointer text-slate-800">
                        <option value="" disabled selected>Pilih Hari...</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                    <i data-lucide="chevron-down"
                        class="w-4 h-4 text-slate-400 absolute right-4 pointer-events-none"></i>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Jam Mulai</label>
                    <input type="time" name="jam_mulai" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Jam
                        Selesai</label>
                    <input type="time" name="jam_selesai" required
                        class="w-full text-xs font-semibold px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-3 border-t border-slate-50">
                <a href="<?= base_url('dokter/jadwal') ?>"
                    class="bg-slate-100 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">Batal</a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="check" class="w-4 h-4"></i> Aktifkan Slot
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>