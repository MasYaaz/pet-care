<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodeBayarModel extends Model
{
    protected $table = 'METODE_BAYAR';
    protected $primaryKey = 'ID_METODE_BAYAR';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_METODE_BAYAR', 'NAMA_METODE_BAYAR'];
}