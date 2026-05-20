<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun untuk Dokter (ID_ROLE = 1)
        $dokterUser = [
            'ID_ROLE' => 1,
            'USERNAME' => 'dokter',
            'PASSWORD' => password_hash('dokter123', PASSWORD_BCRYPT),
            'EMAIL' => 'dokter@petcare.com',
            'NO_TELP' => '081234567890',
            'NAMA_LENGKAP' => 'drh. John Doe',
            'ALAMAT' => 'Jl. Dharmahusada No. 25, Surabaya'
        ];
        $this->db->table('PENGGUNA')->insert($dokterUser);
        $idPenggunaDokter = $this->db->insertID(); // Ambil ID_PENGGUNA yang baru saja digenerate

        // Sambungkan ke tabel DOKTER (Tanpa kolom NAMA_DOKTER)
        $this->db->table('DOKTER')->insert([
            'ID_PENGGUNA' => $idPenggunaDokter,
            'SPESIALISASI' => 'Bedah & Hewan Kecil',
            'NO_STR' => 'STR-2026-998811'
        ]);

        // 2. Akun untuk Paramedis / Resepsionis (ID_ROLE = 2)
        $paramedisUser = [
            'ID_ROLE' => 2,
            'USERNAME' => 'staff',
            'PASSWORD' => password_hash('staff123', PASSWORD_BCRYPT),
            'EMAIL' => 'admin@petcare.com',
            'NO_TELP' => '089988776655',
            'NAMA_LENGKAP' => 'Jane Doe',
            'ALAMAT' => 'Gubeng Kertajaya, Surabaya'
        ];
        $this->db->table('PENGGUNA')->insert($paramedisUser);
        $idPenggunaStaff = $this->db->insertID();

        // Sambungkan ke tabel PARAMEDIS (Tanpa kolom NAMA_PARAMEDIS)
        $this->db->table('PARAMEDIS')->insert([
            'ID_PENGGUNA' => $idPenggunaStaff,
            'JABATAN' => 'Front Desk Resepsionis'
        ]);

        // Tambahkan akun Admin murni di UserSeeder
        $adminUser = [
            'ID_ROLE' => 4, // Role baru: Admin
            'USERNAME' => 'administrator',
            'PASSWORD' => password_hash('admin123', PASSWORD_BCRYPT),
            'EMAIL' => 'admin@petcare.com',
            'NO_TELP' => '081122334455',
            'NAMA_LENGKAP' => 'Aflah',
            'ALAMAT' => 'Surabaya Core HQ'
        ];
        $this->db->table('PENGGUNA')->insert($adminUser);
    }
}