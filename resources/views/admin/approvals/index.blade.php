@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Persetujuan Akun Pengguna</h2>

    {{-- Filter Tabs --}}
    <div class="mb-3">
        <a href="{{ route('admin.approvals', ['status' => null]) }}"
           class="btn btn-outline-secondary {{ $filter === null ? 'active' : '' }}">
           Menunggu
        </a>
        <a href="{{ route('admin.approvals', ['status' => 'approved']) }}"
           class="btn btn-outline-success {{ $filter === 'approved' ? 'active' : '' }}">
           Disetujui
        </a>
        <a href="{{ route('admin.approvals', ['status' => 'rejected']) }}"
           class="btn btn-outline-danger {{ $filter === 'rejected' ? 'active' : '' }}">
           Ditolak
        </a>
    </div>

    @if($users->isEmpty())
        <p class="text-muted">Tidak ada akun pada status ini.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>KK</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->no_kk }}</td>
                        <td class="text-center">
                            @if (!isset($user->rejected_at) && (!$user->is_approved ?? true))
                                <button type="button" class="btn btn-success btn-sm"
                                        onclick="confirmApprove('{{ route('admin.approvals.approve', $user) }}')">
                                    Setujui
                                </button>

                                <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmReject('{{ route('admin.approvals.reject', $user) }}')">
                                    Tolak
                                </button>
                            @elseif($filter === 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($filter === 'rejected')
                                <span class="badge bg-danger">Ditolak pada {{ \Carbon\Carbon::parse($user->rejected_at)->format('d M Y') }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfirmasi Approve
    function confirmApprove(url) {
        Swal.fire({
            title: 'Setujui akun ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                submitPost(url);
            }
        });
    }

    // Konfirmasi Reject
    function confirmReject(url) {
        Swal.fire({
            title: 'Tolak akun ini?',
            text: "Data akan dihapus dari database, namun disimpan di arsip.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                submitPost(url);
            }
        });
    }

    // Kirim POST manual dengan token CSRF
    function submitPost(url) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';

        form.appendChild(token);
        document.body.appendChild(form);
        form.submit();
    }

    // Tampilkan notifikasi sukses setelah redirect
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush
