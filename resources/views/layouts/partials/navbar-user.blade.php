<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm" id="navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}" id="navbarBrand">Pantau Warga</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser"
            aria-controls="navbarUser" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarUser">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-link-animated" href="{{ route('user.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-animated" href="{{ route('user.data-diri') }}">Data Diri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-animated" href="{{ route('user.anggota-keluarga') }}">Keluarga</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-animated" href="{{ route('user.informasi') }}">Informasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-animated" href="{{ route('user.pembayaran.index') }}">Pembayaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-animated" href="{{ route('user.bansos-saya') }}">Bansos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-animated" href="{{ route('user.chat-ai') }}">Chat AI</a>
                </li>
                <li class="nav-item">
                    <button id="themeToggle" class="btn btn-outline-secondary">🌙</button> <!-- Dark Mode Toggle -->
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>