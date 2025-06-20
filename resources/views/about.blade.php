@extends('layout')

@section('content')
{{-- Hero Banner --}}
<section class="py-5 bg-primary text-white text-center" data-aos="fade-down">
  <div class="container">
    <h1 class="display-5 fw-bold">Tentang Sistem Pendataan</h1>
    <p class="lead mt-2">Solusi digital untuk RT 06 RW 15 yang lebih tertib dan terorganisir.</p>
  </div>
</section>

{{-- Content --}}
<section class="py-5 bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right">
        <img src="/assets/images/background.png" alt="Ilustrasi Sistem" class="img-fluid rounded shadow-sm">
      </div>
      <div class="col-md-6" data-aos="fade-left">
        <h2 class="fw-bold mb-3">Mengapa Sistem Ini Dibuat?</h2>
        <p class="text-muted mb-3">
          Sistem ini dikembangkan untuk membantu pengurus RT 06 RW 15 dalam melakukan pencatatan data penduduk secara <strong>digital, cepat, dan aman</strong>. Semua informasi warga tersimpan terstruktur dan mudah diakses oleh pengurus resmi.
        </p>
        <p class="text-muted">
          Kami percaya dengan transparansi dan teknologi, kita bisa membangun lingkungan yang lebih baik. Sistem ini memungkinkan pengurus melihat data warga, status keluarga, mutasi penduduk, dan banyak lagi.
        </p>
      </div>
    </div>
  </div>
</section>

{{-- Key Points --}}
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h3 class="fw-bold">Manfaat Utama Sistem Ini</h3>
    </div>
    <div class="row text-center">
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="p-4 border rounded shadow-sm h-100 transition-hover bg-white">
          <i class="bi bi-folder2-open display-6 text-primary mb-3"></i>
          <h5 class="fw-semibold">Pendataan Rapi</h5>
          <p class="text-muted">Semua data warga tersimpan digital, tidak lagi manual di kertas.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="p-4 border rounded shadow-sm h-100 transition-hover bg-white">
          <i class="bi bi-shield-check display-6 text-primary mb-3"></i>
          <h5 class="fw-semibold">Privasi Terjamin</h5>
          <p class="text-muted">Akses terbatas hanya untuk admin RT terverifikasi.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
        <div class="p-4 border rounded shadow-sm h-100 transition-hover bg-white">
          <i class="bi bi-bar-chart-line display-6 text-primary mb-3"></i>
          <h5 class="fw-semibold">Laporan Cepat</h5>
          <p class="text-muted">Laporan warga, keluarga, hingga grafik populasi dibuat otomatis.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Back to Home Button --}}
<div class="text-center my-5" data-aos="fade-up">
  <a href="/" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm d-inline-flex align-items-center back-home-btn">
    <i class="bi bi-house-door-fill me-2 fs-5"></i> Kembali ke Beranda
  </a>
</div>


@endsection
