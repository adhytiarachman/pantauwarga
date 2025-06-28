<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung data agregat
        $totalPenduduk = Penduduk::count();
        $totalKK = Penduduk::distinct('no_kk')->count('no_kk');
        $menetap = Penduduk::where('status_tinggal', 'Menetap')->count();
        $sementara = Penduduk::where('status_tinggal', 'Sementara')->count();

        // Ambil data pekerjaan untuk grafik
        $pekerjaanData = Penduduk::select('pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('pekerjaan')
            ->groupBy('pekerjaan')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'pekerjaan');

        // Ambil data status perkawinan
        $status_perkawinanData = Penduduk::select('status_perkawinan', DB::raw('count(*) as total'))
            ->groupBy('status_perkawinan')
            ->get();

        $BelumMenikah = $status_perkawinanData->where('status_perkawinan', 'Belum Menikah')->first()->total ?? 0;
        $Menikah = $status_perkawinanData->where('status_perkawinan', 'Menikah')->first()->total ?? 0;
        $JandaDuda = $status_perkawinanData->where('status_perkawinan', 'Janda/Duda')->first()->total ?? 0;

        // Agama
        $agamaData = Penduduk::select('agama', DB::raw('count(*) as total'))
            ->groupBy('agama')
            ->get();

        $Islam = $agamaData->where('agama', 'Islam')->first()->total ?? 0;
        $Kristen = $agamaData->where('agama', 'Kristen')->first()->total ?? 0;
        $Katolik = $agamaData->where('agama', 'Katolik')->first()->total ?? 0;
        $Hindu = $agamaData->where('agama', 'Hindu')->first()->total ?? 0;
        $Buddha = $agamaData->where('agama', 'Buddha')->first()->total ?? 0;
        $Konghucu = $agamaData->where('agama', 'Konghucu')->first()->total ?? 0;

        // Hitung total income per KK
        $dataKK = Penduduk::select('no_kk')
            ->groupBy('no_kk')
            ->get()
            ->map(function ($kk) {
                $anggota = Penduduk::where('no_kk', $kk->no_kk)->get();
                $kk->total_income = $anggota->sum('income_per_month');
                $kk->total_anggota = $anggota->count();
                return $kk;
            });

        // Inisialisasi kategori pendapatan per keluarga
        $perKeluarga = [
            '0 - 3 juta' => 0,
            '3 - 6 juta' => 0,
            '6 - 20 juta' => 0,
            '> 20 juta' => 0,
        ];

        foreach ($dataKK as $kk) {
            $incomeKK = $kk->total_income;

            if ($incomeKK <= 3000000) {
                $perKeluarga['0 - 3 juta']++;
            } elseif ($incomeKK <= 6000000) {
                $perKeluarga['3 - 6 juta']++;
            } elseif ($incomeKK <= 20000000) {
                $perKeluarga['6 - 20 juta']++;
            } else {
                $perKeluarga['> 20 juta']++;
            }
        }

        // Inisialisasi kategori pendapatan per individu
        $perIndividu = [
            '0 - 1 juta' => 0,
            '1 - 2 juta' => 0,
            '2 - 5 juta' => 0,
            '> 5 juta' => 0,
        ];

        $semuaPenduduk = Penduduk::all();

        foreach ($semuaPenduduk as $p) {
            $income = $p->income_per_month ?? 0;

            if ($income <= 1000000) {
                $perIndividu['0 - 1 juta']++;
            } elseif ($income <= 2000000) {
                $perIndividu['1 - 2 juta']++;
            } elseif ($income <= 5000000) {
                $perIndividu['2 - 5 juta']++;
            } else {
                $perIndividu['> 5 juta']++;
            }
        }

        // Statistik Jenis Kelamin
        $jumlahLaki = Penduduk::where('jenis_kelamin', 'Laki-laki')->count();
        $jumlahPerempuan = Penduduk::where('jenis_kelamin', 'Perempuan')->count();

        // Statistik Usia
        $usiaData = [
            'Bayi (0-2)' => 0,
            'Anak (3-12)' => 0,
            'Remaja (13-19)' => 0,
            'Dewasa (20-59)' => 0,
            'Lansia (60+)' => 0,
        ];

        $penduduks = Penduduk::all();
        foreach ($penduduks as $p) {
            if (!$p->tanggal_lahir)
                continue;

            $umur = Carbon::parse($p->tanggal_lahir)->age;

            if ($umur <= 2)
                $usiaData['Bayi (0-2)']++;
            elseif ($umur <= 12)
                $usiaData['Anak (3-12)']++;
            elseif ($umur <= 19)
                $usiaData['Remaja (13-19)']++;
            elseif ($umur <= 59)
                $usiaData['Dewasa (20-59)']++;
            else
                $usiaData['Lansia (60+)']++;
        }

        return view('admin.dashboard', compact(
            'totalPenduduk',
            'totalKK',
            'menetap',
            'sementara',
            'pekerjaanData',
            'BelumMenikah',
            'Menikah',
            'JandaDuda',
            'Islam',
            'Kristen',
            'Katolik',
            'Hindu',
            'Buddha',
            'Konghucu',
            'perKeluarga',
            'perIndividu',
            'jumlahLaki',
            'jumlahPerempuan',
            'usiaData'
        ));
    }
}
