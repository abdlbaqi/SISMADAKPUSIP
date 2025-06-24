@extends('layouts.app')

@section('judul', 'Detail Surat Masuk')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Surat Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('surat-masuk.index') }}">Surat Masuk</a></li>
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
                    <h3 class="card-title">Informasi Surat Masuk</h3>
                    <div class="card-tools">
                        <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Nomor Agenda</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->nomor_agenda }}</dd>

                        <dt class="col-sm-3">Nomor Surat</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->nomor_surat }}</dd>

                        <dt class="col-sm-3">Tanggal Surat</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->tanggal_surat->format('d/m/Y') }}</dd>

                        <dt class="col-sm-3">Tanggal Diterima</dt>
                         <dd class="col-sm-9">{{$suratMasuk->tanggal_diterima->format('d/m/Y') }}</dd>

                        <dt class="col-sm-3">Jenis Surat</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->kategori->nama_kategori ?? '-' }}</dd>

                        <dt class="col-sm-3">Sifat Surat</dt>
                        <dd class="col-sm-9 text-capitalize">{{ $suratMasuk->sifat_surat }}</dd>

                        <dt class="col-sm-3">Hal</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->perihal }}</dd>

                        <dt class="col-sm-3">Isi Ringkas</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->isi_ringkas ?? '-' }}</dd>

                        <dt class="col-sm-3">Nama Pengirim</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->nama_pengirim }}</dd>

                        <dt class="col-sm-3">Jabatan Pengirim</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->jabatan_pengirim }}</dd>

                        <dt class="col-sm-3">Instansi Pengirim</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->instansi_pengirim }}</dd>
                        
                        <dt class="col-sm-3">Instansi Pengirim</dt>
                        <dd class="col-sm-9">{{ $suratMasuk->instansi_pengirim }}</dd>

                        <dt class="col-sm-3">File Surat</dt>
                        <dd class="col-sm-9">
                            @if($suratMasuk->file_surat)
                                <a href="{{ route('surat-masuk.unduh-file', $suratMasuk->id) }}" 
                                   class="btn btn-sm btn-primary" target="_blank">
                                    <i class="fas fa-file-download"></i> Unduh File
                                </a>
                            @else
                                <span class="text-muted">Tidak ada file</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
