<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatModel extends Model
{
    protected $table = 'OBAT';
    protected $primaryKey = 'ID_OBAT';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_OBAT', 'NAMA_OBAT', 'JENIS', 'SATUAN', 'STOK', 'HARGA_SATUAN_OBAT'];
}