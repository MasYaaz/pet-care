<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisItemModel extends Model
{
    protected $table = 'JENIS_ITEM';
    protected $primaryKey = 'ID_JENIS_ITEM';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_JENIS_ITEM', 'NAMA_JENIS_ITEM'];
}