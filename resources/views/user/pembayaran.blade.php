@extends('layouts.user')

@section('title', 'Pembayaran Iuran')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .table thead th {
            background: linear-gradient(to right, #2c3e50, #4ca1af);
            color: #fff;
            text-align: center;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .table tbody tr:hover {
            background: #f0f8ff;
            transform: scale(1.01);
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.75em;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1d976c, #2af598);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            transform: scale(1.05);
        }

        .alert {
            animation: fadeInDown 0.7s ease-in-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container py-5">
        <h3 class="fw-bold mb-4 text-center" data-aos="fade-down">💰 Pembayaran Iuran Warga</h3>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="table-responsive" data-aos="fade-up" data-aos-delay="200">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Jenis Kategori</th>
                        <th>Jumlah (Rp)</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Metode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $item)
                        <tr data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <td>{{ $item->jenis->nama ?? '-' }}</td>
                            <td class="text-success fw-semibold">Rp {{ number_format($item->jumlah) }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d M Y') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $item->status == 'Lunas' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{ $item->status == 'Lunas' ? 'Midtrans' : '-' }}
                            </td>
                            <td class="text-center">
                                @if($item->status != 'Lunas')
                                    <form action="{{ route('user.pembayaran.bayar', $item->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-primary">Bayar Sekarang</button>
                                    </form>
                                @else
                                    <span class="text-muted">✔️ Sudah Dibayar</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
@endsection