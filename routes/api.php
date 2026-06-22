<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ComplaintController;     // ◄ TAMBAHAN BARU
use App\Http\Controllers\PaymentController;       // ◄ TAMBAHAN BARU
use App\Http\Controllers\AnnouncementController;   // ◄ TAMBAHAN BARU
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==================== RUTE PUBLIK (TANPA LOGIN) ====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('rooms', RoomController::class);


// ==================== RUTE PROTEKSI (WAJIB LOGIN) ====================
Route::middleware('auth:sanctum')->group(function () {
    
    // Cek profil user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Jalur URL Otomatis untuk Keluhan, Pembayaran, dan Pengumuman
    Route::apiResource('complaints', ComplaintController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('announcements', AnnouncementController::class);
    
});