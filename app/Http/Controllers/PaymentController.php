<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Admin bisa melihat semua riwayat pembayaran kost
    public function index()
    {
        $pembayaran = Payment::with('booking.user', 'booking.room')->get();

        return response()->json([
            'success' => true,
            'data' => $pembayaran
        ]);
    }

    // Mencatat pembayaran baru (Bisa diinput admin atau di-upload oleh penghuni)
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'jumlah' => 'required|numeric',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Batasi upload foto max 2MB
        ]);

        // Logika sederhana penanganan upload file foto bukti transfer jika ada
        $namaFoto = null;
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $namaFoto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bukti_bayar'), $namaFoto);
        }

        $pembayaran = Payment::create([
            'booking_id' => $request->booking_id,
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => $request->tanggal_bayar,
            'bukti_bayar' => $namaFoto,
            'status' => 'Lunas', // Default langsung lunas setelah bayar, atau sesuaikan kebutuhan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data pembayaran berhasil dicatat',
            'data' => $pembayaran
        ], 201);
    }
}