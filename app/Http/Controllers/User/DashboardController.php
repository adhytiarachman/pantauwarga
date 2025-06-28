<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Informasi;
use App\Models\Penduduk;
use App\Models\Pembayaran;
use App\Models\Bansos;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Halaman utama dashboard (hanya grafik).
     */
    public function index()
    {
        $penduduk = Penduduk::where('user_id', Auth::id())->first();
        $totalPenduduk = Penduduk::count();
        $totalKK = Penduduk::distinct('no_kk')->count('no_kk');
        $menetap = Penduduk::where('status_tinggal', 'Menetap')->count();
        $sementara = Penduduk::where('status_tinggal', 'Sementara')->count();

        if (!$penduduk) {
            return redirect()->route('logout'); // Pengaman jika tidak ada data user
        }

        // Ambil data pekerjaan untuk grafik
        $pekerjaanData = Penduduk::select('pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('pekerjaan')
            ->groupBy('pekerjaan')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'pekerjaan');

        // Distribusi usia berdasarkan kategori (khusus keluarga user)
        $usiaCounts = [
            'Anak' => Penduduk::where('no_kk', $penduduk->no_kk)->where('usia', '<', 12)->count(),
            'Remaja' => Penduduk::where('no_kk', $penduduk->no_kk)->whereBetween('usia', [12, 17])->count(),
            'Dewasa' => Penduduk::where('no_kk', $penduduk->no_kk)->whereBetween('usia', [18, 59])->count(),
            'Lansia' => Penduduk::where('no_kk', $penduduk->no_kk)->where('usia', '>=', 60)->count(),
        ];

        // Distribusi jenis kelamin (khusus keluarga user)
        $genderCounts = Penduduk::where('no_kk', $penduduk->no_kk)
            ->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');

        // Ambil data Status Perkawinan untuk grafik
        $status_perkawinanData = Penduduk::select('status_perkawinan', DB::raw('count(*) as total'))
            ->groupBy('status_perkawinan') // Mengelompokkan berdasarkan status perkawinan
            ->get();

        // Ambil jumlah Status Perkawinan untuk grafik
        $BelumMenikah = $status_perkawinanData->where('status_perkawinan', 'Belum Menikah')->first()->total ?? 0;
        $Menikah = $status_perkawinanData->where('status_perkawinan', 'Menikah')->first()->total ?? 0;
        $JandaDuda = $status_perkawinanData->where('status_perkawinan', 'Janda/Duda')->first()->total ?? 0;

        // Hitung jumlah berdasarkan agama
        $agamaData = Penduduk::select('agama', DB::raw('count(*) as total'))
            ->groupBy('agama') // Mengelompokkan berdasarkan agama
            ->get();

        // Ambil jumlah agama
        $Islam = $agamaData->where('agama', 'Islam')->first()->total ?? 0;
        $Kristen = $agamaData->where('agama', 'Kristen')->first()->total ?? 0;
        $Katolik = $agamaData->where('agama', 'Katolik')->first()->total ?? 0;
        $Hindu = $agamaData->where('agama', 'Hindu')->first()->total ?? 0;
        $Buddha = $agamaData->where('agama', 'Buddha')->first()->total ?? 0;
        $Konghucu = $agamaData->where('agama', 'Konghucu')->first()->total ?? 0;

        // Ambil data Bansos untuk pengguna
        $bansos = Bansos::where('user_id', Auth::id())
            ->where('end_date', '>=', now()) // Pastikan Bansos masih berlaku
            ->first(); // Ambil data pertama (jika ada)


        // Ambil semua data penduduk (jumlah_anggota dan income)
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

        return view('user.dashboard', compact(
            'penduduk',
            'usiaCounts',
            'genderCounts',
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
            'bansos',
            'perKeluarga',
            'perIndividu',
            'jumlahLaki',
            'jumlahPerempuan',
            'usiaData'
        ));
    }

    /**
     * Halaman Data Diri pengguna.
     */
    public function dataDiri()
    {
        $penduduk = Penduduk::where('user_id', Auth::id())->first();
        return view('user.data-diri', compact('penduduk'));
    }

    /**
     * Halaman Anggota Keluarga pengguna.
     */
    public function anggotaKeluarga()
    {
        $penduduk = Penduduk::where('user_id', Auth::id())->first();
        $keluarga = collect();

        if ($penduduk) {
            $keluarga = Penduduk::where('no_kk', $penduduk->no_kk)->get();
        }

        return view('user.anggota-keluarga', compact('keluarga'));
    }

    /**
     * Halaman Informasi.
     */
    public function informasi()
    {
        $informasi = Informasi::latest()->get();
        return view('user.informasi', compact('informasi'));
    }

    /**
     * Halaman Pembayaran.
     */
    public function pembayaran()
    {
        // Mengambil data pembayaran untuk user yang sedang login
        $pembayaran = Pembayaran::where('user_id', auth()->id())->get();

        // Mengirimkan data pembayaran ke tampilan
        return view('user.pembayaran', compact('pembayaran'));
    }

    /**
     * Halaman Informasi Bansos.
     */

    public function bansosSaya()
    {
        $user = Auth::user();

        if (!$user->penduduk) {
            return view('user.bansos', [
                'bansosAktif' => [],
                'bansosRiwayat' => [],
            ]);
        }

        $pendudukId = $user->penduduk->id;

        $bansosAktif = Bansos::where('penduduk_id', $pendudukId)
            ->whereDate('end_date', '>=', now())
            ->get();

        $bansosRiwayat = Bansos::where('penduduk_id', $pendudukId)
            ->whereDate('end_date', '<', now())
            ->get();

        return view('user.bansos-saya', compact('bansosAktif', 'bansosRiwayat'));
    }
}
