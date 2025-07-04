@extends('layouts.app')

@section('title', 'Tambah Kategori Surat')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Tambah Kategori Surat
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('kategori-surat.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="kode_kategori" class="form-label">
                                Kode Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('kode_kategori') is-invalid @enderror" 
                                   id="kode_kategori" 
                                   name="kode_kategori" 
                                   value="{{ old('kode_kategori') }}"
                                   placeholder="Contoh: SK001"
                                   maxlength="10"
                                   required>
                            @error('kode_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 10 karakter</div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   id="nama_kategori" 
                                   name="nama_kategori" 
                                   value="{{ old('nama_kategori') }}"
                                   placeholder="Contoh: Surat Keputusan"
                                   maxlength="255"
                                   required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kategori-surat.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
