<?php

namespace App\Controllers;

use App\Models\RuanganModel;

class RuanganController extends BaseController
{
    protected $ruanganModel;

    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $ruangan = $this->ruanganModel->findAll();

        return view('admin/ruangan/index', [
            'title'   => 'Data Ruangan',
            'ruangan' => $ruangan,
        ]);
    }

    public function store()
    {
        $rules = ['nama_ruangan' => 'required'];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->ruanganModel->insert([
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil disimpan.');
    }

    public function update($id)
    {
        $rules = ['nama_ruangan' => 'required'];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->ruanganModel->update($id, [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->ruanganModel->delete($id);

        return redirect()->back()->with('success', 'Ruangan berhasil dihapus.');
    }
}
