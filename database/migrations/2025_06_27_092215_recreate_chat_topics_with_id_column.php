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
        // 1. Buat tabel sementara dengan kolom `id`
        Schema::create('chat_topics_temp', function (Blueprint $table) {
            $table->id(); // Auto increment primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->timestamps();
        });

        // 2. Pindahkan data dari tabel lama ke tabel baru
        DB::statement('INSERT INTO chat_topics_temp (user_id, title, created_at, updated_at)
                   SELECT user_id, title, created_at, updated_at FROM chat_topics');

        // 3. Hapus tabel lama
        Schema::drop('chat_topics');

        // 4. Ganti nama tabel baru ke nama lama
        Schema::rename('chat_topics_temp', 'chat_topics');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('chat_topics');
    }
};
