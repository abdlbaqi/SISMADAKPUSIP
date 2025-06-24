@extends('layouts.app')

@section('judul', 'Beranda')

@push('styles')
<style>
    .dashboard-background {
        background-image: url('{{ asset('images/logo_watermark.png') }}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 50%;
        background-attachment: fixed;
        padding: 20px;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.95); /* semi transparan */
        backdrop-filter: blur(2px);
    }

    .card-title {
        font-weight: bold;
    }

    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="dashboard-background">
    <div class="row mb-4">
        {{-- Kartu Statistik --}}
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Surat Masuk</h5>
                        <h2 class="mb-0">{{ $jumlahSuratMasuk }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-inbox fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Surat Keluar</h5>
                        <h2 class="mb-0">{{ $jumlahSuratKeluar }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-paper-plane fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tambahkan lebih banyak kartu jika diperlukan --}}
    </div>

    {{-- Daftar Surat Terbaru --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">Surat Masuk Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($suratMasukTerbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor Surat</th>
                                        <th>Pengirim</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suratMasukTerbaru as $surat)
                                        <tr>
                                            <td>{{ $surat->nomor_surat }}</td>
                                            <td>{{ $surat->nama_pengirim }}</td>
                                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada surat masuk terbaru.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">Surat Keluar Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($suratKeluarTerbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor Surat</th>
                                        <th>Dikirimkan Melalui</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suratKeluarTerbaru as $surat)
                                        <tr>
                                            <td>{{ $surat->nomor_surat }}</td>
                                            <td>{{ $surat->dikirimkan_melalui }}</td>
                                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_kirim)->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada surat keluar terbaru.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
