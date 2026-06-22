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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel bookings (siapa penghuni yang bayar)
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            
            // Kolom keuangan sesuai mind-map kelompokmu
            $table->decimal('jumlah', 12, 2); 
            $table->date('tanggal_bayar');
            $table->string('bukti_bayar')->nullable(); // Untuk menampung foto upload bukti transfer
            $table->enum('status', ['Lunas', 'Belum bayar', 'Telat bayar'])->default('Belum bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
