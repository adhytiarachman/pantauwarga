@extends('layouts.user')

@section('title', 'Informasi RT')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <h2 class="mb-4 text-center text-gradient" data-aos="fade-down">📢 Informasi RT</h2>

        {{-- Daftar Informasi --}}
        @foreach ($informasi as $info)
            <div class="card mb-4 shadow-sm border-light rounded" data-aos="fade-up">
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $info->judul }}</h5>
                    <p class="card-text">{{ $info->konten }}</p>
                    <small class="text-muted">{{ $info->created_at->format('d M Y') }}</small>
                </div>
            </div>
        @endforeach



    </div>
@endsection

@push('styles')
    <style>
        .text-gradient {
            background: linear-gradient(90deg, #2563eb, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card {
            border-radius: 1rem;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1rem;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
        }

        .card-footer {
            font-size: 0.875rem;
            color: #888;
        }

        .bansos-info {
            background-color: #e0f7fa;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .no-bansos-info {
            background-color: #fff3e0;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .bansos-info h3,
        .no-bansos-info h3 {
            color: #00796b;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            .card-title {
                font-size: 1.1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true
        });
    </script>
@endpush