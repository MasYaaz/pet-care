<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'ROLE';
    protected $primaryKey = 'ID_ROLE';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $allowedFields = ['ID_ROLE', 'NAMA_ROLE'];
}