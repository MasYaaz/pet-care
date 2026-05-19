<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClinicTables extends Migration
{
    public function up()
    {
        // 1. Table: ROLE (Statis - Tidak Menggunakan Auto Increment)
        $this->forge->addField([
            'ID_ROLE' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'NAMA_ROLE' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
        ]);
        $this->forge->addKey('ID_ROLE', true);
        $this->forge->createTable('ROLE', true);

        // 2. Table: PENGGUNA (Auto Increment)
        $this->forge->addField([
            'ID_PENGGUNA' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_ROLE' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'USERNAME' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'PASSWORD' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'EMAIL' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'NO_TELP' => ['type' => 'VARCHAR', 'constraint' => 18, 'null' => true],
        ]);
        $this->forge->addKey('ID_PENGGUNA', true);
        $this->forge->addForeignKey('ID_ROLE', 'ROLE', 'ID_ROLE', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('PENGGUNA', true);

        // 3. Table: DOKTER (Auto Increment)
        $this->forge->addField([
            'ID_DOKTER' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_PENGGUNA' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'NAMA_DOKTER' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'SPESIALISASI' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'NO_STR' => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => true],
        ]);
        $this->forge->addKey('ID_DOKTER', true);
        $this->forge->addForeignKey('ID_PENGGUNA', 'PENGGUNA', 'ID_PENGGUNA', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('DOKTER', true);

        // 4. Table: JADWAL_DOKTER (Auto Increment)
        $this->forge->addField([
            'ID_JADWAL' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_DOKTER' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'HARI' => ['type' => 'ENUM', 'constraint' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'], 'null' => true],
            'JAM_MULAI' => ['type' => 'TIME', 'null' => true],
            'JAM_SELESAI' => ['type' => 'TIME', 'null' => true],
            'KUOTA' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
        ]);
        $this->forge->addKey('ID_JADWAL', true);
        $this->forge->addForeignKey('ID_DOKTER', 'DOKTER', 'ID_DOKTER', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('JADWAL_DOKTER', true);

        // 5. Table: PARAMEDIS (Auto Increment)
        $this->forge->addField([
            'ID_PARAMEDIS' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_PENGGUNA' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'NAMA_PARAMEDIS' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'JABATAN' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
        ]);
        $this->forge->addKey('ID_PARAMEDIS', true);
        $this->forge->addForeignKey('ID_PENGGUNA', 'PENGGUNA', 'ID_PENGGUNA', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('PARAMEDIS', true);

        // 6. Table: PASIEN (Auto Increment)
        $this->forge->addField([
            'ID_PASIEN' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_PENGGUNA' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'NAMA_HEWAN' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'JENIS_HEWAN' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'RAS' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'TGL_LAHIR' => ['type' => 'DATETIME', 'null' => true],
            'NAMA_PEMILIK' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'ALAMAT' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
        ]);
        $this->forge->addKey('ID_PASIEN', true);
        $this->forge->addForeignKey('ID_PENGGUNA', 'PENGGUNA', 'ID_PENGGUNA', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('PASIEN', true);

        // 7. Table: RESERVASI (Auto Increment)
        $this->forge->addField([
            'ID_RESERVASI' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_PARAMEDIS' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_PASIEN' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_JADWAL' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'CREATED_AT' => ['type' => 'TIMESTAMP', 'null' => true],
            'KELUHAN' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'TANGGAL_KUNJUNGAN' => ['type' => 'DATETIME', 'null' => true],
            'STATUS_RESERVASI' => ['type' => 'ENUM', 'constraint' => ['Menunggu', 'Diperiksa', 'Selesai', 'Batal'], 'default' => 'Menunggu', 'null' => false],
        ]);
        $this->forge->addKey('ID_RESERVASI', true);
        $this->forge->addForeignKey('ID_PARAMEDIS', 'PARAMEDIS', 'ID_PARAMEDIS', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_PASIEN', 'PASIEN', 'ID_PASIEN', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_JADWAL', 'JADWAL_DOKTER', 'ID_JADWAL', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('RESERVASI', true);

        // 8. Table: REKAM_MEDIS (Auto Increment)
        $this->forge->addField([
            'ID_REKAM' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_RESERVASI' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_DOKTER' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'TANGGAL_PERIKSA' => ['type' => 'DATETIME', 'null' => true],
            'ANAMNESIS' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'DIAGNOSIS' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'TERAPI' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'CATATAN' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('ID_REKAM', true);
        $this->forge->addForeignKey('ID_RESERVASI', 'RESERVASI', 'ID_RESERVASI', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_DOKTER', 'DOKTER', 'ID_DOKTER', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('REKAM_MEDIS', true);

        // 9. Table: TINDAKAN (Master - Auto Increment)
        $this->forge->addField([
            'ID_TINDAKAN' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'NAMA_TINDAKAN' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'DESKRIPSI' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'HARGA' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
        ]);
        $this->forge->addKey('ID_TINDAKAN', true);
        $this->forge->createTable('TINDAKAN', true);

        // 10. Table: REKAM_TINDAKAN (Auto Increment)
        $this->forge->addField([
            'ID_REKAM_TINDAKAN' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_TINDAKAN' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_REKAM' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'HARGA_SAAT_ITU' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
            'JUMLAH_TINDAKAN' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
        ]);
        $this->forge->addKey('ID_REKAM_TINDAKAN', true);
        $this->forge->addForeignKey('ID_REKAM', 'REKAM_MEDIS', 'ID_REKAM', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_TINDAKAN', 'TINDAKAN', 'ID_TINDAKAN', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('REKAM_TINDAKAN', true);

        // 11. Table: RESEP_OBAT (Auto Increment)
        $this->forge->addField([
            'ID_RESEP_OBAT' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_REKAM' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_PARAMEDIS' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'TANGGAL_RESEP' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('ID_RESEP_OBAT', true);
        $this->forge->addForeignKey('ID_REKAM', 'REKAM_MEDIS', 'ID_REKAM', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_PARAMEDIS', 'PARAMEDIS', 'ID_PARAMEDIS', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('RESEP_OBAT', true);

        // 12. Table: OBAT (Master - Auto Increment)
        $this->forge->addField([
            'ID_OBAT' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'NAMA_OBAT' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'JENIS' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'SATUAN' => ['type' => 'ENUM', 'constraint' => ['Tablet', 'Botol', 'Salep', 'Pcs', 'Vial', 'Ampul'], 'null' => true],
            'STOK' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'HARGA_SATUAN_OBAT' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
        ]);
        $this->forge->addKey('ID_OBAT', true);
        $this->forge->createTable('OBAT', true);

        // 13. Table: DETAIL_RESEP (Auto Increment)
        $this->forge->addField([
            'ID_DETAIL_RESEP' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_OBAT' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_RESEP_OBAT' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'DOSIS' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'ATURAN_PAKAI' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'HARGA_TERCATAT' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
            'JUMLAH_RESEP' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
        ]);
        $this->forge->addKey('ID_DETAIL_RESEP', true);
        $this->forge->addForeignKey('ID_RESEP_OBAT', 'RESEP_OBAT', 'ID_RESEP_OBAT', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_OBAT', 'OBAT', 'ID_OBAT', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('DETAIL_RESEP', true);

        // 14. Table: ITEM_TAGIHAN (Auto Increment)
        $this->forge->addField([
            'ID_ITEM_TAGIHAN' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'KETERANGAN' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'JUMLAH_TAGIHAN' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'HARGA_SATUAN_TAGIHAN' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
            'SUBTOTAL' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
        ]);
        $this->forge->addKey('ID_ITEM_TAGIHAN', true);
        $this->forge->createTable('ITEM_TAGIHAN', true);

        // 15. Table: JENIS_ITEM (Statis - Tidak Menggunakan Auto Increment)
        $this->forge->addField([
            'ID_JENIS_ITEM' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'NAMA_JENIS_ITEM' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
        ]);
        $this->forge->addKey('ID_JENIS_ITEM', true);
        $this->forge->createTable('JENIS_ITEM', true);

        // 16. Table: METODE_BAYAR (Statis - Tidak Menggunakan Auto Increment)
        $this->forge->addField([
            'ID_METODE_BAYAR' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'NAMA_METODE_BAYAR' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
        ]);
        $this->forge->addKey('ID_METODE_BAYAR', true);
        $this->forge->createTable('METODE_BAYAR', true);

        // 17. Table: PEMBAYARAN (Auto Increment)
        $this->forge->addField([
            'ID_PEMBAYARAN' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'null' => false],
            'ID_JENIS_ITEM' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_RESERVASI' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_METODE_BAYAR' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_ITEM_TAGIHAN' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'ID_PASIEN' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'SUBTOTAL_TINDAKAN' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
            'SUBTOTAL_OBAT' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
            'BIAYA_KONSULTASI' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
            'TOTAL_TAGIHAN' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
            'JUMLAH_BAYAR' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
            'KEMBALIAN' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
            'KODE_TRANSAKSI' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'TGL_BAYAR' => ['type' => 'DATETIME', 'null' => true],
            'STATUS_BAYAR' => ['type' => 'ENUM', 'constraint' => ['Belum Bayar', 'Lunas', 'Gagal'], 'default' => 'Belum Bayar', 'null' => false],
        ]);
        $this->forge->addKey('ID_PEMBAYARAN', true);
        $this->forge->addForeignKey('ID_RESERVASI', 'RESERVASI', 'ID_RESERVASI', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_PASIEN', 'PASIEN', 'ID_PASIEN', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_METODE_BAYAR', 'METODE_BAYAR', 'ID_METODE_BAYAR', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_JENIS_ITEM', 'JENIS_ITEM', 'ID_JENIS_ITEM', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_ITEM_TAGIHAN', 'ITEM_TAGIHAN', 'ID_ITEM_TAGIHAN', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('PEMBAYARAN', true);
    }

    public function down()
    {
        $tables = [
            'PEMBAYARAN',
            'METODE_BAYAR',
            'JENIS_ITEM',
            'ITEM_TAGIHAN',
            'DETAIL_RESEP',
            'OBAT',
            'RESEP_OBAT',
            'REKAM_TINDAKAN',
            'TINDAKAN',
            'REKAM_MEDIS',
            'RESERVASI',
            'PASIEN',
            'PARAMEDIS',
            'JADWAL_DOKTER',
            'DOKTER',
            'PENGGUNA',
            'ROLE'
        ];

        foreach ($tables as $table) {
            $this->forge->dropTable($table, true);
        }
    }
}