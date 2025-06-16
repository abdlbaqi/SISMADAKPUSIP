<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::with(['kategori', 'pengarsip']);

        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_arsip', 'like', '%' . $request->cari . '%')
                  ->orWhere('nomor_berkas', 'like', '%' . $request->cari . '%')
                  ->orWhere('judul_berkas', 'like', '%' . $request->cari . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('jenis_arsip')) {
            $query->where('jenis_arsip', $request->jenis_arsip);
        }

        if ($request->filled('status_arsip')) {
            $query->where('status_arsip', $request->status_arsip);
        }

        // Filter berdasarkan tingkat akses
        if (auth()->user()->peran !== 'admin') {
            $query->where(function($q) {
                $q->where('tingkat_akses', 'publik')
                  ->orWhere('diarsipkan_oleh', auth()->id());
            });
        }

        $arsip = $query->orderBy('tanggal_arsip', 'desc')->paginate(10);
        $kategori = KategoriSurat::all();

        return view('arsip.index', compact('arsip', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriSurat::all();
        
        // Generate kode arsip otomatis
        $tahun = date('Y');
        $terakhir = Arsip::whereYear('created_at', $tahun)->count();
        $kode_arsip = sprintf('ARS-%04d-%s', $terakhir + 1, $tahun);

        return view('arsip.create', compact('kategori', 'kode_arsip'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_arsip' => 'required|unique:arsip',
            'nomor_berkas' => 'required',
            'judul_berkas' => 'required',
            'jenis_arsip' => 'required|in:surat_masuk,surat_keluar,dokumen_lain',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'tanggal_arsip' => 'required|date',
            'tingkat_akses' => 'required|in:publik,terbatas,rahasia',
            'retensi_sampai' => 'nullable|date|after:tanggal_arsip',
            'file_digital' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->all();
        $data['diarsipkan_oleh'] = auth()->id();
        $data['status_arsip'] = 'aktif';

        if ($request->hasFile('file_digital')) {
            $file = $request->file('file_digital');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $data['file_digital'] = $file->storeAs('arsip', $nama_file, 'public');
        }

        Arsip::create($data);

        return redirect()->route('arsip.index')->with('sukses', 'Arsip berhasil ditambahkan');
    }

    public function show(Arsip $arsip)
    {
        // Cek akses berdasarkan tingkat akses
        if ($arsip->tingkat_akses === 'rahasia' && auth()->user()->peran !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk melihat arsip ini');
        }

        if ($arsip->tingkat_akses === 'terbatas' && 
            auth()->user()->peran === 'petugas' && 
            $arsip->diarsipkan_oleh !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat arsip ini');
        }

        $arsip->load(['kategori', 'pengarsip']);
        return view('arsip.show', compact('arsip'));
    }

    public function edit(Arsip $arsip)
    {
        $kategori = KategoriSurat::all();
        return view('arsip.edit', compact('arsip', 'kategori'));
    }

    public function update(Request $request, Arsip $arsip)
    {
        $request->validate([
            'kode_arsip' => 'required|unique:arsip,kode_arsip,' . $arsip->id,
            'nomor_berkas' => 'required',
            'judul_berkas' => 'required',
            'jenis_arsip' => 'required|in:surat_masuk,surat_keluar,dokumen_lain',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'tanggal_arsip' => 'required|date',
            'tingkat_akses' => 'required|in:publik,terbatas,rahasia',
            'retensi_sampai' => 'nullable|date|after:tanggal_arsip',
            'file_digital' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_digital')) {
            if ($arsip->file_digital) {
                Storage::disk('public')->delete($arsip->file_digital);
            }

            $file = $request->file('file_digital');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $data['file_digital'] = $file->storeAs('arsip', $nama_file, 'public');
        }

        $arsip->update($data);

        return redirect()->route('arsip.index')->with('sukses', 'Arsip berhasil diperbarui');
    }

    public function destroy(Arsip $arsip)
    {
        if ($arsip->file_digital) {
            Storage::disk('public')->delete($arsip->file_digital);
        }

        $arsip->delete();

        return redirect()->route('arsip.index')->with('sukses', 'Arsip berhasil dihapus');
    }

    public function unduhFile(Arsip $arsip)
    {
        // Cek akses
        if ($arsip->tingkat_akses === 'rahasia' && auth()->user()->peran !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh arsip ini');
        }

        if (!$arsip->file_digital || !Storage::disk('public')->exists($arsip->file_digital)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($arsip->file_digital);
    }
}