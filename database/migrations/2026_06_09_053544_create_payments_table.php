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
            // Menghubungkan pembayaran ke booking tertentu
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->integer('amount');
            $table->date('payment_date');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('proof_of_payment')->nullable(); // Tempat menyimpan nama file foto bukti bayar
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
