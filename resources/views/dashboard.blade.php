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

    .card-stats {
        transition: transform 0.2s ease-in-out;
    }

    .card-stats:hover {
        transform: translateY(-5px);
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
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
    {{-- Statistik Kartu --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card card-stats text-white bg-primary shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase">Surat Masuk</h6>
                        <h2 class="fw-bold">{{ $jumlahSuratMasuk }}</h2>
                    </div>
                    <div class="icon-circle">
                        <i class="fas fa-inbox fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-stats center text-white bg-success shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase">Surat Keluar</h6>
                        <h2 class="fw-bold">{{ $jumlahSuratKeluar }}</h2>
                    </div>
                    <div class="icon-circle">
                        <i class="fas fa-paper-plane fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tambah kartu lain jika diperlukan --}}
    </div>

    {{-- Tabel Surat Terbaru --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0 text-primary fw-bold">📥 Surat Masuk Terbaru</h6>
                </div>
                <div class="card-body">
                    @if($suratMasukTerbaru->count())
                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered">
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

        <div class="card mb-4">
    <div class="card-header bg-light border-bottom">
        <h6 class="mb-0 fw-bold text-dark">📊 Grafik Surat Masuk & Keluar per Bulan</h6>
    </div>
  <div class="card-body">
    <canvas id="suratChart" height="100"></canvas>
</div>
</div> {{-- <== penutup card grafik yang belum ditutup --}}


        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0 text-success fw-bold">📤 Surat Keluar Terbaru</h6>
                </div>
                <div class="card-body">
                    @if($suratKeluarTerbaru->count())
                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor Surat</th>
                                        <th>Dikirim Melalui</th>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('suratChart').getContext('2d');
    const suratChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Surat Masuk',
                    data: {!! json_encode($dataMasuk) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Surat Keluar',
                    data: {!! json_encode($dataKeluar) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush

@endsection
