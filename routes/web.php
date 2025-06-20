<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Middleware\IsAdmin;
use App\Models\Informasi;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserApprovalController;




/*
|---------------------------------------------------------------------------|
| Web Routes                                                               |
|---------------------------------------------------------------------------|
*/

// Rute untuk halaman depan / landing page
Route::get('/', function () {
    return view('home'); // Ganti dengan landing page jika perlu
})->name('home');

// Rute untuk halaman about dan contact
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Rute untuk dashboard setelah login, hanya untuk pengguna yang sudah terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute untuk halaman profile pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute untuk login dan logout
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rute register untuk pengguna baru
Route::middleware('guest')->get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::middleware('guest')->post('/register', [RegisterController::class, 'register']);


// Rute khusus admin, dilindungi oleh middleware IsAdmin
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('penduduk', PendudukController::class);
    Route::resource('informasi', InformasiController::class);
    Route::get('/approvals', [\App\Http\Controllers\Admin\UserApprovalController::class, 'index'])->name('admin.approvals');
    Route::post('/approvals/{user}/approve', [\App\Http\Controllers\Admin\UserApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::post('/approvals/{user}/reject', [UserApprovalController::class, 'reject'])->name('admin.approvals.reject');
});

// Route untuk halaman dashboard pengguna biasa
Route::middleware(['auth'])->get('/user/dashboard', function () {
    return view('user.dashboard');  // Halaman untuk pengguna biasa
})->name('user.dashboard');

Route::middleware(['auth'])->get('/user/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');

