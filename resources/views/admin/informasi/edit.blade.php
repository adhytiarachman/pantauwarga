@extends('layouts.admin')

@section('title', 'Edit Informasi')

@section('content')
<h1>Edit Informasi</h1>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('informasi.update', $informasi->id) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="mb-3">
    <label for="judul" class="form-label">Judul</label>
    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $informasi->judul) }}" required>
  </div>

  <div class="mb-3">
    <label for="konten" class="form-label">Konten Informasi</label>
    <textarea class="form-control" id="konten" name="konten" rows="5" required>{{ old('konten', $informasi->konten) }}</textarea>
  </div>

  <div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $informasi->tanggal->format('Y-m-d')) }}" required>
  </div>

  <button type="submit" class="btn btn-primary">Update</button>
  <a href="{{ route('informasi.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
