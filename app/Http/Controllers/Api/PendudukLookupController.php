<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukLookupController extends Controller
{
    public function getByNoKk(Request $request)
    {
        $no_kk = $request->query('no_kk');

        if (!$no_kk) {
            return response()->json(['error' => 'no_kk wajib diisi'], 400);
        }

        $anggota = Penduduk::where('no_kk', $no_kk)
            ->whereNull('user_id') // hanya yang belum punya akun
            ->select('id', 'nama_kepala_keluarga as nama')// pilih kolom yang diperlukan
            ->get();

        
        return response()->json($anggota);
    }
}
