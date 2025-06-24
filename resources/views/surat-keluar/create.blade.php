@extends('layouts.app')

@section('title', 'Tambah Surat Keluar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Surat Keluar</h3>
                    <div class="card-tools">
                        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Jenis Surat -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                                    <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis Surat</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sifat Surat -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sifat_surat" class="form-label">Sifat Surat <span class="text-danger">*</span></label>
                                    <select class="form-select @error('sifat_surat') is-invalid @enderror" 
                                        id="sifat_surat" name="sifat_surat" required>
                                        <option value="">Pilih Sifat Surat</option>
                                        <option value="biasa" {{ old('sifat_surat') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                        <option value="penting" {{ old('sifat_surat') == 'penting' ? 'selected' : '' }}>Penting</option>
                                        <option value="segera" {{ old('sifat_surat') == 'segera' ? 'selected' : '' }}>Segera</option>
                                        <option value="rahasia" {{ old('sifat_surat') == 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                                    </select>
                                    @error('sifat_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tanggal Surat -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_surat">Tanggal Surat <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_surat') is-invalid @enderror" 
                                           id="tanggal_surat" 
                                           name="tanggal_surat" 
                                           value="{{ old('tanggal_surat') }}" 
                                           required>
                                    @error('tanggal_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nomor Surat -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_surat" class="form-label">Nomor Naskah <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" 
                                        id="nomor_surat" name="nomor_surat" 
                                        value="{{ old('nomor_surat') }}" required>
                                    @error('nomor_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Klasifikasi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="klasifikasi">Klasifikasi <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('klasifikasi') is-invalid @enderror" 
                                           id="klasifikasi" 
                                           name="klasifikasi" 
                                           value="{{ old('klasifikasi') }}" 
                                           placeholder="Contoh: 000.01"
                                           required>
                                    @error('klasifikasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dikirimkan Melalui -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dikirimkan_melalui">Dikirimkan Melalui <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('dikirimkan_melalui') is-invalid @enderror" 
                                           id="dikirimkan_melalui" 
                                           name="dikirimkan_melalui" 
                                           value="{{ old('dikirimkan_melalui') }}"
                                           required>
                                    @error('dikirimkan_melalui')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Hal -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hal" class="form-label">Hal <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('hal') is-invalid @enderror" 
                                        id="hal" name="hal" rows="3" required>{{ old('hal') }}</textarea>
                                    @error('hal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tujuan Surat -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tujuan_surat">Tujuan Surat <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('tujuan_surat') is-invalid @enderror" 
                                              id="tujuan_surat" 
                                              name="tujuan_surat" 
                                              rows="3" 
                                              placeholder="Masukkan tujuan surat"
                                              required>{{ old('tujuan_surat') }}</textarea>
                                    @error('tujuan_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Nama Penandatangan -->
                        <div class="form-group">
                            <label for="nama_penandatangan">Nama Penandatangan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_penandatangan') is-invalid @enderror" 
                                   id="nama_penandatangan" 
                                   name="nama_penandatangan" 
                                   value="{{ old('nama_penandatangan') }}" 
                                   placeholder="Masukkan nama penandatangan"
                                   required>
                            @error('nama_penandatangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="form-group">
                            <label for="file_surat">File Surat</label>
                            <div class="custom-file">
                                <input type="file" 
                                       class="custom-file-input @error('file_surat') is-invalid @enderror" 
                                       id="file_surat" 
                                       name="file_surat"
                                       accept=".pdf,.doc,.docx">
                                <label class="custom-file-label" for="file_surat">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">
                                Format yang diizinkan: PDF, DOC, DOCX. Maksimal ukuran: 5MB
                            </small>
                            @error('file_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Custom file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush