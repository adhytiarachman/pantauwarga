<?php

namespace App\Http\Controllers\Auth;

use App\Models\Penduduk;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi.
     */
    public function showRegistrationForm()
    {
        $penduduks = Penduduk::whereNull('user_id')->get(); // tampilkan yang belum punya akun
        return view('auth.register', compact('penduduks'));
    }

    /**
     * Menangani pendaftaran pengguna baru.
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'no_kk' => 'required|exists:penduduks,no_kk',
            'penduduk_id' => 'required|exists:penduduks,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $penduduk = Penduduk::find($validated['penduduk_id']);

        // Cegah penduduk yang sama mendaftar 2x
        if ($penduduk->user_id) {
            return back()->withErrors(['penduduk_id' => 'Penduduk ini sudah terdaftar.']);
        }

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_kk' => $validated['no_kk'],
            'nik' => $penduduk->nik,
            'is_approved' => false,
            'is_admin' => false,
        ]);

        // Relasikan penduduk dengan user
        $penduduk->user_id = $user->id;
        $penduduk->save();

        // Redirect ke login dengan notifikasi sukses
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan tunggu persetujuan admin.');
    }
}
