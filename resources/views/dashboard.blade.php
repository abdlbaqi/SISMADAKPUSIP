@extends('layouts.app')

@section('judul', 'Beranda')

@section('content')
<div class="row">
    {{-- Kartu Statistik --}}
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
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

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
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

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h5 class="card-title">Disposisi</h5>
                    <h2 class="mb-0">{{ $jumlahDisposisi }}</h2>
                </div>
                <div class="align-self-center">
                    <i class="fas fa-share-alt fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

{{-- Daftar Surat Terbaru --}}
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Surat Masuk Terbaru</h5>
            </div>
            <div class="card-body">
                @if($suratMasukTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
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
                                    <td>{{ $surat->pengirim }}</td>
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

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Surat Keluar Terbaru</h5>
            </div>
            <div class="card-body">
                @if($suratKeluarTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor Surat</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suratKeluarTerbaru as $surat)
                                <tr>
                                    <td>{{ $surat->nomor_surat }}</td>
                                    <td>{{ $surat->tujuan }}</td>
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
@endsection
