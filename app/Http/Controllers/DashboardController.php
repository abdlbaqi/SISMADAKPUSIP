<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use App\Models\Arsip;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $statistik = [
            'surat_masuk_hari_ini' => SuratMasuk::whereDate('tanggal_diterima', today())->count(),
            'surat_keluar_hari_ini' => SuratKeluar::whereDate('tanggal_kirim', today())->count(),
            'total_surat_masuk' => SuratMasuk::count(),
            'total_surat_keluar' => SuratKeluar::count(),
            'surat_belum_dibaca' => SuratMasuk::where('status', 'belum_dibaca')->count(),
            'disposisi_menunggu' => Disposisi::where('status', 'menunggu')->count(),
            'total_arsip' => Arsip::count(),
        ];

        $surat_masuk_terbaru = SuratMasuk::with(['kategori', 'pembuat'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $surat_keluar_terbaru = SuratKeluar::with(['kategori', 'pembuat'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $disposisi_menunggu = Disposisi::with(['suratMasuk', 'pengirim'])
            ->where('kepada_pengguna_id', auth()->id())
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('statistik', 'surat_masuk_terbaru', 'surat_keluar_terbaru', 'disposisi_menunggu'));
    }
}
