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

    const ctx2 = document.getElementById('barChart').getContext('2d');
    new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: ['Penduduk', 'KK', 'Menetap', 'Sementara'],
        datasets: [{
          label: 'Jumlah',
          data: [{{ $totalPenduduk }}, {{ $totalKK }}, {{ $menetap }}, {{ $sementara }}],
          backgroundColor: ['#0d6efd', '#198754', '#0dcaf0', '#ffc107'],
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
  });
</script>
@endpush
