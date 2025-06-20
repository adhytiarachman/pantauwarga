<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Informasi;
use App\Models\Penduduk;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    $informasi = Informasi::latest()->get();
    $penduduk = Penduduk::where('user_id', Auth::id())->first();

    $kepalaKeluarga = null;

    if ($penduduk) {
        $kepalaKeluarga = Penduduk::where('no_kk', $penduduk->no_kk)
            ->where('is_kepala_keluarga', true)
            ->first();

        // Jika nama kepala keluarga disimpan di kolom `nama_kepala_keluarga`
        if ($kepalaKeluarga && !$kepalaKeluarga->nama) {
            $kepalaKeluarga->nama = $kepalaKeluarga->nama_kepala_keluarga;
        }
    }

    return view('user.dashboard', compact('informasi', 'penduduk', 'kepalaKeluarga'));
}
}