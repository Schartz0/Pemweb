<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('mahasiswa', [MahasiswaController::class, 'index']);
Route::post('mahasiswa', [MahasiswaController::class, 'store']);
Route::get('mahasiswa/{nim}', [MahasiswaController::class, 'show'])->where('nim', '[^/]+');
Route::put('mahasiswa/{nim}', [MahasiswaController::class, 'update'])->where('nim', '[^/]+');
Route::patch('mahasiswa/{nim}', [MahasiswaController::class, 'update'])->where('nim', '[^/]+');
Route::delete('mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])->where('nim', '[^/]+');