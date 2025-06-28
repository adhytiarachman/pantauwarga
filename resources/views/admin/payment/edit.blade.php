@extends('layouts.admin')
@section('title', 'Edit Pembayaran')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">✏️ Edit Pembayaran</h2>

        <form action="{{ route('admin.pembayaran.update', $pembayaran->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $pembayaran->user_id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="jenis_pembayaran_id" class="form-label">Jenis Pembayaran</label>
                <select name="jenis_pembayaran_id" id="jenis_pembayaran_id" class="form-select" required>
                    @foreach ($jenisPembayaran as $jenis)
                        <option value="{{ $jenis->id }}" {{ $jenis->id == $pembayaran->jenis_pembayaran_id ? 'selected' : '' }}>
                            {{ $jenis->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ $pembayaran->jumlah }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control"
                    value="{{ $pembayaran->tanggal_pembayaran }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="Menunggu" {{ $pembayaran->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Lunas" {{ $pembayaran->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Pembayaran</button>
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection