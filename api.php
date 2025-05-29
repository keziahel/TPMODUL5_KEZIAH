<?php

use App\Http\Controllers\Api\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
Route::post('/mahasiswa', [MahasiswaController::class, 'store']);
Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update']);
Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy']);