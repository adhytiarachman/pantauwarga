<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $no_kkFilter = $request->query('no_kk');
        $search = $request->query('search');

        $allNoKK = Penduduk::select('no_kk')->distinct()->pluck('no_kk');
        $query = Penduduk::query();

        if ($no_kkFilter) {
            $query->where('no_kk', $no_kkFilter);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_kepala_keluarga', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $penduduks = $query->orderBy('no_kk')->orderBy('nama_kepala_keluarga')->get();
        $groupedPenduduk = $penduduks->groupBy('no_kk');

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

        $data = $request->validate([
            'no_kk' => 'required|string',
            'nik' => 'required|string|unique:penduduks,nik',
            'nama_kepala_keluarga' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'usia' => 'required|integer|min:0',
            'alamat' => 'required|string',
            'status_tinggal' => 'required|in:Menetap,Sementara',
            'is_kepala_keluarga' => 'boolean',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
        ]);

        if ($data['is_kepala_keluarga']) {
            Penduduk::where('no_kk', $data['no_kk'])->update(['is_kepala_keluarga' => false]);
        }

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

        $data = $request->validate([
            'no_kk' => 'required|string',
            'nik' => 'required|string|unique:penduduks,nik,' . $penduduk->id,
            'nama_kepala_keluarga' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'usia' => 'required|integer|min:0',
            'alamat' => 'required|string',
            'status_tinggal' => 'required|in:Menetap,Sementara',
            'is_kepala_keluarga' => 'boolean',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
        ]);

        if ($data['is_kepala_keluarga']) {
            Penduduk::where('no_kk', $data['no_kk'])
                ->where('id', '!=', $penduduk->id)
                ->update(['is_kepala_keluarga' => false]);
        }

        $penduduk->update($data);

        return redirect()->route('penduduk.index')->with('success', 'Data anggota keluarga berhasil diupdate.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        return redirect()->route('penduduk.index')->with('success', 'Data berhasil dihapus.');
    }
}
