<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Admin Dashboard')</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #f0f2f5, #e4ebf5);
      color: #1f2937;
    }

    .sidebar {
      width: 260px;
      background: rgba(31, 41, 55, 0.95);
      backdrop-filter: blur(10px);
      color: white;
      position: fixed;
      height: 100vh;
      padding: 2rem 1rem;
      display: flex;
      flex-direction: column;
      box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
      z-index: 1050;
      transition: transform 0.3s ease;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.75rem 1.25rem;
      margin-bottom: 0.5rem;
      border-radius: 10px;
      color: #cbd5e1;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .sidebar a:hover,
    .sidebar .nav-link.active {
      background: #3b82f6;
      color: white;
      font-weight: 600;
      transform: translateX(4px);
    }

    .sidebar a i {
      font-size: 1.25rem;
    }

    main.content {
      margin-left: 260px;
      padding: 2rem;
      background: linear-gradient(145deg, #f9fafb, #e5e7eb);
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(14px);
      border-radius: 1rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s;
      padding: 1.5rem;
    }

    .glass-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
    }

    .btn-logout {
      margin-top: auto;
      background-color: #ef4444;
      border: none;
      border-radius: 8px;
      padding: 0.6rem 1rem;
      color: white;
      font-weight: 600;
      transition: background-color 0.3s;
    }

    .btn-logout:hover {
      background-color: #dc2626;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.active {
        transform: translateX(0);
      }

      main.content {
        margin-left: 0;
        padding: 1rem;
      }

      .sidebar-toggle {
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1100;
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
    }
  </style>

  @stack('styles')
</head>
<body>

  <!-- Toggle Button (Mobile) -->
  <button class="sidebar-toggle d-md-none">
    <i class="bi bi-list fs-4"></i>
  </button>

  <!-- Sidebar -->
  <nav class="sidebar d-flex flex-column" id="sidebarMenu">
    <div class="mb-4 fs-4 fw-bold text-white text-center">
      <i class="bi bi-speedometer2 me-2"></i> Admin Panel
    </div>

    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-graph-up-arrow"></i> Dashboard
    </a>
    <a href="{{ route('penduduk.index') }}" class="nav-link {{ request()->routeIs('penduduk.*') ? 'active' : '' }}">
      <i class="bi bi-people-fill"></i> Data Penduduk
    </a>
    <a href="{{ route('informasi.index') }}" class="nav-link {{ request()->routeIs('informasi.*') ? 'active' : '' }}">
      <i class="bi bi-bullhorn"></i> Informasi
    </a>

    <a href="{{ route('admin.approvals') }}" class="nav-link {{ request()->routeIs('admin.approvals') ? 'active' : '' }}">
  <i class="bi bi-person-check"></i> Persetujuan Akun
</a>


    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-logout w-100 mt-4">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
      </button>
    </form>
  </nav>

  <!-- Main Content -->
  <main class="content">
    <div class="glass-card" data-aos="fade-up">
      @yield('content')
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script>
    AOS.init({ duration: 800 });

    // Toggle sidebar on mobile
    document.querySelector('.sidebar-toggle')?.addEventListener('click', function () {
      document.getElementById('sidebarMenu').classList.toggle('active');
    });
  </script>

  @stack('scripts')

  {{-- Flash Message Alert --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
</body>
</html>
