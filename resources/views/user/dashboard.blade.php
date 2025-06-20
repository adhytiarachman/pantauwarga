@extends('layouts.user')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="container-fluid py-4">

    

    {{-- Header --}}
    <h1 class="fw-bold display-5 text-gradient mb-5" data-aos="fade-down">
        👋 Selamat Datang, {{ $penduduk->nama ?? 'Pengguna' }}
    </h1>

    {{-- Stat Cards --}}
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <div class="glass-card p-4">
                <h6 class="text-uppercase text-muted">👥 Total Anggota Keluarga</h6>
                <h2 class="fw-bold text-primary" id="anggotaKeluarga">
                    {{ \App\Models\Penduduk::where('no_kk', $penduduk->no_kk)->count() }}
                </h2>
            </div>
        </div>
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="glass-card p-4">
                <h6 class="text-uppercase text-muted">📢 Jumlah Informasi</h6>
                <h2 class="fw-bold text-success" id="jumlahInformasi">
                    {{ $informasi->count() }}
                </h2>
            </div>
        </div>
    </div>

    {{-- Chart Visual --}}
    <div class="mb-5" data-aos="fade-up">
        <canvas id="dashboardChart" height="100"></canvas>
    </div>

    {{-- Data Diri --}}
    <div id="data-diri" class="mb-5" data-aos="fade-right">
        <h3 class="fw-semibold mb-4">🧾 Data Diri Anda</h3>

        @if ($penduduk)
            @php
                $kepala = \App\Models\Penduduk::where('no_kk', $penduduk->no_kk)->where('is_kepala_keluarga', true)->first();
            @endphp

            <div class="glass-card p-4 row g-3">
                <div class="col-md-6"><strong>👨‍👩‍👧‍👦 Kepala Keluarga:</strong> {{ $kepalaKeluarga->nama ?? '-' }}</div>
                <div class="col-md-6"><strong>🧑 Nama Anda:</strong> {{ $penduduk->nama_kepala_keluarga ?? '-' }}</div>
                <div class="col-md-6"><strong>🆔 NIK:</strong> {{ $penduduk->nik }}</div>
                <div class="col-md-6"><strong>📄 No. KK:</strong> {{ $penduduk->no_kk }}</div>
                <div class="col-md-6"><strong>🎂 TTL:</strong> {{ $penduduk->tempat_lahir ?? '-' }} / {{ $penduduk->tanggal_lahir ?? '-' }}</div>
                <div class="col-md-6"><strong>📍 Alamat:</strong> {{ $penduduk->alamat ?? '-' }}</div>
                <div class="col-md-6"><strong>👥 Status:</strong> {{ $penduduk->is_kepala_keluarga ? 'Kepala Keluarga' : 'Anggota' }}</div>
            </div>
        @else
            <div class="alert alert-warning text-center">Data penduduk belum tersedia.</div>
        @endif
    </div>

    {{-- Informasi Terbaru --}}
    <div id="informasi" data-aos="fade-left">
        <h3 class="fw-semibold mb-4">📢 Informasi Terbaru</h3>

        @if ($informasi->isEmpty())
            <div class="alert alert-info text-center">Belum ada informasi terbaru saat ini.</div>
        @else
            <div class="row g-4">
                @foreach ($informasi as $info)
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="glass-card h-100 p-0 overflow-hidden">
                            <div class="p-3 bg-gradient-info text-white rounded-top-4">
                                <h5 class="mb-1">{{ $info->judul }}</h5>
                                <small>{{ \Carbon\Carbon::parse($info->tanggal)->translatedFormat('d F Y') }}</small>
                            </div>
                            <div class="p-3">
                                <p class="text-muted mb-0">
                                    {{ \Illuminate\Support\Str::limit($info->konten, 120, '...') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Style --}}
<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f0f2f5, #ffffff);
        transition: background 0.3s ease, color 0.3s ease;
    }

    body.dark-mode {
        background: #1a1a2e;
        color: #ffffff;
    }

    .text-gradient {
        background: linear-gradient(90deg, #0061ff, #60efff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 1.25rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .dark-mode .glass-card {
        background: rgba(40, 40, 60, 0.8);
        color: #eee;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #1d2b64 0%, #f8cdda 100%);
    }
</style>

{{-- Script --}}
@push('scripts')
    {{-- AOS --}}
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init();</script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const totalAnggota = parseInt(document.getElementById('anggotaKeluarga').textContent);
        const totalInfo = parseInt(document.getElementById('jumlahInformasi').textContent);

        const ctx = document.getElementById('dashboardChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Anggota Keluarga', 'Informasi RT'],
                datasets: [{
                    label: 'Jumlah Data',
                    data: [totalAnggota, totalInfo],
                    backgroundColor: ['#0061ff', '#28a745'],
                    borderRadius: 10,
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

    {{-- Dark Mode --}}
    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
@endpush
@endsection
