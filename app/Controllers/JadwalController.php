<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\MataKuliahModel;
use App\Models\RuanganModel;
use App\Models\DosenModel;

class JadwalController extends BaseController
{
    protected $jadwalModel;
    protected $mataKuliahModel;
    protected $ruanganModel;
    protected $dosenModel;
    protected $fillable = [
        'nama_kelas',
        'id_mata_kuliah',
        'id_ruangan',
        'nidn',
        'hari',
        'jam',
    ];

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->mataKuliahModel = new MataKuliahModel();
        $this->ruanganModel = new RuanganModel();
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        $editId = $this->request->getGet('edit');
        $editData = null;
        if ($editId) {
            $editData = $this->jadwalModel->find($editId);
        }

        $jadwal = $this->jadwalModel
            ->select('jadwal.*, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks, ruangan.nama_ruangan, dosen.nama as nama_dosen')
            ->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = jadwal.id_mata_kuliah', 'left')
            ->join('ruangan', 'ruangan.id_ruangan = jadwal.id_ruangan', 'left')
            ->join('dosen', 'dosen.nidn = jadwal.nidn', 'left')
            ->orderBy('hari', 'ASC')
            ->findAll();

        return view('admin/jadwal/index', [
            'title' => 'Data Jadwal',
            'jadwal' => $jadwal,
            'mataKuliah' => $this->mataKuliahModel->findAll(),
            'ruangan' => $this->ruanganModel->findAll(),
            'dosen' => $this->dosenModel->findAll(),
            'editData' => $editData,
        ]);
    }

    public function store()
    {
        $rules = [
            'nama_kelas' => 'required',
            'id_mata_kuliah' => 'required',
            'id_ruangan' => 'required',
            'nidn' => 'required',
            'hari' => 'required',
            'jam' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jadwalModel->insert($this->request->getPost($this->fillable));

        return redirect()->back()->with('success', 'Jadwal berhasil disimpan.');
    }

    public function update($id)
    {
        $rules = [
            'nama_kelas' => 'required',
            'id_mata_kuliah' => 'required',
            'id_ruangan' => 'required',
            'nidn' => 'required',
            'hari' => 'required',
            'jam' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost($this->fillable);

        $this->jadwalModel->update($id, $data);

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->jadwalModel->delete($id);

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
