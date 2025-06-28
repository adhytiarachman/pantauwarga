<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Pembayaran;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;

        try {
            $data = $request->all(); // Ambil JSON payload
            \Log::info('Midtrans Callback:', $data);

            $transactionStatus = $data['transaction_status'] ?? null;
            $orderId = $data['order_id'] ?? null;

            if (!$transactionStatus || !$orderId) {
                \Log::warning('Callback payload tidak lengkap', $data);
                return response()->json(['message' => 'Bad Request'], 400);
            }

            $pembayaran = \App\Models\Pembayaran::where('invoice_number', $orderId)->first();

            if (!$pembayaran) {
                \Log::warning("Pembayaran dengan order_id $orderId tidak ditemukan.");
                return response()->json(['message' => 'Not found'], 404);
            }

            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                $pembayaran->status = 'Lunas';
            } elseif ($transactionStatus === 'expire') {
                $pembayaran->status = 'Expired';
            } elseif ($transactionStatus === 'cancel') {
                $pembayaran->status = 'Dibatalkan';
            } else {
                $pembayaran->status = ucfirst($transactionStatus); // fallback
            }

            $pembayaran->save();

            \Log::info("Status pembayaran order_id {$orderId} diupdate ke: {$pembayaran->status}");

            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            \Log::error('Webhook Midtrans error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }


}
