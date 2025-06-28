<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat tabel baru dengan kolom `id`
        Schema::create('chat_topics_temp', function (Blueprint $table) {
            $table->id(); // Primary key autoincrement
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->timestamps();
        });

        // 2. Salin data dari tabel lama ke tabel baru
        DB::statement('INSERT INTO chat_topics_temp (user_id, title, created_at, updated_at)
                       SELECT user_id, title, created_at, updated_at FROM chat_topics');

        // 3. Hapus tabel lama
        Schema::drop('chat_topics');

        // 4. Ganti nama tabel baru menjadi nama tabel lama
        Schema::rename('chat_topics_temp', 'chat_topics');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback jika dibutuhkan (tanpa kolom `id`)
        Schema::create('chat_topics_old', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->timestamps();
        });

        DB::statement('INSERT INTO chat_topics_old (user_id, title, created_at, updated_at)
                       SELECT user_id, title, created_at, updated_at FROM chat_topics');

        Schema::drop('chat_topics');
        Schema::rename('chat_topics_old', 'chat_topics');
    }
};
