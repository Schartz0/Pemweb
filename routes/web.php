<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

// Route untuk view (statis - harus sebelum route API)
Route::get('/', [MahasiswaController::class, 'index'])->name('index');
Route::view('mahasiswa/create', 'create')->name('mahasiswa.create');
Route::view('mahasiswa/{nim}/edit', 'edit')->where('nim', '[^/]+')->name('mahasiswa.edit');

// API Routes (Controller return JSON untuk Postman) - harus sebelum view route agar JSON request terpenuhi
Route::post('mahasiswa', [MahasiswaController::class, 'store']);
Route::get('mahasiswa/{nim}', [MahasiswaController::class, 'show'])->where('nim', '[^/]+');
Route::put('mahasiswa/{nim}', [MahasiswaController::class, 'update'])->where('nim', '[^/]+');
Route::patch('mahasiswa/{nim}', [MahasiswaController::class, 'update'])->where('nim', '[^/]+');
Route::delete('mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])->where('nim', '[^/]+');

// API Routes dengan prefix /api (optional, untuk Postman)
Route::prefix('api')->group(function () {
    Route::get('mahasiswa', [MahasiswaController::class, 'index']);
    Route::post('mahasiswa', [MahasiswaController::class, 'store']);
    Route::get('mahasiswa/{nim}', [MahasiswaController::class, 'show'])->where('nim', '[^/]+');
    Route::put('mahasiswa/{nim}', [MahasiswaController::class, 'update'])->where('nim', '[^/]+');
    Route::patch('mahasiswa/{nim}', [MahasiswaController::class, 'update'])->where('nim', '[^/]+');
    Route::delete('mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])->where('nim', '[^/]+');
});

