<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiMutuModel extends Model
{
    protected $table            = 'nilai_mutu';
    protected $primaryKey       = 'nilai_huruf';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['nilai_huruf', 'nilai_mutu'];
    protected $returnType       = 'array';
}
