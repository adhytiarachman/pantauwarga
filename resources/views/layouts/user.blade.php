<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Pengguna') - RT SmartApp</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Bootstrap & AOS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg: #f8fafc;
            --text: #1e293b;
            --card: #ffffff;
            --nav-bg: rgba(255, 255, 255, 0.85);
        }

        [data-theme="dark"] {
            --bg: #0f172a;
            --text: #f1f5f9;
            --card: #1e293b;
            --nav-bg: rgba(30, 41, 59, 0.95);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            transition: background-color 0.3s ease, color 0.3s ease;
            min-height: 100vh;
        }

        .navbar-custom {
            backdrop-filter: blur(12px);
            background-color: var(--nav-bg);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--text);
        }

        .nav-link {
            color: var(--text) !important;
            font-weight: 500;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #3b82f6 !important;
        }

        .dark-toggle {
            cursor: pointer;
            color: var(--text);
        }

        .card {
            background-color: var(--card);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card-header {
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            color: white;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        h1, h2, h3, h4 {
            font-weight: 700;
        }

        main {
            padding-top: 6rem;
            padding-bottom: 4rem;
        }

        @media (max-width: 768px) {
            main {
                padding: 1rem;
            }
        }
    </style>
</head>
<body data-theme="light">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('RT SmartApp') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('user/dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#data-diri">Data Diri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#informasi">Informasi</a>
                    </li>

                    <li class="nav-item">
                        <span class="nav-link dark-toggle" id="themeToggle" title="Toggle Dark Mode">
                            <i data-lucide="moon" id="themeIcon"></i>
                        </span>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Log Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="container" data-aos="fade-in">
        @yield('content')
    </main>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });
        lucide.createIcons();

        // Theme Toggle
        const toggleTheme = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        // Set initial theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            html.setAttribute('data-theme', 'dark');
            themeIcon.setAttribute('data-lucide', 'sun');
        }

        toggleTheme?.addEventListener('click', () => {
            const isDark = html.getAttribute('data-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            themeIcon.setAttribute('data-lucide', newTheme === 'dark' ? 'sun' : 'moon');
            lucide.createIcons();
        });
    </script>
</body>
</html>
