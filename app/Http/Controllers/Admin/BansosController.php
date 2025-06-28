<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bansos;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BansosController extends Controller
{
    public function index()
    {
        // Ambil data bansos aktif dan selesai
        $activeBansos = Bansos::where('status', 'aktif')->with('penduduk')->paginate(40);
        $pastBansos = Bansos::where('status', 'selesai')->with('penduduk')->paginate(40);

        return view('admin.bansos.index', compact('activeBansos', 'pastBansos'));
    }

    public function create(Request $request)
    {
        $penduduk = Penduduk::all();

        $incomeCriteria = $request->input('income_criteria');
        $incomeThreshold = $request->input('income_threshold');

        $eligiblePenduduk = $penduduk->filter(function ($item) use ($incomeCriteria, $incomeThreshold) {
            if ($incomeCriteria == 'individual') {
                return $item->income_per_month <= $incomeThreshold;
            }

            if ($incomeCriteria == 'total_kk') {
                $pendapatanPerKK = Penduduk::where('no_kk', $item->no_kk)->sum('income_per_month');
                return $pendapatanPerKK <= $incomeThreshold;
            }

            if ($incomeCriteria == 'average_kk') {
                $averagePendapatanPerKK = Penduduk::where('no_kk', $item->no_kk)->avg('income_per_month');
                return $averagePendapatanPerKK <= $incomeThreshold;
            }

            return false;
        });

        return view('admin.bansos.create', compact('eligiblePenduduk', 'incomeCriteria', 'incomeThreshold'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduks,id',
            'source' => 'required|string',
            'aid_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $penduduk = Penduduk::findOrFail($request->penduduk_id);

        $totalIncomePerKK = Penduduk::where('no_kk', $penduduk->no_kk)->sum('income_per_month');

        $bansos = new Bansos;
        $bansos->penduduk_id = $penduduk->id;
        $bansos->income = $totalIncomePerKK;
        $bansos->source = $request->source;
        $bansos->aid_type = $request->aid_type;
        $bansos->start_date = $request->start_date;
        $bansos->end_date = $request->end_date;
        $bansos->status = 'aktif';
        $bansos->save();

        return redirect()->route('bansos.index')->with('success', 'Data Bansos berhasil disimpan.');
    }

    public function destroy($id)
{
    $bansos = Bansos::findOrFail($id);
    $bansos->status = 'selesai'; // bukan delete
    $bansos->save();

    return redirect()->route('bansos.index')->with('success', 'Data bansos dipindahkan ke riwayat.');
}

    public function deleteExpiredBansos()
    {
        $expiredBansos = Bansos::where('end_date', '<', Carbon::today())->get();
        foreach ($expiredBansos as $bansos) {
            $bansos->delete();
        }
    }
}
