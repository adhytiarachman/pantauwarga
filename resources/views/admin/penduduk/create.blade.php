@extends('layouts.admin')

@section('title', 'Tambah Anggota Keluarga')

@section('content')
<h1>Tambah Anggota Keluarga</h1>

<form method="POST" action="{{ route('penduduk.store') }}">
    @csrf

    <div class="mb-3">
        <label for="no_kk_select" class="form-label">Pilih No. KK yang sudah ada</label>
        <select name="no_kk" id="no_kk_select" class="form-select" onchange="toggleNoKkInput()">
            <option value="">-- Pilih No. KK --</option>
            @foreach($allNoKK as $kk)
                <option value="{{ $kk }}">{{ $kk }}</option>
            @endforeach
            <option value="__new">+ Tambah No. KK baru</option>
        </select>
    </div>

    <div class="mb-3" id="no_kk_input_container" style="display:none;">
        <label for="no_kk_input" class="form-label">Masukkan No. KK baru</label>
        <input type="text" name="no_kk_input" id="no_kk_input" class="form-control" placeholder="No. KK baru">
    </div>

    <div class="mb-3">
        <label for="nik" class="form-label">NIK</label>
        <input type="text" name="nik" id="nik" class="form-control" maxlength="16" required value="{{ old('nik') }}">
    </div>

    <div class="mb-3">
        <label for="nama_kepala_keluarga" class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_kepala_keluarga" id="nama_kepala_keluarga" class="form-control" required value="{{ old('nama_kepala_keluarga') }}">
    </div>

    <div class="mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="usia" class="form-label">Usia</label>
        <input type="number" name="usia" id="usia" class="form-control" min="0" required value="{{ old('usia') }}">
    </div>

    <div class="form-group">
        <label for="status_perkawinan">Status Perkawinan</label>
            <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                <option value="Belum Menikah">Belum Menikah</option>
                <option value="Menikah">Menikah</option>
                <option value="Janda/Duda">Janda/Duda</option>
            </select>
    </div>

    <div class="form-group">
        <label for="agama">Agama</label>
            <select name="agama" id="agama" class="form-control">
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Katolik">Katolik</option>
                <option value="Konghucu">Konghucu</option>
            </select>
    </div>


    <div class="mb-3">
        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
    </div>

    <div class="mb-3">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
    </div>


    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat Rumah</label>
        <input type="text" name="alamat" id="alamat" class="form-control" required value="{{ old('alamat') }}">
    </div>

    <div class="mb-3">
        <label for="pekerjaan" class="form-label">Pekerjaan</label>
        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}">
    </div>

    <div class="form-group mb-3">
        <label for="income_per_month">Pendapatan per Bulan</label>
        <input type="number" name="income_per_month" id="income_per_month" class="form-control" value="{{ old('income_per_month') }}" required>
    </div>


    <div class="mb-3">
        <label for="status_tinggal" class="form-label">Status Tinggal</label>
        <select name="status_tinggal" id="status_tinggal" class="form-select" required>
            <option value="">-- Pilih Status Tinggal --</option>
            <option value="Menetap" {{ old('status_tinggal') == 'Menetap' ? 'selected' : '' }}>Menetap</option>
            <option value="Sementara" {{ old('status_tinggal') == 'Sementara' ? 'selected' : '' }}>Sementara</option>
        </select>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="is_kepala_keluarga" id="is_kepala_keluarga" class="form-check-input" {{ old('is_kepala_keluarga') ? 'checked' : '' }}>
        <label for="is_kepala_keluarga" class="form-check-label">Jadikan Kepala Keluarga</label>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
function toggleNoKkInput() {
    const select = document.getElementById('no_kk_select');
    const inputContainer = document.getElementById('no_kk_input_container');
    const input = document.getElementById('no_kk_input');

    if (select.value === '__new') {
        inputContainer.style.display = 'block';
        input.required = true;
        select.name = '';
    } else {
        inputContainer.style.display = 'none';
        input.required = false;
        select.name = 'no_kk';
    }
}
</script>
@endsection
