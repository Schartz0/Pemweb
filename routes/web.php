<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AuthController;

Route::get('login', [AuthController::class, 'showLogin'])->name('login');


Route::get('/', [MahasiswaController::class, 'index'])->name('index');
Route::view('mahasiswa/create', 'create')->name('mahasiswa.create');
Route::view('mahasiswa/{nim}/edit', 'edit')->where('nim', '[^/]+')->name('mahasiswa.edit');
Route::get('mahasiswa/{nim}', [MahasiswaController::class, 'show'])->where('nim', '[^/]+');

// API Routes (Controller return JSON untuk Postman) - harus sebelum view route agar JSON request terpenuhi
// Route::post('mahasiswa', [MahasiswaController::class, 'store']);
// Route::get('mahasiswa/{nim}', [MahasiswaController::class, 'show'])->where('nim', '[^/]+');
// Route::put('mahasiswa/{nim}', [MahasiswaController::class, 'update'])->where('nim', '[^/]+');
// Route::patch('mahasiswa/{nim}', [MahasiswaController::class, 'update'])->where('nim', '[^/]+');
// Route::delete('mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])->where('nim', '[^/]+');
