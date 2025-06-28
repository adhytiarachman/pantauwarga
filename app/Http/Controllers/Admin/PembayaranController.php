<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\JenisPembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with(['user', 'jenis'])->latest()->get();
        $jenisPembayarans = JenisPembayaran::all();

        return view('admin.payment.index', compact('pembayarans', 'jenisPembayarans'));
    }

    public function create()
    {
        $users = User::all();
        $jenisPembayaran = JenisPembayaran::all();

        return view('admin.payment.create', compact('users', 'jenisPembayaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_pembayaran_id' => 'required|exists:jenis_pembayarans,id',
            'jumlah' => 'required|numeric|min:100',
            'tanggal_pembayaran' => 'required|date',
        ]);

        Pembayaran::create([
            'user_id' => $request->user_id,
            'jenis_pembayaran_id' => $request->jenis_pembayaran_id,
            'jumlah' => $request->jumlah,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'status' => 'Menunggu', // default
        ]);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $users = User::all();
        $jenisPembayaran = JenisPembayaran::all();

        return view('admin.payment.edit', compact('pembayaran', 'users', 'jenisPembayaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_pembayaran_id' => 'required|exists:jenis_pembayarans,id',
            'jumlah' => 'required|numeric|min:100',
            'tanggal_pembayaran' => 'required|date',
            'status' => 'required|in:Menunggu,Lunas',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update($request->only([
            'user_id',
            'jenis_pembayaran_id',
            'jumlah',
            'tanggal_pembayaran',
            'status'
        ]));

        return redirect()->route('admin.pembayaran.index')->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }
}
