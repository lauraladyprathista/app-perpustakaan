@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h2>Profil Saya</h2>

    @if (session('success'))
        <div style="padding: 10px; background: #d1e7dd; color: #0f5132; border-radius: 4px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px;">
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
    </div>

    <hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc;">

    <h3>Ganti Password</h3>
    <form action="{{ route('profile.password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="current_password">Password Lama</label>
            <input type="password" name="current_password" id="current_password" style="width: 100%; padding: 8px; margin-top: 5px;" required>
            @error('current_password')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="password">Password Baru</label>
            <input type="password" name="password" id="password" style="width: 100%; padding: 8px; margin-top: 5px;" required>
            @error('password')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" style="width: 100%; padding: 8px; margin-top: 5px;" required>
        </div>

        <button type="submit" style="padding: 10px 15px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Simpan Password Baru
        </button>
    </form>
</div>
@endsection