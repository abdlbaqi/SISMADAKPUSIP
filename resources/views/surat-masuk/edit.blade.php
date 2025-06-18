@extends('layouts.app')

@section('judul', 'Edit Surat Masuk')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Surat Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('surat-masuk.index') }}">Surat Masuk</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Edit Surat Masuk</h3>
                            <div class="card-tools">
                                <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('surat-masuk.update', $suratMasuk->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <h5><i class="icon fas fa-ban"></i> Terjadi Kesalahan!</h5>
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nomor_agenda" class="form-label">Nomor Agenda</label>
                                            <input type="text" class="form-control" 
                                                   id="nomor_agenda" name="nomor_agenda" 
                                                   value="{{ $suratMasuk->nomor_agenda }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" 
                                                   id="nomor_surat" name="nomor_surat" 
                                                   value="{{ old('nomor_surat', $suratMasuk->nomor_surat) }}" required>
                                            @error('nomor_surat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" 
                                                   id="tanggal_surat" name="tanggal_surat" 
                                                   value="{{ old('tanggal_surat', $suratMasuk->tanggal_surat) }}" required>
                                            @error('tanggal_surat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_diterima" class="form-label">Tanggal Diterima <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('tanggal_diterima') is-invalid @enderror" 
                                                   id="tanggal_diterima" name="tanggal_diterima" 
                                                   value="{{ old('tanggal_diterima', $suratMasuk->tanggal_diterima) }}" required>
                                            @error('tanggal_diterima')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="kategori_id" class="form-label">Kategori Surat <span class="text-danger">*</span></label>
                                            <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                                <option value="">Pilih Kategori</option>
                                                @foreach ($kategori as $item)
                                                    <option value="{{ $item->id }}" {{ old('kategori_id', $suratMasuk->kategori_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kategori_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('perihal') is-invalid @enderror" 
                                                      id="perihal" name="perihal" rows="3" required>{{ old('perihal', $suratMasuk->perihal) }}</textarea>
                                            @error('perihal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="sifat_surat" class="form-label">Sifat Surat <span class="text-danger">*</span></label>
                                            <select class="form-select @error('sifat_surat') is-invalid @enderror" 
                                                    id="sifat_surat" name="sifat_surat" required>
                                                <option value="">Pilih Sifat Surat</option>
                                                @foreach(['biasa', 'penting', 'segera', 'rahasia'] as $sifat)
                                                    <option value="{{ $sifat }}" {{ old('sifat_surat', $suratMasuk->sifat_surat) == $sifat ? 'selected' : '' }}>
                                                        {{ ucfirst($sifat) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('sifat_surat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="penerima_id" class="form-label">Penerima <span class="text-danger">*</span></label>
                                            <select class="form-select @error('penerima_id') is-invalid @enderror" 
                                                    id="penerima_id" name="penerima_id" required>
                                                <option value="">Pilih Penerima</option>
                                                @foreach($penerima as $user)
                                                    <option value="{{ $user->id }}" {{ old('penerima_id', $suratMasuk->penerima_id) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->nama }} - {{ $user->jabatan ?? $user->email }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('penerima_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                                      id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $suratMasuk->keterangan) }}</textarea>
                                            @error('keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="file_surat" class="form-label">Ganti File Surat</label>
                                            <input type="file" class="form-control @error('file_surat') is-invalid @enderror" 
                                                   id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            @error('file_surat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Kosongkan jika tidak ingin mengubah file. Format: PDF, DOC, JPG. Maksimal 5MB.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update
                                </button>
                                <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.getElementById('file_surat').addEventListener('change', function(e) {
    var fileName = e.target.files[0] ? e.target.files[0].name : 'Tidak ada file yang dipilih';
    var fileInfo = document.createElement('small');
    fileInfo.className = 'form-text text-info';
    fileInfo.textContent = 'File terpilih: ' + fileName;

    var existingInfo = e.target.parentNode.querySelector('.text-info');
    if (existingInfo) {
        existingInfo.remove();
    }
    e.target.parentNode.appendChild(fileInfo);
});
</script>
@endsection
