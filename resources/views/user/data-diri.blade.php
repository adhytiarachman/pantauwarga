@extends('layouts.user')
@section('title', 'Data Diri')

@section('content')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

<div class="container py-5 px-3 px-md-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold display-4 text-gradient-modern" data-aos="zoom-in">🧾 Profil Anda</h1>
        <p class="text-muted fs-5" data-aos="fade-up" data-aos-delay="100">
            Ringkasan lengkap informasi pribadi Anda dalam sistem
        </p>
    </div>

    @if ($penduduk)
        @php
            $kepala = \App\Models\Penduduk::where('no_kk', $penduduk->no_kk)
                        ->where('is_kepala_keluarga', true)
                        ->first();
        @endphp

        <div class="profile-card p-4 p-md-5 rounded-4 shadow-lg mx-auto" style="max-width: 960px;" data-aos="fade-up" data-aos-delay="200">
            <div class="row g-4">
                @php
                    $fields = [
                        ['👨‍👩‍👧‍👦', 'Kepala Keluarga', $kepala->nama_kepala_keluarga ?? '-'],
                        ['🧑', 'Nama Anda', $penduduk->nama_kepala_keluarga ?? '-'],
                        ['🆔', 'NIK', $penduduk->nik],
                        ['📄', 'No. KK', $penduduk->no_kk],
                        ['🎂', 'Tempat/Tgl Lahir', ($penduduk->tempat_lahir ?? '-') . ' / ' . ($penduduk->tanggal_lahir ?? '-')],
                        ['📍', 'Alamat', $penduduk->alamat ?? '-'],
                        ['👥', 'Status Keluarga', $penduduk->is_kepala_keluarga ? 'Kepala Keluarga' : 'Anggota'],
                        ['🏠', 'Status Tinggal', $penduduk->status_tinggal ?? '-'],
                        ['💼', 'Pekerjaan', $penduduk->pekerjaan ?? '-'],
                        ['🎯', 'Usia', ($penduduk->usia ?? '-') . ' tahun'],
                        ['💍', 'Status Perkawinan', $penduduk->status_perkawinan ?? '-'],
                        ['🛕', 'Agama', $penduduk->agama ?? '-'],
                        ['💰', 'Pendapatan Bulanan', 'Rp ' . number_format($penduduk->income_per_month ?? 0, 2, ',', '.')]
                    ];
                @endphp

                @foreach($fields as [$icon, $label, $value])
                    <div class="col-md-6">
                        <div class="data-field d-flex gap-3 align-items-start p-3 rounded-3 shadow-sm" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="icon-box">{{ $icon }}</div>
                            <div>
                                <div class="text-muted small">{{ $label }}</div>
                                <div class="fw-semibold fs-6 text-dark">{{ $value }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center" data-aos="fade-in">Data penduduk belum tersedia.</div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .text-gradient-modern {
        background: linear-gradient(90deg, #0ea5e9, #6366f1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .profile-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(200, 200, 200, 0.2);
    }

    .data-field {
        background-color: #f9fafb;
        transition: all 0.3s ease;
    }

    .data-field:hover {
        background-color: #eef1f5;
        transform: scale(1.01);
    }

    .icon-box {
        font-size: 1.5rem;
        background: linear-gradient(135deg, #0ea5e9, #6366f1);
        color: white;
        border-radius: 0.75rem;
        padding: 0.5rem 0.7rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .data-field {
            padding: 1rem;
        }

        .icon-box {
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true,
        easing: 'ease-in-out',
    });
</script>
@endpush
