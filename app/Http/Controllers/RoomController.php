<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    // 1. LIHAT SEMUA KAMAR (Bisa diakses Admin & Tenant)
    public function index()
    {
        $rooms = Room::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua kamar berhasil diambil',
            'data' => $rooms
        ], 200);
    }

    // 2. TAMBAH KAMAR BARU (Khusus Admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|string|unique:rooms',
            'type'        => 'required|string',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $room = Room::create([
            'room_number' => $request->room_number,
            'type'        => $request->type,
            'price'       => $request->price,
            'description' => $request->description,
            'status'      => 'available', // Kamar baru otomatis berstatus kosong/tersedia
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kamar baru berhasil ditambahkan!',
            'data' => $room
        ], 201);
    }

    // 3. EDIT DATA KAMAR (Khusus Admin)
    public function update(Request $request, $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['message' => 'Kamar tidak ditemukan!'], 404);
        }

        $room->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data kamar berhasil diperbarui!',
            'data' => $room
        ], 200);
    }

    // 4. HAPUS KAMAR (Khusus Admin)
    public function destroy($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['message' => 'Kamar tidak ditemukan!'], 404);
        }

        $room->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kamar berhasil dihapus!'
        ], 200);
    }
}