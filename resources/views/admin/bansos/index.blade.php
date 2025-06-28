@extends('layouts.admin')

@section('title', 'Manajemen Bansos')

@section('content')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

<style>
    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        position: relative;
        margin-bottom: 1.5rem;
    }

    .section-title::after {
        content: '';
        width: 60px;
        height: 4px;
        background: #0d6efd;
        position: absolute;
        bottom: -10px;
        left: 0;
        border-radius: 2px;
    }

    .card-box {
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        padding: 2rem;
        margin-bottom: 2.5rem;
    }

    .btn-modern {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white !important;
        border: none;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-modern:hover {
        background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
        color: white !important;
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <h2 class="section-title">Manajemen Bansos</h2>
        <a href="{{ route('bansos.create') }}" class="btn btn-modern">+ Tambah Bansos</a>
    </div>

    {{-- Bansos Aktif --}}
    <div class="card-box" data-aos="fade-up">
        <h4 class="section-title">Bansos yang Sedang Berlangsung</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Penduduk</th>
                        <th>Jenis Bantuan</th>
                        <th>Sumber Bantuan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeBansos as $index => $bansos)
                    <tr class="fade-in">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $bansos->penduduk->nama_kepala_keluarga ?? 'Tidak ditemukan' }}</td>
                        <td>{{ $bansos->aid_type }}</td>
                        <td>{{ $bansos->source }}</td>
                        <td>{{ \Carbon\Carbon::parse($bansos->start_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($bansos->end_date)->format('d-m-Y') }}</td>
                        <td>
                            <form action="{{ route('bansos.destroy', $bansos->id) }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data bansos aktif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Riwayat Bansos --}}
    <div class="card-box bg-light" data-aos="fade-up">
        <h4 class="section-title">Riwayat Bansos yang Sudah Berakhir</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Penduduk</th>
                        <th>Jenis Bantuan</th>
                        <th>Sumber Bantuan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pastBansos as $index => $bansos)
                    <tr class="fade-in">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $bansos->penduduk->nama_kepala_keluarga ?? 'Tidak ditemukan' }}</td>
                        <td>{{ $bansos->aid_type }}</td>
                        <td>{{ $bansos->source }}</td>
                        <td>{{ \Carbon\Carbon::parse($bansos->start_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($bansos->end_date)->format('d-m-Y') }}</td>
                        <td>-</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data riwayat bansos.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, once: true });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
    @endif

    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const form = this.closest('.form-delete');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak akan tampil di bansos aktif lagi.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, pindahkan ke riwayat!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
