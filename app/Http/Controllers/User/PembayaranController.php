<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class PembayaranController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $pembayarans = Pembayaran::with('jenis')
            ->where('user_id', $userId)
            ->get();

        return view('user.pembayaran', compact('pembayarans'));
    }

    public function bayar($id)
    {
        $pembayaran = Pembayaran::with('jenis')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pembayaran->status === 'Lunas') {
            return redirect()->back()->with('success', 'Pembayaran sudah lunas.');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Simpan invoice
        $invoiceNumber = 'INV-' . strtoupper(Str::random(10));
        $pembayaran->invoice_number = $invoiceNumber;
        $pembayaran->save();

        // Data transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $invoiceNumber,
                'gross_amount' => (int) $pembayaran->jumlah,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email ?? 'test@example.com',
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('user.pembayaran_snap', compact('snapToken', 'pembayaran'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat token Midtrans: ' . $e->getMessage());
        }
    }

}
