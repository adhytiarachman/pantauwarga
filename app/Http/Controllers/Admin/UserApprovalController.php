<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RejectedUser;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('status');

        if ($filter === 'approved') {
            $users = User::where('is_approved', true)->get();
        } elseif ($filter === 'rejected') {
            // Ambil dari tabel arsip penolakan
            $users = RejectedUser::latest()->get();
        } else {
            $users = User::where('is_approved', false)
                         ->where('is_rejected', false)
                         ->get();
        }

        return view('admin.approvals.index', compact('users', 'filter'));
    }

    public function approve(User $user)
    {
        $user->is_approved = true;
        $user->is_rejected = false;
        $user->save();

        return redirect()->route('admin.approvals')->with('success', 'User disetujui.');
    }

    public function reject(User $user)
    {
        // Simpan data ke tabel arsip
        RejectedUser::create([
            'name' => $user->name,
            'email' => $user->email,
            'no_kk' => $user->no_kk,
            'rejected_at' => now(),
        ]);

        // Hapus dari tabel user utama
        $user->delete();

        return redirect()->route('admin.approvals')->with('success', 'User ditolak dan diarsipkan.');
    }
}
