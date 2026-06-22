<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // Semua pengguna (Admin & Penghuni) bisa melihat daftar pengumuman kost
    public function index()
    {
        $pengumuman = Announcement::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $pengumuman
        ]);
    }

    // Khusus Admin untuk membuat pengumuman baru
    public function store(Request $request)
    {
        // Proteksi sederhana agar hanya role admin yang bisa posting pengumuman
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak! Hanya Admin yang bisa membuat pengumuman.'
            ], 403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
        ]);

        $pengumuman = Announcement::create([
            'judul' => $request->judul,
            'isi_pengumuman' => $request->isi_pengumuman,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil diterbitkan',
            'data' => $pengumuman
        ], 201);
    }
}