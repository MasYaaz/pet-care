<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Kasir & Billing Finansial<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Billing & Kasir Pembayaran</h1>
            <p class="text-slate-400 text-xs mt-1">Proses pelunasan biaya tindakan medis, administrasi klinik, dan
                penebusan nota obat pasien.</p>
        </div>
        <div
            class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-4 py-2 rounded-xl flex items-center gap-2">
            <i data-lucide="banknote" class="w-4 h-4"></i>
            Kasir Utama Terbuka
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div
            class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-emerald-800 text-xs font-semibold">
            <i data-lucide="check-square" class="w-4 h-4 text-emerald-600 shrink-0"></i>
            <span><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div
            class="flex items-center gap-3 bg-rose-50 border border-rose-100 p-4 rounded-xl text-rose-800 text-xs font-semibold">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Daftar Invoice Tagihan</h3>
            <span
                class="text-[10px] bg-slate-100 font-extrabold px-2.5 py-1 rounded-md text-slate-500 uppercase tracking-wide">
                Sesi Hari Ini: <?= date('d M Y') ?>
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-28">No.
                            Invoice</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pasien &
                            Pemilik</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total
                            Tagihan</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Status</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Metode</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <?php if (empty($list_billing)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i data-lucide="receipt" class="w-8 h-8 text-slate-300"></i>
                                    <p>Belum ada nota tagihan yang diterbitkan oleh dokter hari ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list_billing as $bill): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-xs font-mono font-bold text-slate-900">
                                    #INV-<?= $bill['ID_PEMBAYARAN'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-900">🐾 <?= esc($bill['NAMA_HEWAN']) ?></p>
                                    <p class="text-[10px] text-slate-400 font-medium">Owner: <?= esc($bill['NAMA_PEMILIK']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-800">
                                    Rp <?= number_format($bill['TOTAL_TAGIHAN'], 0, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($bill['STATUS_BAYAR'] === 'Lunas'): ?>
                                        <span
                                            class="inline-block text-[9px] font-extrabold px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-md uppercase tracking-wide">
                                            Lunas
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-block text-[9px] font-extrabold px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-100 rounded-md uppercase tracking-wide animate-pulse">
                                            Belum Bayar
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center text-xs font-medium text-slate-500">
                                    <?= $bill['NAMA_METODE_BAYAR'] ? esc($bill['NAMA_METODE_BAYAR']) : '—' ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($bill['STATUS_BAYAR'] === 'Belum Bayar'): ?>
                                        <form action="<?= base_url('paramedis/kasir/bayar/' . $bill['ID_PEMBAYARAN']) ?>"
                                            method="POST" class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                            <?= csrf_field() ?>
                                            <select name="id_metode_bayar" required
                                                class="text-[11px] font-semibold px-2 py-1.5 bg-slate-50 border border-slate-200 rounded-lg outline-none">
                                                <option value="1">Tunai</option>
                                                <option value="2">QRIS</option>
                                                <option value="3">Transfer Mandiri</option>
                                            </select>
                                            <input type="number" name="jumlah_bayar" required min="<?= $bill['TOTAL_TAGIHAN'] ?>"
                                                placeholder="Uang bayar..."
                                                class="w-24 text-[11px] font-semibold px-2 py-1.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-emerald-500">
                                            <button type="submit"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wider transition-all cursor-pointer">
                                                Selesai
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="flex items-center justify-center">
                                            <button type="button" data-invoice="#INV-<?= $bill['ID_PEMBAYARAN'] ?>"
                                                data-kode="<?= esc($bill['KODE_TRANSAKSI'] ?? 'TX-' . time()) ?>"
                                                data-hewan="<?= esc($bill['NAMA_HEWAN']) ?>"
                                                data-pemilik="<?= esc($bill['NAMA_PEMILIK']) ?>"
                                                data-total="<?= $bill['TOTAL_TAGIHAN'] ?>"
                                                data-konsul="<?= $bill['BIAYA_KONSULTASI'] ?>"
                                                data-tindakan="<?= $bill['SUBTOTAL_TINDAKAN'] ?>"
                                                data-obat="<?= $bill['SUBTOTAL_OBAT'] ?>"
                                                data-bayar="<?= $bill['JUMLAH_BAYAR'] ?? $bill['TOTAL_TAGIHAN'] ?>"
                                                data-kembalian="<?= $bill['KEMBALIAN'] ?? 0 ?>"
                                                data-metode="<?= $bill['NAMA_METODE_BAYAR'] ? esc($bill['NAMA_METODE_BAYAR']) : 'Tunai' ?>"
                                                class="btn-print border border-slate-200 text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 text-[10px] font-bold px-4 py-1.5 rounded-lg transition-all flex items-center gap-1 cursor-pointer">
                                                <i data-lucide="printer" class="w-3.5 h-3.5"></i> Cetak Kuitansi
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();

        // Cari seluruh tombol cetak yang aktif di tabel
        const printButtons = document.querySelectorAll('.btn-print');

        printButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ekstrak seluruh metadata billing dari data-attributes HTML
                const inv = this.getAttribute('data-invoice');
                const kode = this.getAttribute('data-kode');
                const hewan = this.getAttribute('data-hewan');
                const pemilik = this.getAttribute('data-pemilik');
                const total = parseInt(this.getAttribute('data-total')) || 0;
                const konsul = parseInt(this.getAttribute('data-konsul')) || 0;
                const tindakan = parseInt(this.getAttribute('data-tindakan')) || 0;
                const obat = parseInt(this.getAttribute('data-obat')) || 0;
                const bayar = parseInt(this.getAttribute('data-bayar')) || 0;
                const kembalian = parseInt(this.getAttribute('data-kembalian')) || 0;
                const metode = this.getAttribute('data-metode');

                // Jalankan mesin fungsi cetak layout struk thermal 58mm/80mm
                printThermalReceipt({
                    inv, kode, hewan, pemilik, total, konsul, tindakan, obat, bayar, kembalian, metode
                });
            });
        });
    });

    // ENGINE PRINT CETAK STRUK THERMAL
    function printThermalReceipt(data) {
        // Buat jendela frame bayangan baru (iframe) di memori RAM browser
        const iframe = document.createElement('iframe');
        iframe.style.position = 'absolute';
        iframe.style.width = '0px';
        iframe.style.height = '0px';
        iframe.style.border = 'none';

        document.body.appendChild(iframe);

        const doc = iframe.contentWindow.document;
        const formatIdr = (num) => num.toLocaleString('id-ID');

        // Suntikkan struktur template struk POS dengan style minimalis premium modern
        doc.open();
        doc.write(`
            <html>
            <head>
                <title>Cetak Struk Pembayaran</title>
                <style>
                    @page { 
                        size: auto; 
                        margin: 0mm; 
                    }
                    body {
                        font-family: 'Courier New', Courier, monospace;
                        width: 52mm; /* Dioptimalkan dari 54mm agar teks tidak mepet ke bagian sobekan kertas */
                        margin: 0 auto;
                        padding: 2mm 1mm;
                        font-size: 10px; /* Diturunkan ke 10px agar teks data tidak mudah patah baris */
                        color: #000;
                        background: #fff;
                        line-height: 1.4;
                    }
                    .text-center { text-align: center; }
                    .text-right { text-align: right; }
                    .text-left { text-align: left; }
                    .font-bold { font-weight: bold; }
                    .uppercase { text-transform: uppercase; }
                    
                    /* Header Sektor */
                    .brand-header { 
                        display: flex; 
                        align-items: center; 
                        justify-content: center; 
                        gap: 8px; 
                        margin: 4px 0 2px 0; 
                    }
                    .brand-logo { 
                        width: 18px; 
                        height: 18px; 
                        object-fit: contain; 
                    }
                    .brand-name { 
                        font-size: 15px; 
                        font-weight: bold; 
                        letter-spacing: 1.5px; 
                    }
                    .brand-sub { 
                        font-size: 8px; 
                        color: #333; 
                        letter-spacing: 1px;
                        margin-bottom: 4px; 
                    }
                    .clinic-info {
                        font-size: 8px;
                        line-height: 1.3;
                    }
                    
                    /* Sistem Garis Pembatas Estetik */
                    .border-double { border-top: 3px double #000; margin: 6px 0; }
                    .border-dashed { border-top: 1px dashed #000; margin: 6px 0; }
                    .border-dotted { border-top: 1px dotted #000; margin: 6px 0; }
                    .cut-line { font-size: 7px; color: #444; text-align: center; letter-spacing: 1px; opacity: 0.4; }
                    
                    /* Manajemen Tabel Konten */
                    .w-full { width: 100%; border-collapse: collapse; }
                    .w-full td { padding: 1.5px 0; vertical-align: top; }
                    
                    .meta-table td { font-size: 9px; }
                    .meta-label { width: 40%; text-align: left; }
                    .meta-value { width: 60%; text-align: right; }
                    
                    .section-title { 
                        font-size: 9px; 
                        font-weight: bold; 
                        letter-spacing: 0.5px; 
                        margin: 6px 0 4px 0; 
                    }
                    
                    /* Rincian Kasir Akhir */
                    .total-row td { 
                        font-size: 11px; 
                        font-weight: bold; 
                        padding-top: 4px;
                    }
                    .footer { 
                        margin-top: 14px; 
                        font-size: 8px; 
                        line-height: 1.4; 
                        letter-spacing: 0.3px;
                    }
                </style>
            </head>
            <body>
                <div class="cut-line">* * * * * * * * * * * * * * * *</div>
                <div style="height: 2px;"></div>

                <div class="brand-header">
                    <img src="<?= base_url('favicon-light.svg'); ?>" class="brand-logo"/>
                    <span class="brand-name">PETCARE</span>
                </div>
                <div class="text-center brand-sub uppercase">- Medical Center -</div>
                <div class="text-center clinic-info">
                    Raya Gubeng No. 10, Surabaya<br>
                    Telp: (031) 555-1234
                </div>
                
                <div class="border-double"></div>
                
                <table class="w-full meta-table">
                    <tr>
                        <td class="meta-label">ID REG</td>
                        <td class="meta-value">: ${data.kode}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">INVOICE</td>
                        <td class="meta-value font-bold">: ${data.inv}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">TANGGAL</td>
                        <td class="meta-value">: ${new Date().toLocaleDateString('id-ID')} ${new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">PEMILIK</td>
                        <td class="meta-value uppercase">: ${data.pemilik}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">PASIEN</td>
                        <td class="meta-value">: Anabul ${data.hewan}</td>
                    </tr>
                </table>
                
                <div class="border-dashed"></div>
                
                <div class="section-title uppercase tracking-wide">[ RINCIAN BIAYA ]</div>
                <table class="w-full">
                    <tr style="font-size: 10px;">
                        <td>Jasa Konsultasi</td>
                        <td class="text-right">Rp ${formatIdr(data.konsul)}</td>
                    </tr>
                    ${data.tindakan > 0 ? `
                    <tr style="font-size: 10px;">
                        <td>Tindakan Medis</td>
                        <td class="text-right">Rp ${formatIdr(data.tindakan)}</td>
                    </tr>` : ''}
                    ${data.obat > 0 ? `
                    <tr style="font-size: 10px;">
                        <td>Obat & Alkes</td>
                        <td class="text-right">Rp ${formatIdr(data.obat)}</td>
                    </tr>` : ''}
                </table>
                
                <div class="border-dotted"></div>
                
                <table class="w-full">
                    <tr class="total-row">
                        <td>TOTAL AKHIR</td>
                        <td class="text-right">Rp ${formatIdr(data.total)}</td>
                    </tr>
                    <tr style="font-size: 9px;">
                        <td>METODE</td>
                        <td class="text-right uppercase">${data.metode}</td>
                    </tr>
                    <tr style="font-size: 9px;">
                        <td>BAYAR</td>
                        <td class="text-right">Rp ${formatIdr(data.bayar)}</td>
                    </tr>
                    <tr class="font-bold" style="font-size: 9px;">
                        <td>KEMBALI</td>
                        <td class="text-right">Rp ${formatIdr(data.kembalian)}</td>
                    </tr>
                </table>
                
                <div class="border-double"></div>
                
                <div class="text-center footer">
                    <span class="font-bold uppercase" style="letter-spacing: 1px;">Terima Kasih</span><br>
                    Semoga anabul kesayangan Anda<br>
                    lekas sembuh & ceria kembali!
                </div>

                <div style="height: 6px;"></div>
                <div class="cut-line">* * * * * * * * * * * * * * * *</div>
            </body>
            </html>
        `);
        doc.close();

        // Jalankan proses print secara aman setelah engine load iframe selesai
        iframe.onload = function () {
            setTimeout(() => {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();

                // Bersihkan memori DOM dari iframe setelah dialog print selesai ditutup
                setTimeout(() => {
                    document.body.removeChild(iframe);
                }, 600);
            }, 150);
        };
    }
</script>
<?= $this->endSection() ?>