@extends('layouts.admin')

@section('title', 'Kelola Jenis Pembayaran')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Kelola Jenis Pembayaran</h2>

        {{-- Form Tambah Jenis Pembayaran --}}
        <form method="POST" action="{{ route('jenis-pembayaran.store') }}" class="mb-4">
            @csrf
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="nama" class="form-control"
                        placeholder="Nama Jenis Pembayaran (Contoh: Kebersihan)" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="nominal" class="form-control" placeholder="Nominal (Contoh: 20000)" required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Tambah</button>
                </div>
            </div>
        </form>

        {{-- Tabel Data Jenis Pembayaran --}}
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nominal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenisPembayarans as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>Rp {{ number_format($item->nominal) }}</td>
                        <td>
                            <form method="POST" action="{{ route('jenis-pembayaran.destroy', $item->id) }}"
                                onsubmit="return confirm('Yakin ingin menghapus jenis pembayaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if ($jenisPembayarans->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada jenis pembayaran</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection