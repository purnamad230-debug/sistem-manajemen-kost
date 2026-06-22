<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            // Menghubungkan keluhan ke id user/penghuni yang melapor
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data keluhan murni Bahasa Indonesia
            $table->string('judul');      // Contoh: AC Rusak, Lampu Mati
            $table->text('deskripsi');    // Detail penjelasan kerusakan
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu'); // ◄ SUDAH INDONESIA
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
