@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
    <style>
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: capitalize;
            white-space: nowrap;
        }
        .badge-success { background-color: #dcfce7; color: #15803d; }
        .badge-warning { background-color: #fef9c3; color: #a16207; }
        .badge-danger  { background-color: #fee2e2; color: #b91c1c; }
        
        /* Merapikan Link & Tombol Aksi */
        .action-cell {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: nowrap;
        }
        .btn-kembali {
            background-color: #16a34a;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-hapus {
            background-color: #dc2626;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
    </style>

    <h1>Daftar Peminjaman</h1>

    <p><a href="{{ route('loans.create') }}" class="btn">+ Tambah Peminjaman</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Anggota</th>
                <th>Petugas</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($loans as $loan)
                <tr>
                    <td>{{ $loan['id'] }}</td>
                    <td>{{ $loan['member']['nama'] }}</td>
                    <td>{{ $loan['user']['name'] }}</td>
                    <td>
                        @foreach ($loan['loanItems'] as $item)
                            {{ $item['book']['judul'] }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>{{ $loan['tanggal_pinjam'] }}</td>
                    <td>{{ $loan['tanggal_kembali'] }}</td>
                    <td>
                        @if ($loan['status'] === 'dikembalikan')
                            <span class="badge badge-success">Dikembalikan</span>
                        @elseif ($loan['status'] === 'dipinjam')
                            <span class="badge badge-warning">Dipinjam</span>
                        @else
                            <span class="badge badge-danger">Terlambat</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-cell">
                            @if ($loan['status'] === 'dipinjam')
                                <form action="{{ route('loans.kembalikan', $loan['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-kembali" onclick="return confirm('Kembalikan buku ini?')">
                                        Kembalikan
                                    </button>
                                </form>
                                <span>|</span>
                            @endif

                            <a href="{{ route('loans.show', $loan['id']) }}">Detail</a>
                            <span>|</span>
                            <a href="{{ route('loans.edit', $loan['id']) }}">Edit</a>
                            <span>|</span>
                            <form action="{{ route('loans.destroy', $loan['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus" onclick="return confirm('Yakin hapus transaksi ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $loans->links() }}
@endsection