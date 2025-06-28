@extends('layouts.admin')
@section('title', 'Tambah Pembayaran')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">💳 Tambah Data Pembayaran Warga</h2>

        <form method="POST" action="{{ route('payment.store') }}">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">Pilih User</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="jenis_pembayaran_id" class="form-label">Jenis Pembayaran</label>
                <select name="jenis_pembayaran_id" id="jenis_pembayaran_id" class="form-select" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach ($jenisPembayaran as $jenis)
                        <option value="{{ $jenis->id }}">{{ $jenis->nama }} - Rp {{ number_format($jenis->nominal) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" required min="100">
            </div>

            <div class="mb-3">
                <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Simpan Pembayaran</button>
        </form>
    </div>
@endsection