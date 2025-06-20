<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'penduduk_id' => ['required', 'exists:penduduks,id'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $penduduk = Penduduk::find($request->penduduk_id);

        $existingUser = User::where('nik', $penduduk->nik)->first();
        if ($existingUser) {
            if (!$existingUser->is_approved) {
                return back()->withErrors(['email' => 'Akun Anda sudah terdaftar dan sedang menunggu persetujuan admin.']);
            } else {
                return back()->withErrors(['email' => 'Data ini sudah digunakan untuk akun yang aktif.']);
            }
        }

        $user = User::create([
            'name' => $penduduk->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $penduduk->nik,
            'kk' => $penduduk->kk,
            'is_approved' => false,
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('register_success', 'Registrasi berhasil! Silakan tunggu persetujuan admin.');
    }
}
