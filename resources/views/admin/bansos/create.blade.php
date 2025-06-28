@extends('layouts.admin')

@section('title', 'Tambah Bansos')

@section('content')
<div class="container">
    <h2>Tambah Data Bansos</h2>

    <!-- Form untuk filter penduduk -->
    <form method="GET" action="{{ route('bansos.create') }}">
        @csrf

        {{-- Pilih Kriteria Pendapatan --}}
        <div class="mb-3">
            <label for="income_criteria" class="form-label">Pilih Kriteria Pendapatan</label>
            <select name="income_criteria" class="form-select" id="income_criteria" required>
                <option value="individual" {{ old('income_criteria', $incomeCriteria) == 'individual' ? 'selected' : '' }}>
                    Pendapatan per Individu
                </option>
                <option value="total_kk" {{ old('income_criteria', $incomeCriteria) == 'total_kk' ? 'selected' : '' }}>
                    Pendapatan Total per KK
                </option>
                <option value="average_kk" {{ old('income_criteria', $incomeCriteria) == 'average_kk' ? 'selected' : '' }}>
                    Pendapatan Rata-Rata per KK
                </option>
            </select>
        </div>

        {{-- Batas Pendapatan --}}
        <div class="mb-3">
            <label for="income_threshold" class="form-label">Batas Pendapatan</label>
            <input type="number" name="income_threshold" id="income_threshold" class="form-control" required min="0"
                value="{{ old('income_threshold', $incomeThreshold) }}">
        </div>

        <button type="submit" class="btn btn-primary">Tampilkan Penduduk</button>
    </form>

    @if(isset($eligiblePenduduk) && $eligiblePenduduk->isNotEmpty())
        <!-- Form untuk memilih penduduk -->
        <form method="POST" action="{{ route('bansos.store') }}">
            @csrf

            {{-- Pilih Penduduk Berdasarkan Kriteria --}}
            <div class="mb-3">
                <label for="penduduk_id" class="form-label">Pilih Penduduk yang Memenuhi Kriteria</label>
                <select name="penduduk_id" class="form-select" id="penduduk_id" required>
                    @foreach($eligiblePenduduk as $penduduk)
                        <option value="{{ $penduduk->id }}">
                            {{ $penduduk->nama_kepala_keluarga }} ({{ $penduduk->nik }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sumber Bansos --}}
            <div class="mb-3">
                <label for="source" class="form-label">Sumber Bansos</label>
                <input type="text" name="source" class="form-control" required>
            </div>

            {{-- Jenis Bantuan Sosial --}}
            <div class="mb-3">
                <label for="aid_type" class="form-label">Jenis Bantuan Sosial</label>
                <input type="text" name="aid_type" class="form-control" required>
            </div>

            {{-- Tanggal Mulai --}}
            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            {{-- Tanggal Berakhir --}}
            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Berakhir</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan Bansos</button>
        </form>
    @elseif(request()->has('income_criteria'))
        <div class="alert alert-warning mt-4">
            <h5 class="text-danger">Tidak ada penduduk yang memenuhi kriteria.</h5>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('error'))
        Swal.fire({
            icon: 'warning',
            title: 'Gagal Menyimpan',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 4000,
            customClass: {
                popup: 'animated bounceInUp',
            },
        });
    @endif
</script>
@endpush
