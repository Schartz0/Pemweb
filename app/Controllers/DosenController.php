<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\MataKuliahModel;
use App\Models\RuanganModel;

class DosenController extends BaseController
{
    protected $jadwalModel;
    protected $mataKuliahModel;
    protected $ruanganModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->mataKuliahModel = new MataKuliahModel();
        $this->ruanganModel = new RuanganModel();
    }

    public function jadwal()
    {
        $nidn = session('kode_peran');

        $jadwal = $this->jadwalModel
            ->select('jadwal.*, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks, ruangan.nama_ruangan')
            ->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = jadwal.id_mata_kuliah', 'left')
            ->join('ruangan', 'ruangan.id_ruangan = jadwal.id_ruangan', 'left')
            ->where('jadwal.nidn', $nidn)
            ->orderBy('hari', 'ASC')
            ->findAll();

        return view('dosen/jadwal/index', [
            'title' => 'Jadwal Mengajar',
            'jadwal' => $jadwal,
        ]);
    }
}
