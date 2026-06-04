<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Riwayat Pembayaran Medis<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col gap-2">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Histori Transaksi Kasir</h1>
            <p class="text-slate-400 text-xs mt-1">Pantau seluruh rekaman tagihan nota pembayaran klinik dan status
                faktur billing Anda.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead
                    class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="p-4 pl-6">Kode Transaksi</th>
                        <th class="p-4">Nama Anabul</th>
                        <th class="p-4">Metode Bayar</th>
                        <th class="p-4 text-right">Total Tagihan</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-semibold text-slate-700">
                    <?php if (!empty($riwayat_pembayaran)):
                        foreach ($riwayat_pembayaran as $rp):
                            $statusBayar = trim(strtolower($rp['STATUS_BAYAR']));
                            ?>
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="p-4 pl-6 font-mono font-bold text-indigo-600">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="receipt" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span><?= esc($rp['KODE_TRANSAKSI']) ?></span>
                                    </div>
                                </td>

                                <td class="p-4 text-slate-900">
                                    <div class="flex items-center gap-1.5 font-bold">
                                        <span class="text-base leading-none">🐾</span>
                                        <span><?= esc($rp['NAMA_HEWAN']) ?></span>
                                    </div>
                                </td>

                                <td class="p-4 text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="credit-card" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span><?= esc($rp['NAMA_METODE_BAYAR'] ?? 'Belum Ditentukan') ?></span>
                                    </div>
                                </td>

                                <td class="p-4 text-right font-extrabold text-slate-950 text-sm">
                                    Rp <?= number_format($rp['TOTAL_TAGIHAN'], 0, ',', '.') ?>
                                </td>

                                <td class="p-4 text-center">
                                    <?php if ($statusBayar === 'lunas'): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/80 uppercase tracking-wide">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Lunas
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100/80 uppercase tracking-wide">
                                            <span class="w-1 h-1 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 text-center pr-6">
                                    <?php if ($statusBayar === 'lunas'): ?>
                                        <button type="button" data-invoice="#INV-<?= $rp['ID_PEMBAYARAN'] ?>"
                                            data-kode="<?= esc($rp['KODE_TRANSAKSI']) ?>" data-hewan="<?= esc($rp['NAMA_HEWAN']) ?>"
                                            data-total="<?= $rp['TOTAL_TAGIHAN'] ?>" data-konsul="<?= $rp['BIAYA_KONSULTASI'] ?>"
                                            data-tindakan="<?= $rp['SUBTOTAL_TINDAKAN'] ?>" data-obat="<?= $rp['SUBTOTAL_OBAT'] ?>"
                                            data-bayar="<?= $rp['JUMLAH_BAYAR'] ?? $rp['TOTAL_TAGIHAN'] ?>"
                                            data-kembalian="<?= $rp['KEMBALIAN'] ?? 0 ?>"
                                            data-metode="<?= $rp['NAMA_METODE_BAYAR'] ? esc($rp['NAMA_METODE_BAYAR']) : 'Tunai' ?>"
                                            class="btn-print-faktur inline-flex items-center gap-1 px-3 py-1.5 bg-slate-900 hover:bg-indigo-600 text-white rounded-lg text-[11px] font-bold transition-all shadow-xs cursor-pointer">
                                            <i data-lucide="printer" class="w-3.5 h-3.5"></i> Cetak Faktur
                                        </button>
                                    <?php else: ?>
                                        <button disabled title="Faktur dapat dicetak setelah tagihan dilunasi di kasir"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 text-slate-400 rounded-lg text-[11px] font-bold cursor-not-allowed opacity-60">
                                            <i data-lucide="lock" class="w-3.5 h-3.5"></i> Belum Lunas
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <div
                                        class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100 text-slate-400">
                                        <i data-lucide="file-text" class="w-5 h-5"></i>
                                    </div>
                                    <p class="text-xs font-bold text-slate-500">Belum Ada Rekaman Invoice</p>
                                    <p class="text-[11px] text-slate-400 font-normal">Riwayat nota klinis pembayaran Anda
                                        akan terekam otomatis di sini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();

        const printButtons = document.querySelectorAll('.btn-print-faktur');

        printButtons.forEach(button => {
            button.addEventListener('click', function () {
                const inv = this.getAttribute('data-invoice');
                const kode = this.getAttribute('data-kode');
                const hewan = this.getAttribute('data-hewan');
                const total = parseInt(this.getAttribute('data-total')) || 0;
                const konsul = parseInt(this.getAttribute('data-konsul')) || 0;
                const tindakan = parseInt(this.getAttribute('data-tindakan')) || 0;
                const obat = parseInt(this.getAttribute('data-obat')) || 0;
                const bayar = parseInt(this.getAttribute('data-bayar')) || 0;
                const kembalian = parseInt(this.getAttribute('data-kembalian')) || 0;
                const metode = this.getAttribute('data-metode');

                printThermalReceipt({
                    inv, kode, hewan, total, konsul, tindakan, obat, bayar, kembalian, metode
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