<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk pengguna biasa.
     */
    public function index()
    {
        return view('user.dashboard');  // Ganti dengan tampilan dashboard untuk pengguna
    }
}
