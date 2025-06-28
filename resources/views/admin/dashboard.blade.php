@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
  <div class="container-fluid px-0">
    <h2 class="mb-4 fw-bold text-dark">Selamat Datang, Admin!</h2>

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

    {{-- Grafik Distribusi Keluarga dan Agama --}}
    <div class="row mt-5 g-4">
    <div class="col-12 col-lg-6" data-aos="fade-right">
      <div class="card border-0 glass-card p-4 shadow h-100">
      <h5 class="mb-3">Distribusi Keluarga</h5>
      <div class="chart-container">
        <canvas id="statusChart"></canvas>
      </div>
      </div>
    </div>

    <div class="col-12 col-lg-6" data-aos="fade-left">
      <div class="card border-0 glass-card p-4 shadow h-100">
      <h5 class="mb-3">Agama</h5>
      <div class="chart-container">
        <canvas id="agama"></canvas>
      </div>
      </div>
    </div>
    </div>

    {{-- Grafik Jenis Kelamin --}}
    <div class="row mt-5 g-4">
    <div class="col-12 col-md-6" data-aos="fade-up-right">
      <div class="card glass-card p-4 shadow h-100">
      <h5 class="mb-3">Jenis Kelamin</h5>
      <canvas id="genderChart"></canvas>
      </div>
    </div>

    {{-- Grafik Usia --}}
    <div class="col-12 col-md-6" data-aos="fade-up-left">
      <div class="card glass-card p-4 shadow h-100">
      <h5 class="mb-3">Kelompok Usia</h5>
      <canvas id="usiaChart"></canvas>
      </div>
    </div>
    </div>


    {{-- Grafik Pendapatan Keluarga & Individu --}}
    <div class="row mt-5 g-4">
    <div class="col-12 col-lg-6" data-aos="fade-right">
      <div class="card border-0 glass-card p-4 shadow h-100">
      <h5 class="mb-3">Rata-rata Pendapatan Per Keluarga</h5>
      <canvas id="chartKeluarga"></canvas>
      </div>
    </div>

    <div class="col-12 col-lg-6" data-aos="fade-left">
      <div class="card border-0 glass-card p-4 shadow h-100">
      <h5 class="mb-3">Rata-rata Pendapatan Per Individu</h5>
      <canvas id="chartIndividu"></canvas>
      </div>
    </div>
    </div>

    {{-- Grafik Status Perkawinan --}}
    <div class="row mt-5 g-4">
    <div class="col-12" data-aos="fade-up">
      <div class="card border-0 glass-card p-4 shadow h-100">
      <h5 class="mb-3">Status Perkawinan</h5>
      <div class="chart-container">
        <canvas id="status_perkawinan"></canvas>
      </div>
      </div>
    </div>
    </div>

    {{-- Grafik Pekerjaan --}}
    <div class="row mt-4 g-4">
    <div class="col-12" data-aos="fade-up">
      <div class="card border-0 glass-card p-4 shadow h-100">
      <h5 class="mb-3">📊 Statistik Pekerjaan</h5>
      <div class="chart-container">
        <canvas id="pekerjaanChart"></canvas>
      </div>
      </div>
    </div>
    </div>

    {{-- Grafik Rekap Data --}}
    <div class="row mt-4 g-4">
    <div class="col-12" data-aos="fade-up">
      <div class="card border-0 glass-card p-4 shadow h-100">
      <h5 class="mb-3">Rekap Data</h5>
      <div class="chart-container">
        <canvas id="barChart"></canvas>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .glass-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 1rem;
    transition: all 0.3s ease;
    }

    .chart-container {
    position: relative;
    width: 100%;
    height: auto;
    min-height: 250px;
    }

    @media (max-width: 576px) {
    canvas {
      max-width: 100% !important;
      height: auto !important;
    }

    .fs-1 {
      font-size: 2.5rem !important;
    }
    }
  </style>
@endpush

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    // Grafik Keluarga
    const ctx1 = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx1, {
      type: 'doughnut',
      data: {
      labels: ['Menetap', 'Sementara'],
      datasets: [{
        data: [{{ $menetap }}, {{ $sementara }}],
        backgroundColor: ['#3b82f6', '#facc15'],
        hoverOffset: 30
      }]
      },
      options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom' }
      }
      }
    });

    // Grafik Status Perkawinan
    const ctx2 = document.getElementById('status_perkawinan').getContext('2d');
    new Chart(ctx2, {
      type: 'bar',
      data: {
      labels: ['Belum Menikah', 'Menikah', 'Janda/Duda'],
      datasets: [{
        label: 'Jumlah',
        data: [{{ $BelumMenikah }}, {{ $Menikah }}, {{ $JandaDuda }}],
        backgroundColor: ['#0d6efd', '#198754', '#0dcaf0'],
        borderRadius: 8
      }]
      },
      options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
        beginAtZero: true
        }
      },
      plugins: {
        legend: { display: false }
      }
      }
    });

    // Grafik Agama
    const ctx3 = document.getElementById('agama').getContext('2d');
    new Chart(ctx3, {
      type: 'doughnut',
      data: {
      labels: ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'],
      datasets: [{
        data: [{{ $Islam }}, {{ $Kristen }}, {{ $Katolik }}, {{ $Hindu }}, {{ $Buddha }}, {{ $Konghucu }}],
        backgroundColor: ['#3b82f6', '#facc15', '#0dcaf0', '#f59e0b', '#6610f2', '#198754'],
        hoverOffset: 30
      }]
      },
      options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom' }
      }
      }
    });

    // Grafik Rekap Data
    const ctx4 = document.getElementById('barChart').getContext('2d');
    new Chart(ctx4, {
      type: 'bar',
      data: {
      labels: [
        'Penduduk', 'KK', 'Menetap', 'Sementara',
        'Belum Menikah', 'Menikah', 'Janda/Duda',
        'Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu',
        'KK 0-3jt', 'KK 3-6jt', 'KK 6-20jt', 'KK >20jt',
        'Ind 0-1jt', 'Ind 1-2jt', 'Ind 2-5jt', 'Ind >5jt',
        'Laki-laki', 'Perempuan',
        'Bayi (0-2)', 'Anak (3-12)', 'Remaja (13-19)', 'Dewasa (20-59)', 'Lansia (60+)'
      ],
      datasets: [{
        label: 'Jumlah',
        data: [
      {{ $totalPenduduk }},
      {{ $totalKK }},
      {{ $menetap }},
      {{ $sementara }},
      {{ $BelumMenikah }},
      {{ $Menikah }},
      {{ $JandaDuda }},
      {{ $Islam }},
      {{ $Kristen }},
      {{ $Katolik }},
      {{ $Hindu }},
      {{ $Buddha }},
      {{ $Konghucu }},
      {{ $perKeluarga['0 - 3 juta'] }},
      {{ $perKeluarga['3 - 6 juta'] }},
      {{ $perKeluarga['6 - 20 juta'] }},
      {{ $perKeluarga['> 20 juta'] }},
      {{ $perIndividu['0 - 1 juta'] }},
      {{ $perIndividu['1 - 2 juta'] }},
      {{ $perIndividu['2 - 5 juta'] }},
      {{ $perIndividu['> 5 juta'] }},
      {{ $jumlahLaki }},
      {{ $jumlahPerempuan }},
      {{ $usiaData['Bayi (0-2)'] }},
      {{ $usiaData['Anak (3-12)'] }},
      {{ $usiaData['Remaja (13-19)'] }},
      {{ $usiaData['Dewasa (20-59)'] }},
        {{ $usiaData['Lansia (60+)'] }}
        ],
        backgroundColor: [
        '#0d6efd', '#198754', '#0dcaf0', '#ffc107',
        '#6f42c1', '#20c997', '#fd7e14',
        '#3b82f6', '#facc15', '#0dcaf0', '#f59e0b', '#6610f2', '#198754',
        '#4ade80', '#22d3ee', '#fbbf24', '#ef4444',
        '#16a34a', '#0284c7', '#eab308', '#b91c1c',
        '#4b5563', '#e11d48',
        '#fcd34d', '#a78bfa', '#60a5fa', '#34d399', '#9ca3af'
        ],
        borderRadius: 8
      }]
      },
      options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
        beginAtZero: true,
        ticks: {
          stepSize: 1
        }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: {
        callbacks: {
          label: context => `${context.parsed.y} orang`
        }
        }
      },
      animation: {
        duration: 1000,
        easing: 'easeOutCubic'
      }
      }
    });



    // Grafik Pekerjaan
    const pekerjaanData = @json($pekerjaanData);
    const ctx5 = document.getElementById('pekerjaanChart').getContext('2d');
    new Chart(ctx5, {
      type: 'bar',
      data: {
      labels: Object.keys(pekerjaanData),
      datasets: [{
        label: 'Jumlah',
        data: Object.values(pekerjaanData),
        backgroundColor: '#6610f2',
        borderRadius: 10
      }]
      },
      options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
        beginAtZero: true
        }
      },
      plugins: {
        legend: { display: false }
      }
      }
    });


    // Grafik Pendapatan per Keluarga
    const chartKeluarga = new Chart(document.getElementById('chartKeluarga'), {
      type: 'bar',
      data: {
      labels: {!! json_encode(array_keys($perKeluarga)) !!},
      datasets: [{
        label: 'Jumlah Keluarga',
        data: {!! json_encode(array_values($perKeluarga)) !!},
        backgroundColor: ['#3b82f6', '#60a5fa', '#93c5fd', '#1e40af'],
        borderRadius: 10
      }]
      },
      options: {
      animation: {
        duration: 1000,
        easing: 'easeOutBounce'
      },
      responsive: true,
      plugins: { legend: { display: false } }
      }
    });

    // Grafik Pendapatan per Individu
    const chartIndividu = new Chart(document.getElementById('chartIndividu'), {
      type: 'bar',
      data: {
      labels: {!! json_encode(array_keys($perIndividu)) !!},
      datasets: [{
        label: 'Jumlah Individu',
        data: {!! json_encode(array_values($perIndividu)) !!},
        backgroundColor: ['#10b981', '#34d399', '#6ee7b7', '#065f46'],
        borderRadius: 10
      }]
      },
      options: {
      animation: {
        duration: 1200,
        easing: 'easeOutBack'
      },
      responsive: true,
      plugins: { legend: { display: false } }
      }
    });

    // Grafik Jenis Kelamin
    new Chart(document.getElementById('genderChart'), {
      type: 'doughnut',
      data: {
      labels: ['Laki-laki', 'Perempuan'],
      datasets: [{
        data: [{{ $jumlahLaki }}, {{ $jumlahPerempuan }}],
        backgroundColor: ['#0d6efd', '#e83e8c'],
        hoverOffset: 20
      }]
      },
      options: {
      plugins: {
        legend: {
        position: 'bottom',
        labels: {
          font: {
          size: 14
          }
        }
        }
      }
      }
    });

    // Grafik Usia
    const usiaData = @json($usiaData);
    new Chart(document.getElementById('usiaChart'), {
      type: 'bar',
      data: {
      labels: Object.keys(usiaData),
      datasets: [{
        label: 'Jumlah Penduduk',
        data: Object.values(usiaData),
        backgroundColor: ['#60a5fa', '#4ade80', '#facc15', '#f97316', '#d946ef'],
        borderRadius: 8
      }]
      },
      options: {
      indexAxis: 'y',
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
        callbacks: {
          label: function (context) {
          return context.parsed.x + ' orang';
          }
        }
        }
      },
      animation: {
        duration: 1200,
        easing: 'easeOutBounce'
      }
      }
    });


    });
  </script>
@endpush