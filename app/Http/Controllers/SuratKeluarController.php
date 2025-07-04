<?php
// File: app/Http/Controllers/SuratKeluarController.php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuratKeluarExport;
use Carbon\Carbon;


class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratKeluar::query();


        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%");
            });
        }

        $suratKeluar = $query->orderBy('tanggal_surat', 'desc')
                           ->paginate(10)
                           ->withQueryString();

        $kategori = KategoriSurat::all();

        return view('surat-keluar.index', compact('suratKeluar', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriSurat::all();
        return view('surat-keluar.create', compact('kategori',));
    }

 public function store(Request $request)
{
    $validatedData = $request->validate([
        'tanggal_surat'        => 'required|date',
        'nomor_surat'          => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategori_surat,id',
        'sifat_surat'          => 'required|string|max:255',
        'klasifikasi'          => 'required|string|max:255',
        'hal'                  => 'required|string|max:500',
        'dikirimkan_melalui'   => 'required|string|max:255',
        'tujuan_surat'         => 'required|string|max:255',
        'nama_penandatangan'   => 'required|string|max:255',
        'file_surat'           => 'nullable|file|mimes:pdf,doc,docx|max:5120',
    ]);

    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filepath = $file->storeAs('surat-keluar', $filename, 'public');
        $validatedData['file_surat'] = $filepath;
    }
    

    // Simpan ke database
    SuratKeluar::create($validatedData);

    return redirect()->route('surat-keluar.index')
                     ->with('success', 'Surat keluar berhasil ditambahkan!');
}


    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load('kategori');
        return view('surat-keluar.show', compact('suratKeluar'));
    }

    public function edit(SuratKeluar $suratKeluar)
    {
       $kategori = KategoriSurat::all();
        return view('surat-keluar.edit', compact('suratKeluar', 'kategori',));
    }

       public function update(Request $request, SuratKeluar $suratKeluar)
{
    $data = $request->validate([
        'kategori_id'         => 'required|exists:kategori_surat,id',
        'sifat_surat'         => 'required|string',
        'tanggal_surat'       => 'required|date',
        'nomor_surat'         => 'required|string',
        'klasifikasi'         => 'required|string',
        'hal'                 => 'required|string|max:500',
        'dikirimkan_melalui'  => 'required|string',
        'tujuan_surat'        => 'required|string',
        'nama_penandatangan'  => 'required|string',
        'file_surat'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
    ]);

    // Handle file upload jika ada
    if ($request->hasFile('file_surat')) {
        if ($suratKeluar->file_surat && Storage::disk('public')->exists($suratKeluar->file_surat)) {
            Storage::disk('public')->delete($suratKeluar->file_surat);
        }

        $file = $request->file('file_surat');
        $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('surat-keluar', $fileName, 'public');
        $data['file_surat'] = $filePath;
    }

    $suratKeluar->update($data);

    return redirect()->route('surat-keluar.index')
        ->with('success', 'Surat keluar berhasil diperbarui!');
}


   public function destroy(SuratKeluar $suratKeluar)
    {
        // Hapus file jika ada
        if ($suratKeluar->file_surat && Storage::disk('public')->exists($suratKeluar->file_surat)) {
            Storage::disk('public')->delete($suratKeluar->file_surat);
        }
        
        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')
                        ->with('sukses', 'Surat keluar berhasil dihapus');
    }

 public function unduhFile(SuratKeluar $suratKeluar)
{
    $path = $suratKeluar->file_surat; // sudah "surat-keluar/NAMA.pdf"

    if (!Storage::disk('public')->exists($path)) {
        return back()->with('error', 'File tidak ditemukan di: ' . $path);
    }

    return Storage::disk('public')->download($path);
}

 public function exportPdf(Request $request)
    {
        $search = $request->get('cari');

        $data = SuratKeluar::query()
            // ->when($search, function ($query, $search) {
            //     $query->where('nomor_surat', 'like', "%{$search}%")
            //         ->orWhere('nama_pengirim', 'like', "%{$search}%");
            // })
            ->orderBy('tanggal_surat', 'desc')
            ->get();

        $pdf = Pdf::loadView('surat-keluar.export-pdf', ['data' => $data])
                ->setPaper('A4', 'landscape');

        return $pdf->download('Surat_Keluar_' . now()->format('Y-m-d') . '.pdf');
    }

       public function export(Request $request)
    {
        $search = $request->get('cari');
        $filename = 'Data Surat Keluar Perpustakaan dan Kearsipan Provinsi Lampung ' . date('d-m-Y') . '.xlsx';
        
        return Excel::download(new SuratKeluarExport($search), $filename);
    }

}