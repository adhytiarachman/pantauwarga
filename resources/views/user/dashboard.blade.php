@extends('layouts.user')

@section('title', 'Dashboard Pengguna')

@section('content')
  <div class="container py-5">

    {{-- Header --}}
    <h1 class="fw-bold text-gradient text-center mb-5" data-aos="fade-down">
    👋 Selamat Datang, {{ $penduduk->nama_kepala_keluarga ?? 'Pengguna' }}
    </h1>

    {{-- Grafik --}}
    <div class="row g-4 justify-content-center" data-aos="fade-up">
    {{-- Jumlah Data --}}
    <div class="col-md-6 col-lg-4">
      <div class="glass-card p-4 text-center chart-container">
      <h5 class="mb-3">📊 Jumlah Data</h5>
      <canvas id="jumlahDataChart" height="200"></canvas>
      </div>
    </div>

    {{-- Usia --}}
    <div class="col-md-6 col-lg-4">
      <div class="glass-card p-4 text-center chart-container">
      <h5 class="mb-3">📈 Distribusi Usia</h5>
      <canvas id="usiaChartMini" height="200"></canvas>
      </div>
    </div>

    {{-- Gender --}}
    <div class="col-md-6 col-lg-4">
      <div class="glass-card p-4 text-center chart-container">
      <h5 class="mb-3">👫 Jenis Kelamin</h5>
      <canvas id="genderChartMini" height="200"></canvas>
      </div>
    </div>
    </div>
  </div>
  <div class="container py-5">
    <h2 class="fw-bold text-black text-center mb-5" data-aos="fade-up">
    Grafik Penduduk Rt 06 Rw 15
    </h2>

    <div class="row g-4">
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card border-0 glass-card shadow-sm p-3 text-center h-100" data-aos="fade-up">
      <i class="bi bi-people fs-1 text-primary"></i>
      <h6 class="mt-2">Total Penduduk</h6>
      <h3 class="fw-bold text-dark">{{ $totalPenduduk }}</h3>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card border-0 glass-card shadow-sm p-3 text-center h-100" data-aos="fade-up" data-aos-delay="100">
      <i class="bi bi-house-door fs-1 text-success"></i>
      <h6 class="mt-2">Kepala Keluarga</h6>
      <h3 class="fw-bold text-dark">{{ $totalKK }}</h3>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card border-0 glass-card shadow-sm p-3 text-center h-100" data-aos="fade-up" data-aos-delay="200">
      <i class="bi bi-check-circle fs-1 text-info"></i>
      <h6 class="mt-2">Keluarga Menetap</h6>
      <h3 class="fw-bold text-dark">{{ $menetap }}</h3>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card border-0 glass-card shadow-sm p-3 text-center h-100" data-aos="fade-up" data-aos-delay="300">
      <i class="bi bi-clock-history fs-1 text-warning"></i>
      <h6 class="mt-2">Tinggal Sementara</h6>
      <h3 class="fw-bold text-dark">{{ $sementara }}</h3>
      </div>
    </div>
    </div>

    {{-- Grafik Penduduk RT 06 Rw 15 --}}
    @include('user.partials.dashboard-statistics')

    {{-- Scripts Grafik Penduduk RT 06 Rw 15 --}}
    @include('user.partials.dashboard-scripts')


  @endsection

  @push('styles')
    <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #eef2f7, #ffffff);
      transition: background 0.3s ease, color 0.3s ease;
    }

    .text-gradient {
      background: linear-gradient(90deg, #2563eb, #38bdf8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 1.25rem;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(15px);
      transition: all 0.3s ease;
    }

    .glass-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    }

    .chart-container {
      position: relative;
      width: 100%;
      height: 300px;
      max-height: 320px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .chart-container {
      height: 250px;
      }
    }
    </style>
  @endpush

  @push('scripts')
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init();</script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const usiaData = @json($usiaCounts);
    const genderData = @json($genderCounts);



    // Jumlah Data Chart
    new Chart(document.getElementById('jumlahDataChart'), {
      type: 'bar',
      data: {
      labels: ['Anggota Keluarga', 'Informasi RT'],
      datasets: [{
        label: 'Jumlah',
        data: [
      {{ \App\Models\Penduduk::where('no_kk', $penduduk->no_kk)->count() }},
        {{ \App\Models\Informasi::count() }}
        ],
        backgroundColor: ['#3b82f6', '#10b981'],
        borderRadius: 12,
        barThickness: 30
      }]
      },
      options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
        display: true,
        position: 'top'
        }
      },
      scales: {
        y: { beginAtZero: true }
      }
      }
    });

    // Usia Chart
    new Chart(document.getElementById('usiaChartMini'), {
      type: 'bar',
      data: {
      labels: Object.keys(usiaData),
      datasets: [{
        label: 'Jumlah Penduduk',
        data: Object.values(usiaData),
        backgroundColor: '#6366f1',
        borderRadius: 10,
        barThickness: 25
      }]
      },
      options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
        display: true,
        position: 'top'
        }
      },
      scales: {
        y: { beginAtZero: true }
      }
      }
    });

    // Gender Doughnut Chart
    new Chart(document.getElementById('genderChartMini'), {
      type: 'doughnut',
      data: {
      labels: Object.keys(genderData),
      datasets: [{
        label: 'Jumlah',
        data: Object.values(genderData),
        backgroundColor: ['#f59e0b', '#3b82f6'],
        borderWidth: 2,
        hoverOffset: 8
      }]
      },
      options: {
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
        bottom: 30
        }
      },
      plugins: {
        legend: {
        position: 'bottom',
        labels: {
          font: { size: 14 },
          boxWidth: 20,
          padding: 12
        }
        }
      }
      }
    });
    </script>
  @endpush