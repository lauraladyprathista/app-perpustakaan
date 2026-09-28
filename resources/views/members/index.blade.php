<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Anggota</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; }
        .alert { background: #dcfce7; color: #166534; padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .btn { padding: 6px 12px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px; }
        .btn-danger { background: #dc2626; border: none; color: white; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
        .search-box { margin-bottom: 20px; display: flex; gap: 8px; }
        .search-box input { padding: 6px; width: 250px; }
    </style>
</head>
<body>
    <h1>Daftar Anggota</h1>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div style="margin-bottom: 20px;">
        <a href="{{ route('members.create') }}" class="btn">+ Tambah Anggota</a>
    </div>

    <form action="{{ route('members.index') }}" method="GET" class="search-box">
        <input type="text" name="search" placeholder="Cari nama anggota..." value="{{ request('search') }}">
        <button type="submit" class="btn">Cari</button>
        @if(request('search'))
            <a href="{{ route('members.index') }}" class="btn" style="background: #6b7280;">Reset</a>
        @endif
    </form>

    <table>
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>{{ $member['nim'] }}</td>
                    <td>{{ $member['nama'] }}</td>
                    <td>{{ $member['email'] }}</td>
                    <td>{{ $member['nomor_telepon'] }}</td>
                    <td>{{ ucfirst($member['status']) }}</td>
                    <td>
                        <a href="{{ route('members.show', $member['id']) }}">Detail</a> |
                        <a href="{{ route('members.edit', $member['id']) }}">Edit</a> |
                        <form action="{{ route('members.destroy', $member['id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus anggota ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data anggota.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $members->appends(request()->query())->links() }}
    </div>
</body>
</html>