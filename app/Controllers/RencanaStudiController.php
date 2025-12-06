<?php

namespace App\Controllers;

use App\Models\RencanaStudiModel;
use App\Models\JadwalModel;
use App\Models\MataKuliahModel;

class RencanaStudiController extends BaseController
{
    protected $rencanaModel;
    protected $jadwalModel;
    protected $mataKuliahModel;

    public function __construct()
    {
        $this->rencanaModel = new RencanaStudiModel();
        $this->jadwalModel = new JadwalModel();
        $this->mataKuliahModel = new MataKuliahModel();
    }

    public function index()
    {
        $nim = session('kode_peran');

        $jadwal = $this->jadwalModel
            ->select('jadwal.*, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks')
            ->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = jadwal.id_mata_kuliah', 'left')
            ->orderBy('hari', 'ASC')
            ->findAll();

        $rencana = $this->rencanaModel
            ->select('rencana_studi.*, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks')
            ->join('jadwal', 'jadwal.id = rencana_studi.id_jadwal', 'left')
            ->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = jadwal.id_mata_kuliah', 'left')
            ->where('rencana_studi.nim', $nim)
            ->findAll();

        return view('mahasiswa/rencana/index', [
            'title' => 'Rencana Studi',
            'jadwal' => $jadwal,
            'rencana' => $rencana,
        ]);
    }

    public function store()
    {
        $nim = session('kode_peran');
        $idJadwal = $this->request->getPost('id_jadwal');

        if (! $nim || ! $idJadwal) {
            return redirect()->back()->with('error', 'Data tidak lengkap.');
        }

        $sudahAda = $this->rencanaModel
            ->where('nim', $nim)
            ->where('id_jadwal', $idJadwal)
            ->countAllResults();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Kelas ini sudah ada pada rencana studimu.');
        }

        $this->rencanaModel->insert([
            'nim' => $nim,
            'id_jadwal' => $idJadwal,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan ke rencana studi.');
    }

    public function destroy($id)
    {
        $nim = session('kode_peran');

        $rencana = $this->rencanaModel->find($id);
        if (! $rencana || $rencana['nim'] !== $nim) {
            return redirect()->back()->with('error', 'Rencana studi tidak ditemukan.');
        }

        $this->rencanaModel->delete($id);

        return redirect()->back()->with('success', 'Rencana studi berhasil dihapus.');
    }

    public function hasil()
    {
        $nim = session('kode_peran');

        $hasil = $this->rencanaModel
            ->select('rencana_studi.*, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks, nilai_mutu.nilai_mutu')
            ->join('jadwal', 'jadwal.id = rencana_studi.id_jadwal', 'left')
            ->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = jadwal.id_mata_kuliah', 'left')
            ->join('nilai_mutu', 'nilai_mutu.nilai_huruf = rencana_studi.nilai_huruf', 'left')
            ->where('rencana_studi.nim', $nim)
            ->findAll();

        $totalSks = 0;
        $totalNilaiMutu = 0;
        foreach ($hasil as $item) {
            $sks = (int) ($item['sks'] ?? 0);
            $mutu = (float) ($item['nilai_mutu'] ?? 0);
            $totalSks += $sks;
            $totalNilaiMutu += $mutu * $sks;
        }

        $ipk = $totalSks > 0 ? round($totalNilaiMutu / $totalSks, 2) : 0;

        return view('mahasiswa/hasil/index', [
            'title' => 'Hasil Studi',
            'hasil' => $hasil,
            'ipk'   => $ipk,
            'total_sks' => $totalSks,
            'total_nilai_mutu' => $totalNilaiMutu,
        ]);
    }
}
