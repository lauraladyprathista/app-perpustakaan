<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private array $members = [
        ['id' => 1, 'nama' => 'Laura Lady', 'nim' => '230101001', 'email' => 'laura@example.com', 'nomor_telepon' => '081234567890', 'alamat' => 'Surabaya', 'status' => 'aktif'],
        ['id' => 2, 'nama' => 'Prathista Rana', 'nim' => '230101002', 'email' => 'prathista@example.com', 'nomor_telepon' => '089876543210', 'alamat' => 'Sidoarjo', 'status' => 'aktif'],
    ];

    public function index()
    {
        $members = $this->members;

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database).");
    }

    public function show(string $id)
    {
        $members = collect($this->members)->firstWhere('id', $id);
        abort_if(! $members,404);
        return view('members.show', compact('members'));
    }

    public function edit(string $id)
    {
        return "MemberController@edit, id: {$id}";
    }

    public function update(Request $request, string $id)
    {
        return "MemberController@update, id: {$id}";
    }

    public function destroy(string $id)
    {
        return redirect()->route('members.index')
            ->with('success', "Anggota dengan id {$id} berhasil dihapus (data dummy).");
    }
}