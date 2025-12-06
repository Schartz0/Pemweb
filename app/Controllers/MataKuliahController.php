<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;

class MataKuliahController extends BaseController
{
    protected $mataKuliahModel;
    protected $fillable = ['kode_mata_kuliah', 'nama_mata_kuliah', 'sks'];

    public function __construct()
    {
        $this->mataKuliahModel = new MataKuliahModel();
    }

    public function index()
    {
        $editId = $this->request->getGet('edit');
        $editData = null;

        if ($editId) {
            $editData = $this->mataKuliahModel->find($editId);
        }

        return view('admin/matakuliah/index', [
            'title' => 'Data Mata Kuliah',
            'mataKuliah' => $this->mataKuliahModel->orderBy('kode_mata_kuliah', 'ASC')->findAll(),
            'editData' => $editData,
        ]);
    }

    public function store()
    {
        $rules = [
            'kode_mata_kuliah' => 'required',
            'nama_mata_kuliah' => 'required',
            'sks'              => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mataKuliahModel->insert($this->request->getPost($this->fillable));

        return redirect()->to(base_url('admin/mata-kuliah'))->with('success', 'Mata kuliah berhasil disimpan.');
    }

    public function update($id)
    {
        $rules = [
            'kode_mata_kuliah' => 'required',
            'nama_mata_kuliah' => 'required',
            'sks'              => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mataKuliahModel->update($id, $this->request->getPost($this->fillable));

        return redirect()->to(base_url('admin/mata-kuliah'))->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->mataKuliahModel->delete($id);

        return redirect()->back()->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
