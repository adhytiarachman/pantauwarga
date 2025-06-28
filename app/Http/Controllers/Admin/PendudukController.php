<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan no_kk dan search
        $no_kkFilter = $request->query('no_kk');
        $search = $request->query('search');

        $allNoKK = Penduduk::select('no_kk')->distinct()->pluck('no_kk');
        $query = Penduduk::query();

        // Apply filter no_kk
        if ($no_kkFilter) {
            $query->where('no_kk', $no_kkFilter);
        }

        // Apply search by name or NIK
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_kepala_keluarga', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        // Fetch penduduk data and group by no_kk
        $penduduks = $query->orderBy('no_kk')->orderBy('nama_kepala_keluarga')->get();
        $groupedPenduduk = $penduduks->groupBy('no_kk');

        // Calculate total income per KK and average income per KK
        foreach ($groupedPenduduk as $key => $pendudukGroup) {
            $totalIncomePerKK = $pendudukGroup->sum('income_per_month');
            $averageIncomePerKK = $pendudukGroup->avg('income_per_month');
            
            foreach ($pendudukGroup as $penduduk) {
                // Attach total and average income to each penduduk in the group
                $penduduk->total_income_per_kk = $totalIncomePerKK;
                $penduduk->average_income_per_kk = $averageIncomePerKK;
            }
        }

        return view('admin.penduduk.index', compact('groupedPenduduk', 'allNoKK', 'no_kkFilter', 'search'));
    }

    public function create()
    {
        $allNoKK = Penduduk::select('no_kk')->distinct()->pluck('no_kk');
        return view('admin.penduduk.create', compact('allNoKK'));
    }

    public function store(Request $request)
    {
        $noKk = $request->input('no_kk') ?: $request->input('no_kk_input');

        $request->merge([
            'no_kk' => $noKk,
            'is_kepala_keluarga' => $request->has('is_kepala_keluarga'),
        ]);

        // Validate incoming request
        $data = $request->validate([
            'no_kk' => 'required|string',
            'nik' => 'required|string|unique:penduduks,nik',
            'nama_kepala_keluarga' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'usia' => 'required|integer|min:0',
            'alamat' => 'required|string',
            'status_tinggal' => 'required|in:Menetap,Sementara',
            'pekerjaan' => 'nullable|string|max:100',
            'is_kepala_keluarga' => 'boolean',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'status_perkawinan' => 'required|string',
            'agama' => 'required|string',
            'income_per_month' => 'nullable|numeric',
        ]);

        // Update kepala keluarga
        if ($data['is_kepala_keluarga']) {
            Penduduk::where('no_kk', $data['no_kk'])->update(['is_kepala_keluarga' => false]);
        }

        // Create new penduduk
        Penduduk::create($data);

        return redirect()->route('penduduk.index')->with('success', 'Data anggota keluarga berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Penduduk $penduduk)
    {
        $allNoKK = Penduduk::select('no_kk')->distinct()->pluck('no_kk');
        return view('admin.penduduk.edit', compact('penduduk', 'allNoKK'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $request->merge([
            'is_kepala_keluarga' => $request->has('is_kepala_keluarga'),
        ]);

        // Validate incoming request
        $data = $request->validate([
            'no_kk' => 'required|string',
            'nik' => 'required|string|unique:penduduks,nik,' . $penduduk->id,
            'nama_kepala_keluarga' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'usia' => 'required|integer|min:0',
            'alamat' => 'required|string',
            'status_tinggal' => 'required|in:Menetap,Sementara',
            'pekerjaan' => 'nullable|string|max:100',
            'is_kepala_keluarga' => 'boolean',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'status_perkawinan' => 'required|string',
            'agama' => 'required|string',
            'income_per_month' => 'nullable|numeric',
        ]);

        // Update kepala keluarga
        if ($data['is_kepala_keluarga']) {
            Penduduk::where('no_kk', $data['no_kk'])
                ->where('id', '!=', $penduduk->id)
                ->update(['is_kepala_keluarga' => false]);
        }

        // Update penduduk data
        $penduduk->update($data);

        return redirect()->route('penduduk.index')->with('success', 'Data anggota keluarga berhasil diupdate.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        return redirect()->route('penduduk.index')->with('success', 'Data berhasil dihapus.');
    }
}
