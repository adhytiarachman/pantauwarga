@extends('layout')

@section('content')
<section class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
  <div class="container">
    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body p-5">
            <h3 class="text-center fw-bold mb-4">Buat Akun Baru</h3>

            <form method="POST" action="{{ route('register') }}">
              @csrf

              {{-- Input No. KK --}}
              <div class="mb-3">
                <label for="no_kk" class="form-label fw-semibold">No. KK</label>
                <input type="text" class="form-control rounded-pill @error('no_kk') is-invalid @enderror"
                       id="no_kk" name="no_kk" value="{{ old('no_kk') }}" placeholder="No. KK" required>
                @error('no_kk') <small class="text-danger">{{ $message }}</small> @enderror
              </div>

              {{-- Dropdown Nama Anggota --}}
              <div class="mb-3">
                <label for="penduduk_id" class="form-label fw-semibold">Pilih Nama Anda</label>
                <select name="penduduk_id" id="penduduk_id" class="form-select rounded-pill" required>
                  <option value="">-- Pilih setelah isi No. KK --</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" class="form-control rounded-pill @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}" placeholder="Nama Anda" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
              </div>

              <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control rounded-pill @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
              </div>

              <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                  <input type="password" class="form-control rounded-start-pill @error('password') is-invalid @enderror"
                         id="password" name="password" placeholder="********" required>
                  <span class="input-group-text bg-white rounded-end-pill" onclick="togglePassword()" style="cursor:pointer;">
                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                  </span>
                </div>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
              </div>

              <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" class="form-control rounded-pill" id="password_confirmation"
                       name="password_confirmation" placeholder="********" required>
              </div>

              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold shadow-sm">
                  <i class="bi bi-person-plus me-2"></i> Daftar
                </button>
              </div>

              <div class="text-center mt-4">
                <small class="text-muted">Sudah punya akun?
                  <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Masuk</a>
                </small>
              </div>
            </form>
          </div>
        </div>

        <div class="text-center mt-4">
          <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill shadow-sm">
            <i class="bi bi-house-door-fill me-2 fs-5"></i> Kembali ke Beranda
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- SweetAlert2 Success --}}
@if(session('status'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Registrasi Berhasil',
    text: 'Silakan login menggunakan data yang sudah Anda daftarkan.',
    confirmButtonText: 'Login'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "{{ route('login') }}";
    }
  });
</script>
@endif

{{-- Script Section --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
function togglePassword() {
  const input = document.getElementById('password');
  const icon = document.getElementById('toggleIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.remove('bi-eye-slash');
    icon.classList.add('bi-eye');
  } else {
    input.type = 'password';
    icon.classList.remove('bi-eye');
    icon.classList.add('bi-eye-slash');
  }
}

document.getElementById('no_kk').addEventListener('input', function () {
  const kk = this.value;
  const dropdown = document.getElementById('penduduk_id');

  if (kk.length >= 3) {
    axios.get(`/api/penduduk/by-kk?no_kk=${kk}`)
      .then(res => {
        dropdown.innerHTML = '<option value="">-- Pilih Nama --</option>';
        console.log('Respons penduduk:', res.data);

        if (res.data.length === 0) {
          dropdown.innerHTML = '<option value="">-- Tidak ditemukan --</option>';
          return;
        }

        res.data.forEach(p => {
          const nama = p.nama ?? 'Tanpa Nama';
          dropdown.innerHTML += `<option value="${p.id}">${nama}</option>`;
        });
      })
      .catch(err => {
        console.error('Gagal ambil data:', err);
        dropdown.innerHTML = '<option value="">-- Gagal mengambil data --</option>';
      });
  } else {
    dropdown.innerHTML = '<option value="">-- Masukkan No. KK --</option>';
  }
});
</script>
@endsection
