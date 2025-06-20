@extends('layout')

@section('title', 'Login Pengguna')

@section('content')
<section class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h3 class="text-center fw-bold mb-4">Masuk ke Sistem</h3>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="nama@email.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control rounded-start-pill" id="password" name="password" placeholder="********" required>
                                    <span class="input-group-text bg-white rounded-end-pill" style="cursor:pointer;" onclick="togglePassword()">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold shadow-sm">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Daftar</a></small>
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
</script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ✅ Notifikasi Registrasi Berhasil -->
@if(session('status'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Registrasi Berhasil!',
            text: '{{ session('status') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<!-- ✅ Notifikasi Login Berhasil -->
@if(session('login_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil!',
            text: '{{ session('login_success') }}',
            confirmButtonText: 'Lanjutkan'
        });
    </script>
@endif

<!-- ❌ Notifikasi Akun Belum Disetujui -->
@if ($errors->has('email') && $errors->first('email') === 'Akun Anda belum disetujui oleh admin.')
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: '{{ $errors->first('email') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<!-- ❌ Notifikasi Username/Password Salah -->
@if ($errors->has('email') && $errors->first('email') !== 'Akun Anda belum disetujui oleh admin.')
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: '{{ $errors->first('email') }}',
            confirmButtonText: 'Coba Lagi'
        });
    </script>
@endif
@endsection
