@extends('layouts.admin')

@section('title', 'Informasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
  <h2 class="fw-bold mb-0">📢 Daftar Informasi</h2>
  <a href="{{ route('informasi.create') }}" class="btn btn-gradient btn-lg shadow-sm">
    <i class="bi bi-plus-circle me-1"></i> Tambah Informasi
  </a>
</div>

@if($informasis->isEmpty())
  <div class="alert alert-warning shadow-sm" data-aos="fade-up">
    <i class="bi bi-info-circle-fill me-2"></i> Belum ada informasi tersedia.
  </div>
@else
  <div class="table-responsive glass-card p-4" data-aos="fade-up" data-aos-delay="100">
    <table class="table align-middle table-hover text-dark">
      <thead class="table-light">
        <tr>
          <th>Judul</th>
          <th>Konten</th>
          <th>Tanggal</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($informasis as $info)
        <tr>
          <td class="fw-semibold">{{ $info->judul }}</td>
          <td>{{ Str::limit(strip_tags($info->isi), 60) }}</td>
          <td>{{ $info->tanggal->format('d M Y') }}</td>
          <td class="text-end">
            <a href="{{ route('informasi.edit', $info->id) }}" class="btn btn-sm btn-outline-primary me-2">
              <i class="bi bi-pencil-square"></i>
            </a>
            <form action="{{ route('informasi.destroy', $info->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus informasi ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endif
@endsection

@push('styles')
<style>
  .btn-gradient {
    background: linear-gradient(to right, #3b82f6, #9333ea);
    color: white;
    border: none;
    transition: all 0.3s ease;
  }

  .btn-gradient:hover {
    background: linear-gradient(to right, #2563eb, #7e22ce);
    transform: scale(1.03);
  }

  .glass-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
  }

  .glass-card:hover {
    transform: translateY(-3px);
  }

  table td, table th {
    vertical-align: middle;
  }
</style>
@endpush
