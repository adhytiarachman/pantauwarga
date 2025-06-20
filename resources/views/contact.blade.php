@extends('layout')

@section('content')
{{-- Header Section --}}
<section class="py-5 bg-primary text-white text-center" data-aos="fade-down">
  <div class="container">
    <h1 class="display-5 fw-bold">Kontak Kami</h1>
    <p class="lead">Hubungi kami untuk informasi lebih lanjut mengenai sistem pendataan RT 06 RW 15</p>
  </div>
</section>

{{-- Contact Content --}}
<section class="py-5 bg-light">
  <div class="container" data-aos="fade-up">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h4 class="fw-bold mb-3">Informasi Kontak</h4>
        <ul class="list-unstyled fs-5">
          <li class="mb-2">
            <i class="bi bi-envelope-fill text-primary me-2"></i>
            Email: <a href="mailto:rt06rw15@example.com">rt06rw15@gmail.com</a>
          </li>
          <li class="mb-2">
            <i class="bi bi-whatsapp text-success me-2"></i>
            WhatsApp: <a href="https://wa.me/6281234567890" target="_blank">0812-3456-7890</a>
          </li>
          <li class="mb-2">
            <i class="bi bi-geo-alt-fill text-danger me-2"></i>
            Alamat: RT 06 RW 15, Kelurahan Margasari, Kota Bandung, Blok A No.11
          </li>
        </ul>
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
