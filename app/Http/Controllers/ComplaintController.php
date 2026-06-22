<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // Melihat daftar keluhan
    public function index(Request $request)
    {
        // Admin melihat semua keluhan, Penyewa hanya melihat keluhan miliknya sendiri
        if ($request->user()->role === 'admin') {
            $keluhan = Complaint::with('user')->get();
        } else {
            $keluhan = Complaint::where('user_id', $request->user()->id)->get();
        }

        return response()->json([
            'success' => true,
            'data' => $keluhan
        ]);
    }

    // Mengajukan keluhan baru (untuk penyewa)
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $keluhan = Complaint::create([
            'user_id' => $request->user()->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => 'Menunggu',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keluhan Anda berhasil dikirim',
            'data' => $keluhan
        ], 201);
    }

    // Memperbarui status keluhan (untuk admin: Menunggu -> Diproses -> Selesai)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        $keluhan = Complaint::findOrFail($id);
        $keluhan->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status keluhan berhasil diperbarui',
            'data' => $keluhan
        ]);
    }
}