@extends('layouts.user')

@section('title', 'Anggota Keluarga')

@section('content')
<!-- AOS Animate On Scroll -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

<div class="container py-5">
    {{-- Header --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold display-5 text-primary animate-header" data-aos="fade-down" data-aos-delay="100">
            👨‍👩‍👧‍👦 Data Anggota Keluarga
        </h2>
        <p class="text-muted lead" data-aos="fade-down" data-aos-delay="200">
            Informasi lengkap keluarga dalam satu tampilan
        </p>
    </div>

    {{-- Tabel Anggota Keluarga --}}
    <div class="table-responsive" data-aos="fade-up" data-aos-delay="300">
        <table class="table table-hover table-striped align-middle shadow table-modern">
            <thead class="table-header-modern">
                <tr>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Jenis Kelamin</th>
                    <th>Agama</th>
                    <th>Status Perkawinan</th>
                    <th>Tempat / Tgl Lahir</th>
                    <th>Usia</th>
                    <th>Pekerjaan</th>
                    <th>Pendapatan / Bulan</th>
                    <th>Total Pendapatan KK</th>
                    <th>Rata-Rata Pendapatan KK</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keluarga as $anggota)
                    <tr>
                        <td>{{ $anggota->nama_kepala_keluarga }}</td>
                        <td>{{ $anggota->nik }}</td>
                        <td>{{ $anggota->jenis_kelamin }}</td>
                        <td>{{ $anggota->agama }}</td>
                        <td>{{ $anggota->status_perkawinan }}</td>
                        <td>{{ $anggota->tempat_lahir }} / {{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d M Y') }}</td>
                        <td>{{ $anggota->usia }} Tahun</td>
                        <td>{{ $anggota->pekerjaan }}</td>
                        <td><span class="badge bg-primary bg-opacity-25 text-dark px-3 py-2">Rp {{ number_format($anggota->income_per_month ?? 0, 2, ',', '.') }}</span></td>
                        <td>
                            @php
                                $pendapatanPerKK = $keluarga->where('no_kk', $anggota->no_kk)->sum('income_per_month');
                            @endphp
                            <strong>Rp {{ number_format($pendapatanPerKK, 2, ',', '.') }}</strong>
                        </td>
                        <td>
                            @php
                                $avgPendapatanPerKK = $keluarga->where('no_kk', $anggota->no_kk)->avg('income_per_month');
                            @endphp
                            <strong>Rp {{ number_format($avgPendapatanPerKK, 2, ',', '.') }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Header animasi */
    .animate-header {
        animation: slideFadeIn 1.2s ease forwards;
    }

    @keyframes slideFadeIn {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tabel modern */
    .table-modern {
        font-size: 0.95rem;
        border-radius: 1rem;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
    }

    .table-modern:hover {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .table-header-modern {
        background: linear-gradient(135deg, #4e54c8, #8f94fb);
        color: white;
    }

    .table th, .table td {
        padding: 12px 16px;
        vertical-align: middle;
    }

    .badge {
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 0.75rem;
    }

    @media (max-width: 768px) {
        .table th, .table td {
            font-size: 0.85rem;
            padding: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800,
        offset: 50
    });
</script>
@endpush
