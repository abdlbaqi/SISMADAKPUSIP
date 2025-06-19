<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use App\Models\Arsip;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSuratMasuk = SuratMasuk::count();
        $jumlahSuratKeluar = SuratKeluar::count();
        $jumlahDisposisi = Disposisi::count();

        $suratMasukTerbaru = SuratMasuk::orderBy('created_at', 'desc')->take(5)->get();
        $suratKeluarTerbaru = SuratKeluar::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', [
            'jumlahSuratMasuk' => $jumlahSuratMasuk,
            'jumlahSuratKeluar' => $jumlahSuratKeluar,
            'jumlahDisposisi' => $jumlahDisposisi,
            'suratMasukTerbaru' => $suratMasukTerbaru,
            'suratKeluarTerbaru' => $suratKeluarTerbaru,
        ]);
    }
}
