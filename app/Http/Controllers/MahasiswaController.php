<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = mahasiswa::all();
        
        // Jika request dari API (Postman), return JSON
        if (request()->wantsJson() || request()->expectsJson() || request()->is('api/*')) {
            return response()->json($mahasiswas);
        }
        
        // Jika request dari browser, return view
        return view('index', ['mahasiswas' => $mahasiswas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Biasanya return view, untuk API bisa dikosongkan atau kembalikan response standar
        return response()->json(['message' => 'Form create Mahasiswa']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nim' => 'required|string|max:15|unique:mahasiswa,nim',
            'nama' => 'required|string|max:100',
            'semester' => 'required|integer',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:20',
            'jurusan' => 'required|string|max:50',
        ]);

        $mahasiswa = mahasiswa::create($data);

        return response()->json($mahasiswa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($nim)
    {
        $mahasiswa = mahasiswa::find($nim);
        
        if (!$mahasiswa) {
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
            }
            abort(404);
        }
        
        if (request()->wantsJson() || request()->expectsJson()) {
            return response()->json($mahasiswa);
        }
        
        return view('show', ['mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nim)
    {
        $mahasiswa = mahasiswa::find($nim);
        if (!$mahasiswa) {
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
            }
            abort(404);
        }
        if (request()->wantsJson()) {
            return response()->json($mahasiswa);
        }
        return response()->json($mahasiswa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nim)
    {
        $mahasiswa = mahasiswa::find($nim);
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }
        
        $data = $request->validate([
            'nama' => 'sometimes|required|string|max:100',
            'semester' => 'sometimes|required|integer',
            'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
            'no_hp' => 'sometimes|required|string|max:20',
            'jurusan' => 'sometimes|required|string|max:50',
        ]);

        $mahasiswa->update($data);

        return response()->json($mahasiswa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nim)
    {
        $mahasiswa = mahasiswa::find($nim);
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }
        $mahasiswa->delete();
        return response()->json(['message' => 'Mahasiswa deleted successfully']);
    }
}
