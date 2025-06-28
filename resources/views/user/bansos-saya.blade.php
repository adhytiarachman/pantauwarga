@extends('layouts.user')

@section('title', 'Bansos Saya')

@section('content')
    <!-- AOS Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

    <div class="container py-5 px-3 px-md-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-gradient-modern" data-aos="zoom-in">📦 Bantuan Sosial Anda</h1>
            <p class="text-muted fs-5" data-aos="fade-up" data-aos-delay="100">
                Informasi lengkap terkait bansos yang sedang berlangsung maupun riwayat sebelumnya
            </p>
        </div>

        {{-- Bansos Aktif --}}
        <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
            <h4 class="fw-semibold mb-3">🟢 Bansos Sedang Berlangsung</h4>
            @forelse($bansosAktif as $b)
                <div class="bansos-card glass-card-success mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold text-success-emphasis">{{ $b->aid_type }}</h5>
                        <span class="badge bg-success-subtle text-success">Aktif</span>
                    </div>
                    <p class="mb-1">Sumber: <strong>{{ $b->source }}</strong></p>
                    <p class="mb-1">Periode: {{ \Carbon\Carbon::parse($b->start_date)->format('d M Y') }} s/d
                        {{ \Carbon\Carbon::parse($b->end_date)->format('d M Y') }}</p>
                    <p class="mb-0">Pendapatan Terdata: <strong>Rp {{ number_format($b->income, 2, ',', '.') }}</strong></p>
                </div>
            @empty
                <div class="text-muted fst-italic">Tidak ada bansos aktif saat ini.</div>
            @endforelse
        </div>

        {{-- Riwayat Bansos --}}
        <div data-aos="fade-up" data-aos-delay="300">
            <h4 class="fw-semibold mb-3">📜 Riwayat Bantuan Sosial</h4>
            @forelse($bansosRiwayat as $b)
                <div class="bansos-card glass-card-secondary mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold">{{ $b->aid_type }}</h5>
                        <span class="badge bg-secondary-subtle text-secondary">Selesai</span>
                    </div>
                    <p class="mb-1">Sumber: <strong>{{ $b->source }}</strong></p>
                    <p class="mb-0">Berakhir pada: <strong>{{ \Carbon\Carbon::parse($b->end_date)->format('d M Y') }}</strong>
                    </p>
                </div>
            @empty
                <div class="text-muted fst-italic">Belum ada riwayat bansos.</div>
            @endforelse
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .text-gradient-modern {
            background: linear-gradient(90deg, #4f46e5, #0ea5e9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bansos-card {
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            transition: all 0.3s ease;
        }

        .bansos-card:hover {
            transform: translateY(-4px);
        }

        .glass-card-success {
            background: rgba(220, 252, 231, 0.8);
            border-left: 6px solid #22c55e;
            backdrop-filter: blur(10px);
        }

        .glass-card-secondary {
            background: rgba(243, 244, 246, 0.9);
            border-left: 6px solid #94a3b8;
            backdrop-filter: blur(8px);
        }

        .badge.bg-success-subtle {
            background-color: #bbf7d0;
        }

        .badge.bg-secondary-subtle {
            background-color: #e2e8f0;
        }

        .text-success-emphasis {
            color: #16a34a;
        }

        @media (max-width: 768px) {
            .bansos-card {
                padding: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 900,
            once: true,
            easing: 'ease-in-out',
        });
    </script>
@endpush