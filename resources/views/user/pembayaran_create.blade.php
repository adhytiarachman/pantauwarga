@extends('layouts.user')

@section('title', 'Buat Pembayaran Iuran')

@section('content')
    <div class="container py-5">
        <!-- Heading with animation -->
        <h3 class="fw-semibold mb-4 text-center animate__animated animate__fadeIn animate__delay-1s"
            style="font-size: 2rem; color: #333;">💰 Buat Pembayaran Iuran Kebersihan dan Keamanan</h3>

        <!-- Payment Form -->
        <form method="POST" action="{{ route('user.pembayaran.store') }}"
            class="animate__animated animate__fadeIn animate__delay-2s">
            @csrf

            <div class="mb-4">
                <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran" required
                    onchange="updateAmount()">
                    <option value="Keamanan" selected>Keamanan - Rp 35.000</option>
                    <option value="Kebersihan">Kebersihan - Rp 20.000</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required min="1000" value="35000"
                    readonly>
            </div>

            <div class="mb-4">
                <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" required
                    value="{{ now()->toDateString() }}">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3"
                style="font-size: 1.2rem; transition: background-color 0.3s;">
                Kirim Pembayaran
            </button>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- Add animations using Animate.css library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <script>
        // Update the amount when payment type is changed
        function updateAmount() {
            const paymentType = document.getElementById('jenis_pembayaran').value;
            const amountField = document.getElementById('jumlah');

            if (paymentType === 'Keamanan') {
                amountField.value = 35000;
            } else {
                amountField.value = 20000;
            }
        }
    </script>
@endsection