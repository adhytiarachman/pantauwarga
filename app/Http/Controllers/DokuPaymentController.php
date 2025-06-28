<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Pembayaran;

class DokuPaymentController extends Controller
{
    public function pay($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $url = env('DOKU_SANDBOX_URL') . '/checkout/v1/payment-page';
        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');

        $order = [
            'order' => [
                'invoice_number' => 'INV-' . time(),
                'amount' => $pembayaran->jumlah
            ],
            'product' => [
                [
                    'name' => 'Pembayaran RT06',
                    'price' => $pembayaran->jumlah,
                    'quantity' => 1
                ]
            ],
            'customer' => [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email
            ],
            'payment' => [
                'payment_due_date' => 60
            ]
        ];

        $requestId = Str::uuid()->toString();
        $timestamp = now()->format('Y-m-d\TH:i:s\Z');
        $signatureRaw = "Client-Id:$clientId\nRequest-Id:$requestId\nRequest-Timestamp:$timestamp\nRequest-Target:/checkout/v1/payment-page\n" . json_encode($order, JSON_UNESCAPED_SLASHES);
        $signature = base64_encode(hash_hmac('sha256', $signatureRaw, $secretKey, true));

        $response = Http::withHeaders([
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => "HMACSHA256=$signature",
            'Content-Type' => 'application/json'
        ])->post($url, $order);

        if ($response->successful()) {
            return redirect()->away($response['response']['payment']['url']);
        } else {
            return back()->with('error', 'Gagal menghubungkan ke DOKU.');
        }
    }
}
