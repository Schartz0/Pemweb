<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaStudiModel extends Model
{
    protected $table            = 'rencana_studi';
    protected $primaryKey       = 'id_rencana_studi';
    protected $allowedFields    = ['nim', 'id_jadwal', 'nilai_angka', 'nilai_huruf'];
    protected $returnType       = 'array';
}
