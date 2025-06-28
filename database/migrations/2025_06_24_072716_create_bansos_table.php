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
        Schema::create('bansos', function (Blueprint $table) {
            $table->id();  // ID untuk setiap entri bansos
            $table->foreignId('penduduk_id')->constrained('penduduks')->onDelete('cascade'); // Relasi ke tabel users
            $table->decimal('income', 10, 2);  // Pendapatan per KK
            $table->string('source');  // Sumber Bansos
            $table->string('aid_type');  // Jenis Bantuan Sosial
            $table->date('start_date');  // Tanggal mulai
            $table->date('end_date');  // Tanggal berakhir
            
            $table->timestamps();  // Waktu pembuatan dan update
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bansos');
    }
};
