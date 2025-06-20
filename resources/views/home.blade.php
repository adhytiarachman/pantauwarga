@extends('layout')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm" data-aos="fade-down">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">RT 06 RW 15</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNav" aria-controls="navbarNav"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
        <li class="nav-item">
        <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 ms-2 fw-semibold shadow-sm">Sign In / Join</a>

        </li>
      </ul>
    </div>
  </div>
</nav>

{{-- Hero --}}
<section class="text-center py-5 hero-section text-white" data-aos="fade-up">
  <div class="container">
    <h1 class="display-4 fw-bold mb-3">Sistem Pendataan Penduduk</h1>
    <p class="lead">RT 06 RW 15 | Data Akurat, Warga Sejahtera</p>
    <a href="/register" class="btn btn-light btn-lg mt-4 shadow-sm">Daftar Sekarang</a>
  </div>
</section>

{{-- Features --}}
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold">Mengapa Sistem Ini Penting?</h2>
      <p class="text-muted">Kemudahan pengelolaan data warga dalam satu sistem digital</p>
    </div>
    <div class="row text-center">
      <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="p-4 border rounded shadow-sm h-100 transition-hover">
          <i class="bi bi-person-check display-6 text-primary mb-3"></i>
          <h5 class="fw-semibold">Data Warga Lengkap</h5>
          <p class="text-muted">Informasi setiap warga disimpan aman & terstruktur.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="p-4 border rounded shadow-sm h-100 transition-hover">
          <i class="bi bi-shield-lock display-6 text-primary mb-3"></i>
          <h5 class="fw-semibold">Keamanan Privasi</h5>
          <p class="text-muted">Sistem dienkripsi & hanya admin yang dapat mengakses.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="300">
        <div class="p-4 border rounded shadow-sm h-100 transition-hover">
          <i class="bi bi-speedometer2 display-6 text-primary mb-3"></i>
          <h5 class="fw-semibold">Akses Mudah</h5>
          <p class="text-muted">Login cepat, pencarian warga instan, dan real-time.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- CTA Section --}}
<section class="bg-primary text-white py-5" data-aos="fade-in">
  <div class="container text-center">
    <h3 class="fw-bold mb-3">Bersama Bangun RT yang Tertib dan Digital</h3>
    <p class="lead">Gunakan sistem ini untuk mengelola warga dengan transparan dan efisien.</p>
    <a href="/about" class="btn btn-light mt-3">Pelajari Lebih Lanjut</a>
  </div>
</section>
@endsection
