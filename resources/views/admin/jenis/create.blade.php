@extends('layouts.admin')
@section('title', 'Tambah Jenis Pembayaran')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Tambah Jenis Pembayaran</h2>

        <form action="{{ route('jenis-pembayaran.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Jenis Pembayaran</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal (Rp)</label>
                <input type="number" name="nominal" class="form-control" required min="1000">
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>


@endsection