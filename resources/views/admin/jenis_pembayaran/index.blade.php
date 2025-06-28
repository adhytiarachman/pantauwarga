<a href="{{ route('admin.jenis_pembayaran.create') }}" class="btn btn-success mb-3">+ Tambah Jenis Pembayaran</a>

<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Nominal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jenis as $j)
            <tr>
                <td>{{ $j->nama }}</td>
                <td>Rp {{ number_format($j->nominal) }}</td>
                <td>
                    <a href="{{ route('admin.jenis_pembayaran.edit', $j->id) }}" class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>