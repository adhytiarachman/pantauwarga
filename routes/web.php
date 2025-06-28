<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Middleware\IsAdmin;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

use App\Http\Controllers\Admin\BansosController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\JenisPembayaranController;
use App\Http\Controllers\User\PembayaranController as UserPembayaranController;

use App\Http\Controllers\DokuPaymentController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\User\ChatAIController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use League\CommonMark\CommonMarkConverter;


/*
|--------------------------------------------------------------------------|
| Web Routes                                                              |
|--------------------------------------------------------------------------|
*/

// Landing page
Route::get('/', function () {
    return view('home');
})->name('home');

// Static pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Dashboard after login (general redirect, not specific to role)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('guest')->get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::middleware('guest')->post('/register', [RegisterController::class, 'register']);

// Admin Routes (with IsAdmin middleware)
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('penduduk', PendudukController::class);
    Route::resource('informasi', InformasiController::class);
    Route::resource('payment', PembayaranController::class);
    Route::resource('bansos', BansosController::class); //bansos
    Route::get('/approvals', [UserApprovalController::class, 'index'])->name('admin.approvals');
    Route::post('/approvals/{user}/approve', [UserApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::post('/approvals/{user}/reject', [UserApprovalController::class, 'reject'])->name('admin.approvals.reject');

    Route::get('/pembayaran', [UserPembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/{id}/bayar', [UserPembayaranController::class, 'bayar'])->name('pembayaran.bayar');
    Route::patch('/pembayaran/update-status/{id}', [PembayaranController::class, 'updateStatus'])->name('admin.pembayaran.updateStatus');
    Route::resource('pembyaran', PembayaranController::class)->names('admin.pembayaran');
    Route::resource('admin/jenis-pembayaran', JenisPembayaranController::class)
        ->names([
            'index' => 'jenis-pembayaran.index',
            'create' => 'jenis-pembayaran.create',
            'store' => 'jenis-pembayaran.store',
            'show' => 'jenis-pembayaran.show',
            'edit' => 'jenis-pembayaran.edit',
            'update' => 'jenis-pembayaran.update',
            'destroy' => 'jenis-pembayaran.destroy',
        ]);


});

// 📌 User Routes (halaman pengguna biasa)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/data-diri', [UserDashboardController::class, 'dataDiri'])->name('data-diri');
    Route::get('/anggota-keluarga', [UserDashboardController::class, 'anggotaKeluarga'])->name('anggota-keluarga');
    Route::get('/informasi', [UserDashboardController::class, 'informasi'])->name('informasi');
    Route::get('/bansos-saya', [UserDashboardController::class, 'bansosSaya'])->name('bansos-saya');

    // 🧾 Pembayaran (User)
    Route::get('/pembayaran', [UserPembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/create', [UserPembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran/store', [UserPembayaranController::class, 'store'])->name('pembayaran.store');
    Route::patch('/pembayaran/{id}/bayar', [UserPembayaranController::class, 'bayar'])->name('pembayaran.bayar');
    Route::post('/pembayaran/{id}/bayar', [UserPembayaranController::class, 'bayar'])->name('pembayaran.bayar');

    // 🔁 DOKU Payment Redirect
    Route::get('/bayar-doku/{id}', [DokuPaymentController::class, 'pay'])->name('bayar-doku');



    // 🤖 Chatbot AI untuk user
    Route::get('/chat-ai', [ChatAIController::class, 'index'])->name('chat-ai');
    Route::post('/chat-ai', [ChatAIController::class, 'ask'])->name('chat-ai.ask');
    Route::post('/chat-ai/ask', [ChatAIController::class, 'ask'])->name('chat-ai.ask');

    Route::get('/chat-ai/{topic}', [ChatController::class, 'chatByTopic'])->name('chat.by.topic');
    Route::get('/chat-ai/new', [ChatAIController::class, 'newTopic'])->name('chat-ai.new');

    Route::post('/chat-ai/new', [ChatAIController::class, 'newTopic'])->name('chat-ai.new.post');

    Route::patch('/chat-ai/{id}/rename', [ChatAIController::class, 'renameTopic'])->name('chat-ai.rename');
    Route::delete('/chat-ai/{id}', [ChatAIController::class, 'deleteTopic'])->name('chat-ai.delete');



});

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handleCallback']);



