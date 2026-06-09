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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel users (penghuni)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Foreign Key ke tabel rooms (kamar)
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Nullable jika sewa panjang/bulanan terus berjalan
            $table->enum('status', ['active', 'completed', 'canceled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
    public function user() 
    {
    return $this->belongsTo(User::class);
    }
    public function room() 
    {
        return $this->belongsTo(Room::class);
    }
    public function payments() 
    {
        return $this->hasMany(Payment::class);
    }
};
