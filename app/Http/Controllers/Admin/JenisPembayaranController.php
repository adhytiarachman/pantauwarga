<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisPembayaran;

class JenisPembayaranController extends Controller
{
    public function index()
    {
        $jenisPembayarans = JenisPembayaran::all();

        return view('admin.jenis.index', compact('jenisPembayarans'));
    }

    public function create()
    {
        return view('admin.jenis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nominal' => 'required|numeric|min:100',
        ]);

        JenisPembayaran::create($request->only('nama', 'nominal'));
        return redirect()->route('jenis-pembayaran.index')->with('success', 'Jenis pembayaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jenis = JenisPembayaran::findOrFail($id);
        return view('admin.jenis.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nominal' => 'required|numeric|min:100',
        ]);

        $jenis = JenisPembayaran::findOrFail($id);
        $jenis->update($request->only('nama', 'nominal'));
        return redirect()->route('jenis-pembayaran.index')->with('success', 'Data diperbarui');
    }

    public function destroy($id)
    {
        JenisPembayaran::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data dihapus');
    }
}
