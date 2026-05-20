<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Pemeriksaan Medis Pasien<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-5xl mx-auto">
    <div>
        <a href="<?= base_url('dokter/ruang-tunggu') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Ruang Tunggu
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Lembar Hasil Pemeriksaan Klinis</h1>
        <p class="text-slate-400 text-xs mt-1">Pasien Hewan: <span class="font-bold text-slate-800">🐾
                <?= esc($antrean['NAMA_HEWAN']) ?></span></p>
    </div>

    <form action="<?= base_url('dokter/rekam-medis/simpan') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>

        <input type="hidden" name="id_reservasi" value="<?= $antrean['ID_RESERVASI'] ?>">
        <input type="hidden" name="id_pasien" value="<?= $antrean['ID_PASIEN'] ?>">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <div class="lg:col-span-5 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-4 h-fit">
                <h3
                    class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-50">
                    <i data-lucide="clipboard-list" class="w-4 h-4 text-indigo-600"></i> Rekam Data Medis
                </h3>

                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Hasil Diagnosa
                        Penyakit</label>
                    <textarea name="diagnosa" rows="6" required
                        placeholder="Tulis analisa diagnosa klinis penyakit anabul di sini..."
                        class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all resize-none text-slate-800"></textarea>
                </div>
            </div>

            <div
                class="lg:col-span-7 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-6 flex flex-col justify-between">
                <div class="space-y-5">
                    <h3
                        class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-50">
                        <i data-lucide="receipt" class="w-4 h-4 text-indigo-600"></i> Rincian Billing Tindakan & Obat
                    </h3>

                    <div class="p-4 bg-slate-50 rounded-xl flex justify-between items-center text-xs">
                        <div>
                            <p class="font-bold text-slate-800">Biaya Jasa Konsultasi Dokter</p>
                            <p class="text-[10px] text-slate-400">Tarif dasar pemeriksaan umum</p>
                        </div>
                        <input type="number" name="biaya_copy" id="biaya_konsultasi_visual" value="50000" disabled
                            class="w-32 text-right text-xs font-bold font-mono px-3 py-2 bg-white border border-slate-200 rounded-lg outline-none text-slate-400">
                        <input type="hidden" name="biaya_consultation" id="biaya_konsultasi" value="50000">
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Tindakan Medis
                                Klinik</label>
                            <button type="button" onclick="addBaris('container-tindakan', 'tindakan')"
                                class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 cursor-pointer">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Tindakan
                            </button>
                        </div>
                        <div id="container-tindakan" class="space-y-2"></div>
                    </div>

                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <div class="flex justify-between items-center">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Resep Obat &
                                Alkes Apotek</label>
                            <button type="button" onclick="addBaris('container-obat', 'obat')"
                                class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 cursor-pointer">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Obat
                            </button>
                        </div>
                        <div id="container-obat" class="space-y-2"></div>
                    </div>
                </div>

                <div
                    class="p-4 bg-indigo-50/60 border border-indigo-100 rounded-2xl flex justify-between items-center mt-6">
                    <div>
                        <span class="text-xs font-bold text-indigo-950 uppercase tracking-wider block">Total Tagihan
                            Kasir:</span>
                        <span class="text-[10px] text-slate-400 font-medium">Otomatis menghitung (Jasa + Tindakan +
                            Obat)</span>
                    </div>
                    <span class="text-base font-black text-indigo-700 font-mono" id="live-total">Rp 50.000</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center gap-3 pt-2">
            <a href="<?= base_url('dokter/ruang-tunggu') ?>"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">
                Batalkan
            </a>
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="check-square" class="w-4 h-4"></i> Selesai Periksa & Kirim Nota
            </button>
        </div>
    </form>
</div>

<script>
    // Injeksi data master PHP array ke JavaScript object
    const masterTindakan = <?= json_encode($master_tindakan) ?>;
    const masterObat = <?= json_encode($master_obat) ?>;

    function addBaris(containerId, jenis) {
        const container = document.getElementById(containerId);
        const uniqueId = Date.now();

        const div = document.createElement('div');
        div.id = `row-${uniqueId}`;

        let options = `<option value="" disabled selected>Pilih ${jenis == 'tindakan' ? 'Tindakan' : 'Obat'}...</option>`;
        const dataList = (jenis == 'tindakan') ? masterTindakan : masterObat;

        dataList.forEach(item => {
            if (jenis == 'tindakan') {
                options += `<option value="${item.ID_TINDAKAN}" data-harga="${item.HARGA}">${item.NAMA_TINDAKAN}</option>`;
            } else {
                options += `<option value="${item.ID_OBAT}" data-harga="${item.HARGA_SATUAN_OBAT}">${item.NAMA_OBAT} (Stok: ${item.STOK})</option>`;
            }
        });

        if (jenis === 'tindakan') {
            div.className = "flex gap-2 items-center table-row-animate";
            div.innerHTML = `
                <select name="id_tindakan[]" required onchange="updateHargaOtomatis(this)"
                    class="flex-1 text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:bg-white focus:border-indigo-500 text-slate-800 text-ellipsis overflow-hidden">
                    ${options}
                </select>
                <input type="number" name="tindakan_qty[]" placeholder="Qty" required value="1" min="1" oninput="calculateTotal()"
                    class="w-16 text-center text-xs px-2 py-2 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:bg-white item-qty text-slate-800">
                <input type="number" name="tindakan_harga[]" placeholder="Harga" required value="0" readonly
                    class="w-28 text-right text-xs font-mono px-3 py-2 bg-slate-100 border border-slate-200 rounded-lg outline-none item-harga text-slate-500">
                <button type="button" onclick="removeBaris('row-${uniqueId}')" class="text-slate-400 hover:text-rose-600 p-1 cursor-pointer">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            `;
        } else {
            div.className = "space-y-2 p-3 bg-slate-50/50 border border-slate-100 rounded-xl table-row-animate";
            div.innerHTML = `
                <div class="flex gap-2 items-center">
                    <select name="id_obat[]" required onchange="updateHargaOtomatis(this)"
                        class="flex-1 text-xs px-3 py-2 bg-white border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-slate-800">
                        ${options}
                    </select>
                    <input type="number" name="obat_qty[]" placeholder="Qty" required value="1" min="1" oninput="calculateTotal()"
                        class="w-16 text-center text-xs px-2 py-2 bg-white border border-slate-200 rounded-lg outline-none focus:border-indigo-500 item-qty text-slate-800">
                    <input type="number" name="obat_harga[]" placeholder="Harga" required value="0" readonly
                        class="w-28 text-right text-xs font-mono px-3 py-2 bg-slate-100 border border-slate-200 rounded-lg outline-none item-harga text-slate-500">
                    <button type="button" onclick="removeBaris('row-${uniqueId}')" class="text-slate-400 hover:text-rose-600 p-1 cursor-pointer">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="obat_dosis[]" required placeholder="Dosis (Misal: 2 x 1/2 Tab, 3 x 1 sendok)"
                        class="text-[11px] px-3 py-1.5 bg-white border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-slate-700">
                    <input type="text" name="obat_aturan[]" required placeholder="Aturan Pakai (Misal: Sesudah Makan)"
                        class="text-[11px] px-3 py-1.5 bg-white border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-slate-700">
                </div>
            `;
        }

        container.appendChild(div);
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function updateHargaOtomatis(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga') || 0;

        const row = selectElement.parentElement;
        row.querySelector('.item-harga').value = harga;

        calculateTotal();
    }

    function removeBaris(rowId) {
        document.getElementById(rowId)?.remove();
        calculateTotal();
    }

    function calculateTotal() {
        let total = parseInt(document.getElementById('biaya_konsultasi').value) || 0;

        const rows = document.querySelectorAll('#container-tindakan > div, #container-obat > div');
        rows.forEach(row => {
            const harga = parseInt(row.querySelector('.item-harga').value) || 0;
            const qty = parseInt(row.querySelector('.item-qty').value) || 1;
            total += (harga * qty);
        });

        document.getElementById('live-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Inisialisasi baris kosong pertama demi kenyamanan UX dokter
    window.addEventListener('DOMContentLoaded', () => {
        addBaris('container-tindakan', 'tindakan');
        addBaris('container-obat', 'obat');
    });
</script>
<?= $this->endSection() ?>