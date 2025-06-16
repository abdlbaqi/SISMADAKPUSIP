<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    public function index(Request $request)
    {
        $query = Disposisi::with(['suratMasuk', 'pengirim', 'penerima']);

        // Filter berdasarkan peran pengguna
        if (auth()->user()->peran !== 'admin') {
            $query->where(function($q) {
                $q->where('dari_pengguna_id', auth()->id())
                  ->orWhere('kepada_pengguna_id', auth()->id());
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        $disposisi = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('disposisi.index', compact('disposisi'));
    }

    public function create(Request $request)
    {
        $surat_masuk = null;
        if ($request->filled('surat_masuk_id')) {
            $surat_masuk = SuratMasuk::findOrFail($request->surat_masuk_id);
        }

        $pengguna = Pengguna::where('id', '!=', auth()->id())->get();

        return view('disposisi.create', compact('surat_masuk', 'pengguna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuk,id',
            'kepada_pengguna_id' => 'required|exists:pengguna,id',
            'instruksi' => 'required',
            'batas_waktu' => 'nullable|date|after:today',
            'prioritas' => 'required|in:rendah,sedang,tinggi,sangat_tinggi',
        ]);

        $data = $request->all();
        $data['dari_pengguna_id'] = auth()->id();
        $data['status'] = 'menunggu';

        Disposisi::create($data);

        // Update status surat masuk
        SuratMasuk::find($request->surat_masuk_id)->update(['status' => 'diproses']);

        return redirect()->route('disposisi.index')->with('sukses', 'Disposisi berhasil dibuat');
    }

    public function show(Disposisi $disposisi)
    {
        $disposisi->load(['suratMasuk.kategori', 'pengirim', 'penerima']);
        return view('disposisi.show', compact('disposisi'));
    }

    public function terima(Disposisi $disposisi)
    {
        if ($disposisi->kepada_pengguna_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak menerima disposisi ini');
        }

        $disposisi->update([
            'status' => 'diterima',
            'tanggal_diterima' => now()
        ]);

        return redirect()->back()->with('sukses', 'Disposisi berhasil diterima');
    }

    public function proses(Request $request, Disposisi $disposisi)
    {
        if ($disposisi->kepada_pengguna_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak memproses disposisi ini');
        }

        $request->validate([
            'catatan_penerima' => 'required',
        ]);

        $disposisi->update([
            'status' => 'diproses',
            'catatan_penerima' => $request->catatan_penerima
        ]);

        return redirect()->back()->with('sukses', 'Disposisi sedang diproses');
    }

    public function selesai(Request $request, Disposisi $disposisi)
    {
        if ($disposisi->kepada_pengguna_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak menyelesaikan disposisi ini');
        }

        $request->validate([
            'catatan_penerima' => 'required',
        ]);

        $disposisi->update([
            'status' => 'selesai',
            'catatan_penerima' => $request->catatan_penerima,
            'tanggal_selesai' => now()
        ]);

        // Cek apakah semua disposisi untuk surat ini sudah selesai
        $disposisi_belum_selesai = Disposisi::where('surat_masuk_id', $disposisi->surat_masuk_id)
                                           ->where('status', '!=', 'selesai')
                                           ->count();

        if ($disposisi_belum_selesai === 0) {
            SuratMasuk::find($disposisi->surat_masuk_id)->update(['status' => 'selesai']);
        }

        return redirect()->back()->with('sukses', 'Disposisi berhasil diselesaikan');
    }
}