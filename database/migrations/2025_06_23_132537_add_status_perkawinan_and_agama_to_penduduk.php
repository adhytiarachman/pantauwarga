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
        Schema::table('penduduks', function (Blueprint $table) {
            $table->string('status_perkawinan')->nullable(); // Menambahkan kolom status_perkawinan
            $table->string('agama')->nullable(); // Menambahkan kolom agama
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn(['status_perkawinan', 'agama']); // Menghapus kolom yang ditambahkan
        });
    }
};
