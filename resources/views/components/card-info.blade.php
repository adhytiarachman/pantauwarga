@props([
    'judul',
    'tanggal',
    'konten',
    'delay' => 0,
])

<div class="card h-100 shadow-sm border-0" data-aos="fade-up" data-aos-delay="{{ $delay }}">
    <div class="card-header">
        <h5 class="mb-1">{{ $judul }}</h5>
        <small>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</small>
    </div>
    <div class="card-body">
        <p class="mb-0">
            {{ \Illuminate\Support\Str::limit(strip_tags($konten), 120, '...') }}
        </p>
    </div>
</div>
