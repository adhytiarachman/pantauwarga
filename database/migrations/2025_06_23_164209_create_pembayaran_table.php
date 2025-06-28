<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel pembayaran.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('jenis_pembayaran', ['Kebersihan', 'Keamanan']); // Hanya dua jenis pembayaran
            $table->decimal('jumlah', 15, 2); // Jumlah untuk Kebersihan atau Keamanan
            $table->date('tanggal_pembayaran'); // Tanggal pembayaran
            $table->enum('status', ['Lunas', 'Belum Lunas'])->default('Belum Lunas'); // Status pembayaran
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Mengembalikan perubahan dari migrasi ini.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
