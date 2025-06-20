<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penduduk;

class TandaiKepalaKeluarga extends Command
{
    /**
     * Nama perintah artisan.
     */
    protected $signature = 'penduduk:tandai-kepala-keluarga';

    /**
     * Deskripsi perintah.
     */
    protected $description = 'Menandai kepala keluarga berdasarkan nama_kepala_keluarga dan nama penduduk';

    /**
     * Jalankan perintah console.
     */
    public function handle()
{
    $this->info('Memulai proses penandaan kepala keluarga...');

    $kks = \App\Models\Penduduk::select('no_kk')->distinct()->pluck('no_kk');
    $total = 0;

    foreach ($kks as $no_kk) {
        $anggota = \App\Models\Penduduk::where('no_kk', $no_kk)->get();

        // Ambil nama_kepala_keluarga yang pertama
        $namaKK = $anggota->first()->nama_kepala_keluarga ?? null;

        if (!$namaKK) {
            $this->warn("⚠️ Nama kepala keluarga tidak ditemukan pada KK: $no_kk");
            continue;
        }

        // Cari siapa yang punya nama_kepala_keluarga = namaKK
        $calon = $anggota->firstWhere('nama_kepala_keluarga', $namaKK);

        if ($calon) {
            $calon->is_kepala_keluarga = true;
            $calon->save();

            $this->info("✅ Kepala keluarga ditandai: {$namaKK} (KK: {$no_kk})");
            $total++;
        } else {
            $this->warn("⚠️ Tidak ada anggota cocok dengan nama kepala keluarga untuk KK: {$no_kk}");
        }
    }

    $this->info("Selesai. Total kepala keluarga berhasil ditandai: {$total}");
}

}
