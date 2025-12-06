<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table            = 'dosen';
    protected $primaryKey       = 'nidn';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['nidn', 'nama'];
    protected $returnType       = 'array';
}
