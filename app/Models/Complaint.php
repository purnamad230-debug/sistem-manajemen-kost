<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    // Menentukan nama tabel (jika Laravel otomatis mencari jamak bahasa inggris)
    protected $table = 'complaints';

    // Daftarkan kolom yang boleh diisi melalui API
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'status',
    ];

    // Relasi balik ke tabel User (Keluhan ini milik siapa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}