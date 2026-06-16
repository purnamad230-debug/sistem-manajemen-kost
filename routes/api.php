<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController; // ◄ TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Rute untuk pendaftaran akun (Tenant)
Route::post('/register', [AuthController::class, 'register']);
// Rute untuk masuk akun (Admin & Tenant)
Route::post('/login', [AuthController::class, 'login']);
// Jalur URL Otomatis untuk Lihat, Tambah, Edit, dan Hapus kamar
Route::apiResource('rooms', RoomController::class);