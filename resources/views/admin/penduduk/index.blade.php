@extends('layouts.admin')

@section('title', 'Data Penduduk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1>Data Penduduk</h1>
    <a href="{{ route('penduduk.create') }}" class="btn btn-primary">Tambah Penduduk</a>
</div>

{{-- Form Filter --}}
<form method="GET" class="row g-3 align-items-center mb-4">
    <div class="col-md-5 position-relative">
        <input type="search" name="search" class="form-control ps-5" placeholder="Cari nama atau NIK" value="{{ $search ?? '' }}" autocomplete="off">
        <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
            <i class="bi bi-search"></i>
        </span>
    </div>

    <div class="col-md-4">
        <select name="no_kk" class="form-select" onchange="this.form.submit()">
            <option value="">-- Filter No. KK --</option>
            @foreach($allNoKK as $noKK)
                <option value="{{ $noKK }}" {{ (isset($no_kkFilter) && $no_kkFilter == $noKK) ? 'selected' : '' }}>{{ $noKK }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 d-grid">
        <button type="submit" class="btn btn-primary">Cari</button>
    </div>
</form>

{{-- Tampilkan Data --}}
@if($groupedPenduduk->isEmpty())
    <div class="alert alert-info">Data penduduk tidak ditemukan.</div>
@else
    <div class="row mb-4">
        @foreach($groupedPenduduk as $noKK => $penduduks)
            @php
                $kepala = $penduduks->firstWhere('is_kepala_keluarga', true) ?? $penduduks->first();
                $anggota = $penduduks->filter(fn($item) => $item->id !== $kepala->id);
            @endphp
            <div class="col-12 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white fw-bold">
                        No. KK: {{ $noKK }} <br>
                        Kepala Keluarga: {{ $kepala->nama_kepala_keluarga }} (NIK: {{ $kepala->nik }})
                    </div>
                    <div class="card-body p-0">
                        @if($anggota->isEmpty())
                            <div class="p-3 fst-italic text-center">
                                Tidak ada anggota keluarga selain kepala keluarga.
                            </div>
                        @else
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>TTL</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Usia</th>
                                        <th>Status Tinggal</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($anggota as $index => $penduduk)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $penduduk->nik }}</td>
                                            <td>{{ $penduduk->nama_kepala_keluarga }}</td>
                                            <td>
                                                {{ $penduduk->tempat_lahir ?? '-' }} /
                                                {{ $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td>{{ $penduduk->jenis_kelamin }}</td>
                                            <td>{{ $penduduk->usia }}</td>
                                            <td>{{ $penduduk->status_tinggal }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('penduduk.destroy', $penduduk->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      data-confirm="delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Tooltip --}}
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>

{{-- SweetAlert for Delete --}}
<script>
    document.querySelectorAll('form[data-confirm="delete"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

{{-- SweetAlert for Flash Message --}}
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
@endif

@if(session('error'))
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
@endpush
