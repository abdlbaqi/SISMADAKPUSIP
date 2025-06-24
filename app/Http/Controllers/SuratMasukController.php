<?php

namespace App\Http\Controllers;

use App\Exports\SuratMasukExport;
use App\Models\SuratMasuk;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratMasuk::with(['kategori','pembuatSurat']);
        
        // Filter berdasarkan pencarian
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('nomor_surat', 'like', "%{$cari}%");
            });
        }
        
        $surat_masuk = $query->paginate(10);
        $kategori = KategoriSurat::all();
        
        return view('surat-masuk.index', compact('surat_masuk', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriSurat::all();
        return view('surat-masuk.create', compact('kategori',));
    }

  public function store(Request $request)
{
    $validatedData = $request->validate([
        'nama_pengirim'      => 'required|string|max:255',
        'jabatan_pengirim'   => 'required|string|max:255',
        'instansi_pengirim'  => 'required|string|max:255',
        'nomor_surat'        => 'required|string|max:255',
        'perihal'            => 'required|string|max:255',
        'isi_ringkas'        => 'required|string',
        'tanggal_surat'      => 'required|date',
        'tanggal_diterima'   => 'required|date',
        'kategori_id'        => 'required|exists:kategori_surat,id',
        'sifat_surat'        => 'required|in:biasa,penting,segera,rahasia',
        'file_surat'         => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB
        'unit_disposisi' => [
        'required',
        Rule::in([
            'sekretaris',
            'kabid_deposit',
            'kabid_pengembangan',
            'kabid_layanan',
            'kabid_pembinaan',
            'kabid_pengelolaan_arsip',
        ]),
    ],

    ]);

    // Handle file upload
    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filepath = $file->storeAs('surat-masuk', $filename, 'public');
        $validatedData['file_surat'] = $filepath;
    }
    
    // Simpan ke database
    SuratMasuk::create($validatedData);

    return redirect()->route('surat-masuk.index')
                     ->with('sukses', 'Surat masuk berhasil ditambahkan');
}


    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load(['kategori','pembuatSurat']);
        
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        $kategori = KategoriSurat::all();
        return view('surat-masuk.edit', compact('suratMasuk', 'kategori',));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validatedData = $request->validate([
            'nomor_surat' => 'required|string|max:255', 
            'jabatan_pengirim'   => 'required|string|max:255',
            'instansi_pengirim'  => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi_ringkas' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'sifat_surat' => 'required|in:biasa,penting,segera,rahasia,',
            'nama_pengirim' => 'required|string|max:255',
             'unit_disposisi' => [
    'required',
    Rule::in([
        'sekretaris',
        'kabid_deposit',
        'kabid_pengembangan',
        'kabid_layanan',
        'kabid_pembinaan',
        'kabid_pengelolaan_arsip',
    ]),
],

            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB
        ]);

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            // Hapus file lama jika ada
            if ($suratMasuk->file_surat && Storage::disk('public')->exists($suratMasuk->file_surat)) {
                Storage::disk('public')->delete($suratMasuk->file_surat);
            }
            
            $file = $request->file('file_surat');
            $filename = $file->getClientOriginalName();
            $file->storeAs('surat-masuk', $filename, 'public');
            $validatedData['file_surat'] = $filename;
        }

        $suratMasuk->update($validatedData);

        return redirect()->route('surat-masuk.index')
                        ->with('sukses', 'Surat masuk berhasil diperbarui');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        // Hapus file jika ada
        if ($suratMasuk->file_surat && Storage::disk('public')->exists($suratMasuk->file_surat)) {
            Storage::disk('public')->delete($suratMasuk->file_surat);
        }
        
        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')
                        ->with('sukses', 'Surat masuk berhasil dihapus');
    }

    
    public function unduhFile(SuratMasuk $suratMasuk)
{
    $path = $suratMasuk->file_surat; // sudah "surat-keluar/NAMA.pdf"

    if (!Storage::disk('public')->exists($path)) {
        return back()->with('error', 'File tidak ditemukan di: ' . $path);
    }

    return Storage::disk('public')->download($path);
}

    
        public function export(Request $request)
    {
        $search = $request->get('cari');
        $filename = 'Data Surat Masuk Perpustakaan dan Kearsipan Provinsi Lampung ' . date('d-m-Y') . '.xlsx';
        
        return Excel::download(new SuratMasukExport($search), $filename);
    }


    public function exportPdf(Request $request)
    {
        $search = $request->get('cari');

        $data = SuratMasuk::query()
            // ->when($search, function ($query, $search) {
            //     $query->where('nomor_surat', 'like', "%{$search}%")
            //         ->orWhere('nama_pengirim', 'like', "%{$search}%");
            // })
            ->orderBy('tanggal_diterima', 'desc')
            ->get();

        $pdf = Pdf::loadView('surat-masuk.export-pdf', ['data' => $data])
                ->setPaper('A4', 'landscape');

        return $pdf->download('Surat_Masuk_' . now()->format('Y-m-d') . '.pdf');
    }

}