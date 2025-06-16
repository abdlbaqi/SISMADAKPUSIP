<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\KategoriSurat;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratMasuk::with(['kategori', 'pembuat', 'penerima']);

        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('nomor_surat', 'like', '%' . $request->cari . '%')
                  ->orWhere('asal_surat', 'like', '%' . $request->cari . '%')
                  ->orWhere('perihal', 'like', '%' . $request->cari . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_diterima', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $surat_masuk = $query->orderBy('tanggal_diterima', 'desc')->paginate(10);
        $kategori = KategoriSurat::all();

        return view('surat-masuk.index', compact('surat_masuk', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriSurat::all();
        $pengguna = Pengguna::where('peran', '!=', 'admin')->get();
        
        // Generate nomor agenda otomatis
        $tahun = date('Y');
        $bulan = date('m');
        $terakhir = SuratMasuk::whereYear('created_at', $tahun)
                             ->whereMonth('created_at', $bulan)
                             ->count();
        $nomor_agenda = sprintf('%03d/SM/%s/%s', $terakhir + 1, $bulan, $tahun);

        return view('surat-masuk.create', compact('kategori', 'pengguna', 'nomor_agenda'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_agenda' => 'required|unique:surat_masuk',
            'nomor_surat' => 'required',
            'asal_surat' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'sifat_surat' => 'required|in:biasa,penting,segera,rahasia',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->all();
        $data['dibuat_oleh'] = auth()->id();
        $data['status'] = 'belum_dibaca';

        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $data['file_surat'] = $file->storeAs('surat-masuk', $nama_file, 'public');
        }

        SuratMasuk::create($data);

        return redirect()->route('surat-masuk.index')->with('sukses', 'Surat masuk berhasil ditambahkan');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load(['kategori', 'pembuat', 'penerima', 'disposisi.penerima']);
        
        // Update status menjadi sudah dibaca jika belum dibaca
        if ($suratMasuk->status === 'belum_dibaca') {
            $suratMasuk->update(['status' => 'sudah_dibaca']);
        }

        return view('surat-masuk.show', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        $kategori = KategoriSurat::all();
        $pengguna = Pengguna::where('peran', '!=', 'admin')->get();

        return view('surat-masuk.edit', compact('suratMasuk', 'kategori', 'pengguna'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $request->validate([
            'nomor_agenda' => 'required|unique:surat_masuk,nomor_agenda,' . $suratMasuk->id,
            'nomor_surat' => 'required',
            'asal_surat' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'sifat_surat' => 'required|in:biasa,penting,segera,rahasia',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_surat')) {
            // Hapus file lama jika ada
            if ($suratMasuk->file_surat) {
                Storage::disk('public')->delete($suratMasuk->file_surat);
            }

            $file = $request->file('file_surat');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $data['file_surat'] = $file->storeAs('surat-masuk', $nama_file, 'public');
        }

        $suratMasuk->update($data);

        return redirect()->route('surat-masuk.index')->with('sukses', 'Surat masuk berhasil diperbarui');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        // Hapus file jika ada
        if ($suratMasuk->file_surat) {
            Storage::disk('public')->delete($suratMasuk->file_surat);
        }

        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')->with('sukses', 'Surat masuk berhasil dihapus');
    }

    public function unduhFile(SuratMasuk $suratMasuk)
    {
        if (!$suratMasuk->file_surat || !Storage::disk('public')->exists($suratMasuk->file_surat)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($suratMasuk->file_surat);
    }
}