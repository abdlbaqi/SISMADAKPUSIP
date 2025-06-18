<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class KategoriSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kategoriSurat = KategoriSurat::orderBy('nama_kategori', 'asc')->paginate(10);
        
        
        return view('kategori-surat.index', compact('kategoriSurat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('kategori-surat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_surat,nama_kategori',
            'kode_kategori' => 'required|string|max:10|unique:kategori_surat,kode_kategori',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'required|boolean'
        ]);

        KategoriSurat::create($validated);

        return redirect()->route('kategori-surat.index')
                        ->with('success', 'Kategori surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriSurat $kategoriSurat): View
    {
        return view('kategori-surat.show', compact('kategoriSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriSurat $kategoriSurat): View
    {
        return view('kategori-surat.edit', compact('kategoriSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriSurat $kategoriSurat): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_surat,nama_kategori,' . $kategoriSurat->id,
            'kode_kategori' => 'required|string|max:10|unique:kategori_surat,kode_kategori,' . $kategoriSurat->id,
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'required|boolean'
        ]);

        $kategoriSurat->update($validated);

        return redirect()->route('kategori-surat.index')
                        ->with('success', 'Kategori surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriSurat $kategoriSurat): RedirectResponse
    {
        try {
            $kategoriSurat->delete();
            return redirect()->route('kategori-surat.index')
                            ->with('success', 'Kategori surat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-surat.index')
                            ->with('error', 'Kategori surat tidak dapat dihapus karena masih digunakan.');
        }
    }


}