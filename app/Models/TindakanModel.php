<?php

namespace App\Models;

use CodeIgniter\Model;

class TindakanModel extends Model
{
    protected $table = 'TINDAKAN';
    protected $primaryKey = 'ID_TINDAKAN';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_TINDAKAN', 'NAMA_TINDAKAN', 'DESKRIPSI', 'HARGA'];
}