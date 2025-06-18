<?php
// app/Http/Controllers/PenggunaController.php (Lanjutan)

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::paginate(10);
        return view('pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:pengguna',
            'kata_sandi' => 'required|min:6',
            'peran' => 'required|in:admin,petugas,pimpinan',
        ]);

        $data = $request->all();
        $data['kata_sandi'] = Hash::make($request->kata_sandi);

        Pengguna::create($data);

        return redirect()->route('pengguna.index')->with('sukses', 'Pengguna berhasil ditambahkan');
    }

    public function edit(Pengguna $pengguna)
    {
        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:pengguna,email,' . $pengguna->id,
            'peran' => 'required|in:admin,petugas,pimpinan',
        ]);

        $data = $request->all();
        
        if ($request->filled('kata_sandi')) {
            $data['kata_sandi'] = Hash::make($request->kata_sandi);
        } else {
            unset($data['kata_sandi']);
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')->with('sukses', 'Pengguna berhasil diperbarui');
    }

    public function destroy(Pengguna $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $pengguna->delete();
        return redirect()->route('pengguna.index')->with('sukses', 'Pengguna berhasil dihapus');
    }
}
