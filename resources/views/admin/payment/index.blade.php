@extends('layouts.admin')

@section('title', 'Riwayat Pembayaran')

@section('content')
    {{-- AOS Animate On Scroll --}}
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .card-custom {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .section-header {
            font-weight: 700;
            font-size: 2.5rem;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: 1px;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>

    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="section-header">💳 Riwayat Pembayaran Warga</h2>
            <p class="text-muted">Lihat, kelola, dan perbarui pembayaran warga secara efisien</p>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
            <a href="{{ route('payment.create') }}" class="btn btn-success shadow-sm">
                + Buat Pembayaran Baru
            </a>
        </div>

        {{-- === SECTION: Jenis Pembayaran === --}}
        <div class="card card-custom mb-5 p-4" data-aos="zoom-in-up">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">💼 Jenis Pembayaran</h5>
                <a href="{{ route('jenis-pembayaran.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    + Tambah Jenis Pembayaran
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Jenis</th>
                            <th>Nominal</th>
                            <th style="width: 300px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jenisPembayarans as $jenis)
                            <tr>
                                <td>{{ $jenis->nama }}</td>
                                <td>Rp {{ number_format($jenis->nominal) }}</td>
                                <td>
                                    <form action="{{ route('jenis-pembayaran.update', $jenis->id) }}" method="POST"
                                        class="d-inline d-flex gap-2">
                                        @csrf @method('PUT')
                                        <input type="text" name="nama" value="{{ $jenis->nama }}" required
                                            class="form-control form-control-sm" style="width: 150px;">
                                        <input type="number" name="nominal" value="{{ $jenis->nominal }}" required
                                            class="form-control form-control-sm" style="width: 100px;">
                                        <button class="btn btn-sm btn-success">Simpan</button>
                                    </form>

                                    <form action="{{ route('jenis-pembayaran.destroy', $jenis->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger ms-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- === SECTION: Riwayat Pembayaran === --}}
        <div class="card card-custom p-4" data-aos="fade-up">
            <h5 class="mb-3">📄 Daftar Pembayaran</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama User</th>
                            <th>Jenis</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $p)
                            <tr>
                                <td>{{ $p->user->name }}</td>
                                <td>{{ $p->jenis->nama }}</td>
                                <td>Rp {{ number_format($p->jumlah) }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_pembayaran)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $p->status == 'Lunas' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form method="POST" action="{{ route('admin.pembayaran.updateStatus', $p->id) }}">
                                            @csrf @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="form-select form-select-sm">
                                                <option {{ $p->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option {{ $p->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            </select>
                                        </form>

                                        <a href="{{ route('admin.pembayaran.edit', $p->id) }}"
                                            class="btn btn-warning btn-sm edit-btn">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.pembayaran.destroy', $p->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- AOS Script --}}
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 700 });

        // Hapus konfirmasi dengan SweetAlert2
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-4 shadow'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Edit konfirmasi
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                Swal.fire({
                    title: 'Edit Data?',
                    text: "Anda akan diarahkan ke halaman edit.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6c757d',
                    customClass: {
                        popup: 'rounded-4 shadow'
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>
@endsection