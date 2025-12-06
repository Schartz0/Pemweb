<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table            = 'jadwal';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nama_kelas',
        'id_mata_kuliah',
        'id_ruangan',
        'nidn',
        'hari',
        'jam'
    ];
    protected $returnType       = 'array';
}
