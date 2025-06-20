<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk; 

class DashboardController extends Controller
{
     public function index()
    {
        return view('admin.dashboard', [
            'totalPenduduk' => Penduduk::count(),
            'totalKK' => Penduduk::distinct('no_kk')->count('no_kk'),
            'menetap' => Penduduk::where('status_tinggal', 'Menetap')->count(),
            'sementara' => Penduduk::where('status_tinggal', 'Sementara')->count(),
        ]);
    }
}
