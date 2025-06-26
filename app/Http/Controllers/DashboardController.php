<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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

    $suratMasukTerbaru = SuratMasuk::orderBy('created_at', 'desc')->take(5)->get();
    $suratKeluarTerbaru = SuratKeluar::orderBy('created_at', 'desc')->take(5)->get();

    // ✅ Definisikan $months terlebih dahulu
    $months = collect(range(0, 5))->map(function ($i) {
        return Carbon::now()->subMonths($i)->format('Y-m');
    })->reverse();

    // ✅ Baru gunakan $months untuk label dan data
    $labels = $months->map(function ($month) {
        return Carbon::createFromFormat('Y-m', $month)->translatedFormat('M Y');
    })->values()->all();

    $dataMasuk = $months->map(function ($month) {
        return SuratMasuk::whereRaw("DATE_FORMAT(tanggal_diterima, '%Y-%m') = ?", [$month])->count();
    })->values()->all();

    $dataKeluar = $months->map(function ($month) {
        return SuratKeluar::whereRaw("DATE_FORMAT(tanggal_surat, '%Y-%m') = ?", [$month])->count();
    })->values()->all();

    return view('dashboard', [
        'jumlahSuratMasuk' => $jumlahSuratMasuk,
        'jumlahSuratKeluar' => $jumlahSuratKeluar,
        'suratMasukTerbaru' => $suratMasukTerbaru,
        'suratKeluarTerbaru' => $suratKeluarTerbaru,
        'labels' => $labels,
        'dataMasuk' => $dataMasuk,
        'dataKeluar' => $dataKeluar,
    ]);
}
}