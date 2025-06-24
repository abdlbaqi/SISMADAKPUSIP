<?php
// File: app/Http/Controllers/SuratKeluarController.php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratKeluar::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter berdasarkan jenis surat
        if ($request->filled('jenis')) {
            $query->byJenis($request->jenis);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tahun')) {
            $query->byPeriod($request->tahun, $request->bulan);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('hal', 'like', "%{$search}%")
                  ->orWhere('isi_ringkas', 'like', "%{$search}%");
            });
        }

        $suratKeluar = $query->orderBy('tanggal_surat', 'desc')
                           ->paginate(10)
                           ->withQueryString();

        return view('surat-keluar.index', compact('suratKeluar'));
    }

    public function create()
    {
        // Data untuk dropdown
        $jenisOptions = [
            'undangan' => 'Undangan',
            'pemberitahuan' => 'Pemberitahuan',
            'permohonan' => 'Permohonan',
            'laporan' => 'Laporan',
            'keputusan' => 'Keputusan',
            'instruksi' => 'Instruksi',
            'lainnya' => 'Lainnya'
        ];

        $sifatOptions = [
            'biasa' => 'Biasa',
            'penting' => 'Penting',
            'rahasia' => 'Rahasia',
            'segera' => 'Segera'
        ];

        $klasifikasiOptions = [
            'umum' => 'Umum',
            'kepegawaian' => 'Kepegawaian',
            'keuangan' => 'Keuangan',
            'program' => 'Program',
            'perlengkapan' => 'Perlengkapan',
            'hukum' => 'Hukum'
        ];

        $unitKerjaOptions = [
            'kantor_pusat' => 'DINAS PERPUSTAKAAN DAN KEARSIPAN PROVINSI LAMPUNG',
        ];

        return view('surat-keluar.create', compact(
            'jenisOptions', 
            'sifatOptions', 
            'klasifikasiOptions', 
            'unitKerjaOptions'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_surat' => 'required|date',
            'jenis_surat' => 'required|string',
            'sifat_surat' => 'required|string',
            'klasifikasi' => 'required|string',
            'hal' => 'required|string|max:500',
            'isi_ringkas' => 'required|string',
            'dikirimkan_melalui' => 'required|string',
            'nomor_referensi' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            // Generate nomor surat otomatis
            $nomorSurat = $request->nomor_surat ?: SuratKeluar::generateNomorSurat(
                $request->jenis_surat, 
                $request->klasifikasi
            );

            $data = $request->except(['file_surat']);
            $data['nomor_surat'] = $nomorSurat;

            // Handle file upload
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');
                $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                
                $filePath = $file->storeAs('surat-keluar', $fileName, 'public');
                $data['file_surat'] = $filePath;
            }

            SuratKeluar::create($data);

            return redirect()->route('surat-keluar.index')
                           ->with('success', 'Surat keluar berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                           ->withInput();
        }
    }

    public function show(SuratKeluar $suratKeluar)
    {
        return view('surat-keluar.show', compact('suratKeluar'));
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        // Data untuk dropdown (sama seperti create)
        $jenisOptions = [
            'undangan' => 'Undangan',
            'pemberitahuan' => 'Pemberitahuan',
            'permohonan' => 'Permohonan',
            'laporan' => 'Laporan',
            'keputusan' => 'Keputusan',
            'instruksi' => 'Instruksi',
            'lainnya' => 'Lainnya'
        ];

        $sifatOptions = [
            'biasa' => 'Biasa',
            'penting' => 'Penting',
            'rahasia' => 'Rahasia',
            'segera' => 'Segera'
        ];

        $klasifikasiOptions = [
            'umum' => 'Umum',
            'kepegawaian' => 'Kepegawaian',
            'keuangan' => 'Keuangan',
            'program' => 'Program',
            'perlengkapan' => 'Perlengkapan',
            'hukum' => 'Hukum'
        ];

        $unitKerjaOptions = [
            'kantor_pusat' => 'Kantor Pusat',
            'cabang_jakarta' => 'Cabang Jakarta',
            'cabang_surabaya' => 'Cabang Surabaya',
            'cabang_medan' => 'Cabang Medan',
            'cabang_makassar' => 'Cabang Makassar'
        ];

        return view('surat-keluar.edit', compact(
            'suratKeluar',
            'jenisOptions', 
            'sifatOptions', 
            'klasifikasiOptions', 
            'unitKerjaOptions'
        ));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|unique:surat_keluar,nomor_surat,' . $suratKeluar->id,
            'tanggal_surat' => 'required|date',
            'jenis_surat' => 'required|string',
            'sifat_surat' => 'required|string',
            'klasifikasi' => 'required|string',
            'hal' => 'required|string|max:500',
            'isi_ringkas' => 'required|string',
            'dikirimkan_melalui' => 'required|string',
            'nomor_referensi' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $data = $request->except(['file_surat']);

            // Handle file upload
            if ($request->hasFile('file_surat')) {
                // Hapus file lama jika ada
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

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                           ->withInput();
        }
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        try {
            // Hapus file jika ada
            if ($suratKeluar->file_surat && Storage::disk('public')->exists($suratKeluar->file_surat)) {
                Storage::disk('public')->delete($suratKeluar->file_surat);
            }

            $suratKeluar->delete();

            return redirect()->route('surat-keluar.index')
                           ->with('success', 'Surat keluar berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function downloadFile(SuratKeluar $suratKeluar)
    {
        if (!$suratKeluar->file_surat || !Storage::disk('public')->exists($suratKeluar->file_surat)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        return Storage::disk('public')->download($suratKeluar->file_surat);
    }

    public function updateStatus(Request $request, SuratKeluar $suratKeluar)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:draft,terkirim,arsip'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Status tidak valid'], 400);
        }

        $suratKeluar->update(['status' => $request->status]);

        return response()->json(['success' => 'Status berhasil diperbarui']);
    }
}