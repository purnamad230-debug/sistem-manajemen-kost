<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Fungsi untuk Pendaftaran Akun Baru (Tenant/Penyewa)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'tenant', // Otomatis mendaftar sebagai tenant/penghuni
        ]);

        // Membuat Token Akses untuk Front-End
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Register berhasil!',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    // Fungsi untuk Masuk Akun (Admin atau Tenant)
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // Cek apakah email ada dan password-nya cocok di database
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah!'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil!',
            'role' => $user->role, // Mengirim data role agar FE tahu ini Admin atau Tenant
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}