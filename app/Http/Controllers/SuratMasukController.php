<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\KategoriSurat;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratMasuk::with(['kategori', 'penerima', 'pembuatSurat']);
        
        // Filter berdasarkan pencarian
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('nomor_surat', 'like', "%{$cari}%")
                  ->orWhere('asal_surat', 'like', "%{$cari}%")
                  ->orWhere('perihal', 'like', "%{$cari}%")
                  ->orWhere('nomor_agenda', 'like', "%{$cari}%");
            });
        }
        
        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan sifat surat
        if ($request->filled('sifat_surat')) {
            $query->where('sifat_surat', $request->sifat_surat);
        }
        
        // Filter berdasarkan rentang tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_diterima', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_diterima', '<=', $request->tanggal_selesai);
        }
        
        // Urutkan berdasarkan tanggal diterima terbaru
        $query->orderBy('tanggal_diterima', 'desc');
        
        $surat_masuk = $query->paginate(10);
        $kategori = KategoriSurat::all();
        
        return view('surat-masuk.index', compact('surat_masuk', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriSurat::all();
        $penerima = Pengguna::all();
        
        // Generate nomor agenda otomatis
        $tahun = date('Y');
        $bulan = date('m');
        $terakhir = SuratMasuk::whereYear('created_at', $tahun)
                             ->whereMonth('created_at', $bulan)
                             ->count();
        $nomor_agenda_otomatis = sprintf('%03d/SM/%s/%s', $terakhir + 1, $bulan, $tahun);
        
        return view('surat-masuk.create', compact('kategori', 'penerima', 'nomor_agenda_otomatis'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_agenda' => 'required|string|unique:surat_masuk,nomor_agenda',
            'nomor_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'sifat_surat' => 'required|in:biasa,penting,segera,rahasia',
            'penerima_id' => 'nullable|exists:pengguna,id',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB
        ]);

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('surat-masuk', $filename, 'public');
            $validatedData['file_surat'] = $filepath;
        }

        // Set default values
        $validatedData['status'] = 'belum_dibaca';
        $validatedData['dibuat_oleh'] = Auth::id();

        SuratMasuk::create($validatedData);

        return redirect()->route('surat-masuk.index')
                        ->with('sukses', 'Surat masuk berhasil ditambahkan');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load(['kategori', 'penerima', 'pembuatSurat']);
        
        // Update status menjadi sudah dibaca jika masih belum dibaca
        if ($suratMasuk->status === 'belum_dibaca') {
            $suratMasuk->update(['status' => 'sudah_dibaca']);
        }
        
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        $kategori = KategoriSurat::all();
        $penerima = Pengguna::all();
        
        return view('surat-masuk.edit', compact('suratMasuk', 'kategori', 'penerima'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validatedData = $request->validate([
            'nomor_agenda' => 'required|string|unique:surat_masuk,nomor_agenda,' . $suratMasuk->id,
            'nomor_surat' => 'required|string|max:255',
            'asal_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'sifat_surat' => 'required|in:biasa,penting,segera,rahasia',
            'lampiran' => 'nullable|string|max:255',
            'isi_ringkas' => 'nullable|string',
            'status' => 'required|in:belum_dibaca,sudah_dibaca,diproses,selesai',
            'penerima_id' => 'nullable|exists:pengguna,id',
            'catatan' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB
        ]);

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            // Hapus file lama jika ada
            if ($suratMasuk->file_surat && Storage::disk('public')->exists($suratMasuk->file_surat)) {
                Storage::disk('public')->delete($suratMasuk->file_surat);
            }
            
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('surat-masuk', $filename, 'public');
            $validatedData['file_surat'] = $filepath;
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
        if (!$suratMasuk->file_surat || !Storage::disk('public')->exists($suratMasuk->file_surat)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($suratMasuk->file_surat);
    }

    public function updateStatus(Request $request, SuratMasuk $suratMasuk)
    {
        $request->validate([
            'status' => 'required|in:belum_dibaca,sudah_dibaca,diproses,selesai'
        ]);

        $suratMasuk->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('sukses', 'Status surat berhasil diperbarui');
    }

    public function laporan(Request $request)
    {
        $query = SuratMasuk::with(['kategori', 'penerima', 'pembuatSurat']);
        
        // Filter untuk laporan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_diterima', $request->bulan);
        }
        
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_diterima', $request->tahun);
        }
        
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $surat_masuk = $query->orderBy('tanggal_diterima', 'desc')->get();
        $kategori = KategoriSurat::all();
        
        // Statistik
        $total_surat = $surat_masuk->count();
        $belum_dibaca = $surat_masuk->where('status', 'belum_dibaca')->count();
        $sudah_dibaca = $surat_masuk->where('status', 'sudah_dibaca')->count();
        $diproses = $surat_masuk->where('status', 'diproses')->count();
        $selesai = $surat_masuk->where('status', 'selesai')->count();
        
        $statistik = [
            'total_surat' => $total_surat,
            'belum_dibaca' => $belum_dibaca,
            'sudah_dibaca' => $sudah_dibaca,
            'diproses' => $diproses,
            'selesai' => $selesai
        ];
        
        return view('surat-masuk.laporan', compact('surat_masuk', 'kategori', 'statistik'));
    }
}