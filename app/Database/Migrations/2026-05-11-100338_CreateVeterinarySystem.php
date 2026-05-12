<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVeterinarySystem extends Migration
{
    public function up()
    {
        // Table: DOKTER
        $this->forge->addField([
            'ID_DOKTER' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => false],
            'NAMA_DOKTER' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'SPESIALISASI' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'TELEPON_DOKTER' => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => true],
        ]);
        $this->forge->addKey('ID_DOKTER', true);
        $this->forge->createTable('DOKTER');

        // Table: PEMILIK_HEWAN
        $this->forge->addField([
            'ID_PEMILIK' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => false],
            'NAMA_PEMILIK' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'TELEPON_PEMILIK' => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => true],
            'ALAMAT' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'EMAIL' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
        ]);
        $this->forge->addKey('ID_PEMILIK', true);
        $this->forge->createTable('PEMILIK_HEWAN');

        // Table: REKAM_MEDIS
        $this->forge->addField([
            'ID_REKAM' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => false],
            'ID_DOKTER' => ['type' => 'INT', 'constraint' => 11],
            'ID_PEMILIK' => ['type' => 'INT', 'constraint' => 11],
            'TANGGAL_PERIKSA' => ['type' => 'DATETIME', 'null' => true],
            'KELUHAN' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'DIAGNOSA' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'BIAYA' => ['type' => 'FLOAT', 'constraint' => '8,2', 'null' => true],
        ]);
        $this->forge->addKey('ID_REKAM', true);
        $this->forge->addForeignKey('ID_DOKTER', 'DOKTER', 'ID_DOKTER', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ID_PEMILIK', 'PEMILIK_HEWAN', 'ID_PEMILIK', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('REKAM_MEDIS');

        // Table: HEWAN
        $this->forge->addField([
            'ID_HEWAN' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => false],
            'ID_REKAM' => ['type' => 'INT', 'constraint' => 11],
            'NAMA_HEWAN' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'JENIS' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'RAS' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'USIA' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
        ]);
        $this->forge->addKey('ID_HEWAN', true);
        $this->forge->addForeignKey('ID_REKAM', 'REKAM_MEDIS', 'ID_REKAM', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('HEWAN');
    }

    public function down()
    {
        $this->forge->dropTable('HEWAN');
        $this->forge->dropTable('REKAM_MEDIS');
        $this->forge->dropTable('PEMILIK_HEWAN');
        $this->forge->dropTable('DOKTER');
    }
}