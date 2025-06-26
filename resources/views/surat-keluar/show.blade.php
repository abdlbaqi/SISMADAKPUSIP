@extends('layouts.app')

@section('judul', 'Detail Surat Masuk')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Surat Keluar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('surat-keluar.index') }}">Surat Keluar</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Surat Keluar</h3>
                    <div class="card-tools">
                        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Nomor Agenda</dt>
                        <dd class="col-sm-9">{{ $suratKeluar->nama_penandatangan }}</dd>

                        <dt class="col-sm-3">Nomor Surat</dt>
                        <dd class="col-sm-9">{{ $suratKeluar->nomor_surat }}</dd>

                        <dt class="col-sm-3">Tanggal Surat</dt>
                        <dd class="col-sm-9">{{\Carbon\Carbon::parse($suratKeluar->tanggal_surat)->format('d/m/Y') }}</dd>

                        <dt class="col-sm-3">Jenis Surat</dt>
                        <dd class="col-sm-9">{{ $suratKeluar->kategori->nama_kategori ?? '-' }}</dd>

                        <dt class="col-sm-3">Sifat Surat</dt>
                        <dd class="col-sm-9 text-capitalize">{{ $suratKeluar->sifat_surat }}</dd>

                        <dt class="col-sm-3">Hal</dt>
                        <dd class="col-sm-9">{{ $suratKeluar->hal }}</dd>

                        <dt class="col-sm-3">Jabatan Pengirim</dt>
                        <dd class="col-sm-9">{{ $suratKeluar->klasifikasi }}</dd>

                        <dt class="col-sm-3">Instansi Pengirim</dt>
                        <dd class="col-sm-9">{{ $suratKeluar->tujuan_surat }}</dd>
                        
                        <dt class="col-sm-3">Instansi Pengirim</dt>
                        <dd class="col-sm-9">{{ $suratKeluar->dikirimkan_melalui }}</dd>

              <dt class="col-sm-3">File Surat</dt>
<dd class="col-sm-9">
    @if($suratKeluar->file_surat)
        <a href="{{ route('surat-keluar.unduh-file', $suratKeluar->id) }}" 
           class="btn btn-sm btn-primary mb-2" target="_blank">
            <i class="fas fa-file-download"></i> Unduh File
        </a>
    @else
        <span class="text-muted">Tidak ada file</span>
    @endif
</dd>

@if($suratKeluar->file_surat)
    @php
        $ext = strtolower(pathinfo($suratKeluar->file_surat, PATHINFO_EXTENSION));
        $fileUrl = asset('storage/' . $suratKeluar->file_surat);
    @endphp

    <dt class="col-sm-12 mt-4"><strong>Preview File:</strong></dt>
    <dd class="col-sm-12">
        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
            <img src="{{ $fileUrl }}" alt="File Surat" 
                 class="img-fluid" style="width: 100%; max-height: 700px; object-fit: contain;">
        @elseif($ext === 'pdf')
            <embed src="{{ $fileUrl }}" type="application/pdf" 
                   style="width: 100%; height: 700px;" />
        @else
            <p class="text-muted">File tidak dapat ditampilkan langsung.</p>
        @endif
    </dd>
@endif


                    </dl>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
