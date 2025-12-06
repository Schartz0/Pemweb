<?php

namespace App\Controllers;

use App\Models\RencanaStudiModel;
use App\Models\NilaiMutuModel;
use App\Models\JadwalModel;
use App\Models\MahasiswaModel;

class NilaiMutuController extends BaseController
{
    protected $rencanaModel;
    protected $nilaiMutuModel;
    protected $jadwalModel;
    protected $mahasiswaModel;

    public function __construct()
    {
        $this->rencanaModel = new RencanaStudiModel();
        $this->nilaiMutuModel = new NilaiMutuModel();
        $this->jadwalModel = new JadwalModel();
        $this->mahasiswaModel = new MahasiswaModel();
    }

    public function edit($idJadwal)
    {
        $nidn = session('kode_peran');
        $jadwal = $this->jadwalModel->find($idJadwal);

        if (! $jadwal || ($nidn && $jadwal['nidn'] !== $nidn)) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan atau bukan milik Anda.');
        }

        $peserta = $this->rencanaModel
            ->select('rencana_studi.id_rencana_studi, rencana_studi.nilai_angka, rencana_studi.nilai_huruf, mahasiswa.nim, mahasiswa.nama')
            ->join('mahasiswa', 'mahasiswa.nim = rencana_studi.nim', 'left')
            ->where('rencana_studi.id_jadwal', $idJadwal)
            ->findAll();

        return view('dosen/nilai/edit', [
            'title' => 'Isi Nilai',
            'jadwal' => $jadwal,
            'peserta' => $peserta,
            'nilai_mutu' => $this->nilaiMutuModel->orderBy('nilai_mutu', 'DESC')->findAll(),
        ]);
    }

    public function update($idJadwal)
    {
        $nidn = session('kode_peran');
        $jadwal = $this->jadwalModel->find($idJadwal);

        if (! $jadwal || ($nidn && $jadwal['nidn'] !== $nidn)) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengubah nilai jadwal ini.');
        }

        $dataNilai = $this->request->getPost('nilai') ?? [];
        if (empty($dataNilai)) {
            return redirect()->back()->with('error', 'Tidak ada data nilai yang dikirim.');
        }

        foreach ($dataNilai as $idRencana => $nilai) {
            $this->rencanaModel->update($idRencana, [
                'nilai_angka' => $nilai['nilai_angka'] ?? null,
                'nilai_huruf' => $nilai['nilai_huruf'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }
}
