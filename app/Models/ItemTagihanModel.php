<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemTagihanModel extends Model
{
    protected $table = 'ITEM_TAGIHAN';
    protected $primaryKey = 'ID_ITEM_TAGIHAN';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_ITEM_TAGIHAN', 'KETERANGAN', 'JUMLAH_TAGIHAN', 'HARGA_SATUAN_TAGIHAN', 'SUBTOTAL'];
}