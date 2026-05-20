<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClinicSeeder extends Seeder
{
    public function run()
    {
        // 1. Isi Tabel ROLE (Statis - ID ditentukan manual)
        $roleData = [
            ['ID_ROLE' => 1, 'NAMA_ROLE' => 'Dokter'],
            ['ID_ROLE' => 2, 'NAMA_ROLE' => 'Paramedis'],
            ['ID_ROLE' => 3, 'NAMA_ROLE' => 'Pasien'],
            ['ID_ROLE' => 4, 'NAMA_ROLE' => 'Admin'],
        ];
        $this->db->table('ROLE')->insertBatch($roleData);

        // 2. Isi Tabel JENIS_ITEM (Statis - ID ditentukan manual)
        $jenisItemData = [
            ['ID_JENIS_ITEM' => 1, 'NAMA_JENIS_ITEM' => 'Konsultasi Dokter'],
            ['ID_JENIS_ITEM' => 2, 'NAMA_JENIS_ITEM' => 'Tindakan Medis'],
            ['ID_JENIS_ITEM' => 3, 'NAMA_JENIS_ITEM' => 'Obat / Farmasi'],
        ];
        $this->db->table('JENIS_ITEM')->insertBatch($jenisItemData);

        // 3. Isi Tabel METODE_BAYAR (Statis - ID ditentukan manual)
        $metodeBayarData = [
            ['ID_METODE_BAYAR' => 1, 'NAMA_METODE_BAYAR' => 'Tunai'],
            ['ID_METODE_BAYAR' => 2, 'NAMA_METODE_BAYAR' => 'Transfer Bank'],
            ['ID_METODE_BAYAR' => 3, 'NAMA_METODE_BAYAR' => 'QRIS'],
        ];
        $this->db->table('METODE_BAYAR')->insertBatch($metodeBayarData);

        // 4. Isi Tabel TINDAKAN (Master - ID dikosongkan karena Auto Increment)
        $tindakanData = [
            [
                'NAMA_TINDAKAN' => 'Vaksinasi Rabies',
                'DESKRIPSI' => 'Pemberian vaksin rabies tahunan untuk kucing atau anjing',
                'HARGA' => 150000.00
            ],
            [
                'NAMA_TINDAKAN' => 'Operasi Steril Kucing Jantan',
                'DESKRIPSI' => 'Tindakan kastrasi/sterilisasi pada kucing jantan domestic/ras',
                'HARGA' => 350000.00
            ],
            [
                'NAMA_TINDAKAN' => 'Pembersihan Karang Gigi (Scaling)',
                'DESKRIPSI' => 'Pembersihan plak dan karang gigi hewan dengan ultrasonic scaler',
                'HARGA' => 250000.00
            ],
            [
                'NAMA_TINDAKAN' => 'Suntik Vitamin & Antibiotik',
                'DESKRIPSI' => 'Injeksi terapi pendukung untuk memulihkan daya tahan tubuh hewan',
                'HARGA' => 750000.00
            ]
        ];
        $this->db->table('TINDAKAN')->insertBatch($tindakanData);

        // 5. Isi Tabel OBAT (Master - ID dikosongkan karena Auto Increment)
        $obatData = [
            [
                'NAMA_OBAT' => 'Amoxicillin 100mg',
                'JENIS' => 'Antibiotik',
                'SATUAN' => 'Tablet',
                'STOK' => 500,
                'HARGA_SATUAN_OBAT' => 3500.00
            ],
            [
                'NAMA_OBAT' => 'Obat Cacing Drontal Cat',
                'JENIS' => 'Antiparasit',
                'SATUAN' => 'Tablet',
                'STOK' => 100,
                'HARGA_SATUAN_OBAT' => 25000.00
            ],
            [
                'NAMA_OBAT' => 'Earmite Drops 10ml',
                'JENIS' => 'Obat Tetes Telinga',
                'SATUAN' => 'Botol',
                'STOK' => 45,
                'HARGA_SATUAN_OBAT' => 35000.00
            ],
            [
                'NAMA_OBAT' => 'Ketoconazole Salep 5gr',
                'JENIS' => 'Antijamur',
                'SATUAN' => 'Salep',
                'STOK' => 30,
                'HARGA_SATUAN_OBAT' => 15000.00
            ]
        ];
        $this->db->table('OBAT')->insertBatch($obatData);
    }
}