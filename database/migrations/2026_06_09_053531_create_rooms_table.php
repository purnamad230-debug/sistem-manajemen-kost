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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->decimal('harga', 12, 2);
            $table->text('fasilitas');
            $table->string('foto')->nullable();
            $table->enum('status', ['Kosong', 'Terisi', 'Maintenance'])->default('Kosong');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
    public function bookings() 
    {
    return $this->hasMany(Booking::class);
    }
};
