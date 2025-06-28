@extends('layout')

@section('content')
  <!-- Header Section -->
  <section class="py-5 text-white text-center bg-gradient-primary"
    style="background: linear-gradient(135deg, #4e54c8, #8f94fb);" data-aos="zoom-in">
    <div class="container">
    <h1 class="display-4 fw-bold text-glow" data-aos="fade-down" data-aos-delay="200">📞 Kontak Kami</h1>
    <p class="lead" data-aos="fade-up" data-aos-delay="400">Hubungi kami untuk informasi lebih lanjut mengenai sistem
      pendataan RT 06 RW 15</p>
    </div>
  </section>

  <!-- Contact Info Section -->
  <section class="py-5 bg-light">
    <div class="container" data-aos="fade-up">
    <div class="row justify-content-center">
      <div class="col-lg-8">
      <div class="bg-white p-4 p-md-5 rounded shadow-sm border" data-aos="fade-up" data-aos-delay="300">
        <h4 class="fw-bold mb-4 text-primary">Informasi Kontak</h4>
        <ul class="list-unstyled fs-5">
        <li class="mb-3 d-flex align-items-center">
          <i class="bi bi-envelope-fill text-primary fs-4 me-3"></i>
          <div>
          <strong>Email:</strong> <br>
          <a href="mailto:rt06rw15@gmail.com">rt06rw15@gmail.com</a>
          </div>
        </li>
        <li class="mb-3 d-flex align-items-center">
          <i class="bi bi-whatsapp text-success fs-4 me-3"></i>
          <div>
          <strong>WhatsApp:</strong> <br>
          <a href="https://wa.me/6281234567890" target="_blank">0812-3456-7890</a>
          </div>
        </li>
        <li class="mb-3 d-flex align-items-center">
          <i class="bi bi-geo-alt-fill text-danger fs-4 me-3"></i>
          <div>
          <strong>Alamat:</strong> <br>
          RT 06 RW 15, Kelurahan Margasari, Kota Bandung, Blok A No.11
          </div>
        </li>
        </ul>
      </div>
      </div>
    </div>
    </div>
  </section>

  <!-- Google Maps Section -->
  <section class="py-5 bg-white">
    <div class="container" data-aos="fade-up">
    <h4 class="fw-bold text-center text-primary mb-4">📍 Lokasi Kami</h4>
    <div class="ratio ratio-16x9 shadow-lg rounded overflow-hidden">
      <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d816.3068806847693!2d107.6626911109066!3d-6.957719991469656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e96e1c45b507%3A0x91bdb63455cf83e8!2sPKBM%20BHINNEKA%20BANGSA!5e0!3m2!1sid!2sid!4v1750868254341!5m2!1sid!2sid"
      allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    </div>
  </section>

  <!-- Back Button -->
  <div class="text-center my-5" data-aos="fade-up">
    <a href="/" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm d-inline-flex align-items-center">
    <i class="bi bi-house-door-fill me-2 fs-5"></i> Kembali ke Beranda
    </a>
  </div>

  <!-- AOS & Custom Style -->
  @push('styles')
    <style>
    .text-glow {
    text-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
    animation: glowText 3s ease-in-out infinite alternate;
    }

    @keyframes glowText {
    from {
      text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
    }

    to {
      text-shadow: 0 0 20px rgba(255, 255, 255, 1);
    }
    }
    </style>
  @endpush
@endsection