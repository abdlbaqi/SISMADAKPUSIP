<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function suratMasuk(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesai = $request->tanggal_selesai ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $suratMasuk = SuratMasuk::whereBetween('tanggal_diterima', [$tanggalMulai, $tanggalSelesai])
            ->with(['kategoriSurat'])
            ->orderBy('tanggal_diterima', 'desc')
            ->get();

        return view('laporan.surat-masuk', compact('suratMasuk', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function suratKeluar(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesai = $request->tanggal_selesai ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $suratKeluar = SuratKeluar::whereBetween('tanggal_surat', [$tanggalMulai, $tanggalSelesai])
            ->with(['kategoriSurat', 'pengguna'])
            ->orderBy('tanggal_surat', 'desc')
            ->get();

        return view('laporan.surat-keluar', compact('suratKeluar', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function disposisi(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesai = $request->tanggal_selesai ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $disposisi = Disposisi::whereBetween('tanggal_disposisi', [$tanggalMulai, $tanggalSelesai])
            ->with(['suratMasuk', 'pengguna'])
            ->orderBy('tanggal_disposisi', 'desc')
            ->get();

        return view('laporan.disposisi', compact('disposisi', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function arsip(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesai = $request->tanggal_selesai ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $arsip = Arsip::whereBetween('tanggal_arsip', [$tanggalMulai, $tanggalSelesai])
            ->with(['kategoriSurat'])
            ->orderBy('tanggal_arsip', 'desc')
            ->get();

        return view('laporan.arsip', compact('arsip', 'tanggalMulai', 'tanggalSelesai'));
    }
}

// app/Http/Middleware/CekPeran.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekPeran
{
    public function handle(Request $request, Closure $next, $peran)
    {
        if (!Auth::check() || Auth::user()->peran !== $peran) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
