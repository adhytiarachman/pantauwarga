@extends('layouts.user')

@section('title', 'Bayar Iuran - Midtrans')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .payment-container {
            max-width: 600px;
            margin: auto;
            padding: 40px;
            background: linear-gradient(to right, #ffffff, #f8f9fa);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease;
        }

        .payment-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            animation: slideInDown 0.8s ease-out;
        }

        .amount {
            font-size: 22px;
            font-weight: 600;
            color: #198754;
            text-align: center;
            margin-top: 10px;
            animation: zoomIn 1s ease;
        }

        #pay-button {
            display: block;
            width: 100%;
            margin-top: 30px;
            padding: 15px;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #28a745, #218838);
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
            animation: fadeIn 1.2s ease;
        }

        #pay-button:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInDown {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoomIn {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>

    <div class="container py-5">
        <div class="payment-container">
            <div class="payment-title">💳 Pembayaran Iuran</div>
            <p class="text-center">Jumlah yang harus dibayar:</p>
            <div class="amount">Rp {{ number_format($pembayaran->jumlah) }}</div>
            <button id="pay-button">Bayar Sekarang</button>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    alert("✅ Pembayaran sukses!");
                    window.location.href = "{{ route('user.pembayaran.index') }}";
                },
                onPending: function (result) {
                    alert("⏳ Menunggu pembayaran...");
                    window.location.href = "{{ route('user.pembayaran.index') }}";
                },
                onError: function (result) {
                    alert("❌ Pembayaran gagal.");
                    window.location.href = "{{ route('user.pembayaran.index') }}";
                }
            });
        });
    </script>
@endsection