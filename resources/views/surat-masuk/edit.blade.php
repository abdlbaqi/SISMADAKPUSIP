@extends('layouts.app')

@section('judul', 'Edit Surat Masuk')

@section('konten')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form Edit Surat Masuk</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('surat-masuk.update', $surat_masuk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomor_agenda" class="form-label">Nomor Agenda <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor_agenda') is-invalid @enderror" 
                                   id="nomor_agenda" name="nomor_agenda" value="{{ old('nomor_agenda', $surat_masuk->nomor_agenda) }}" readonly>
                            @error('nomor_agenda')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" 
                                   id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $surat_masuk->nomor_surat) }}" required>
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" 
                                   id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $surat_masuk->tanggal_surat) }}" required>
                            @error('tanggal_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_diterima" class="form-label">Tanggal Diterima <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_diterima') is-invalid @enderror" 
                                   id="tanggal_diterima" name="tanggal_diterima" value="{{ old('tanggal_diterima', $surat_masuk->tanggal_diterima) }}" required>
                            @error('tanggal_diterima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="pengirim" class="form-label">Pengirim <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('pengirim') is-invalid @enderror" 
                               id="pengirim" name="pengirim" value="{{ old('pengirim', $surat_masuk->pengirim) }}" required>
                        @error('pengirim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('perihal') is-invalid @enderror" 
                                  id="perihal" name="perihal" rows="3" required>{{ old('perihal', $surat_masuk->perihal) }}</textarea>
                        @error('perihal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori_id" class="form-label">Kategori Surat <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                    id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}" {{ old('kategori_id', $surat_masuk->kategori_id) == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="prioritas" class="form-label">Prioritas</label>
                            <select class="form-select @error('prioritas') is-invalid @enderror" 
                                    id="prioritas" name="prioritas">
                                <option value="biasa" {{ old('prioritas', $surat_masuk->prioritas) == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                <option value="penting" {{ old('prioritas', $surat_masuk->prioritas) == 'penting' ? 'selected' : '' }}>Penting</option>
                                <option value="segera" {{ old('prioritas', $surat_masuk->prioritas) == 'segera' ? 'selected' : '' }}>Segera</option>
                                <option value="rahasia" {{ old('prioritas', $surat_masuk->prioritas) == 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                            </select>
                            @error('prioritas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status">
                            <option value="diterima" {{ old('status', $surat_masuk->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="diproses" {{ old('status', $surat_masuk->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ old('status', $surat_masuk->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="file_surat" class="form-label">File Surat</label>
                        @if($surat_masuk->file_surat)
                            <div class="mb-2">
                                <small class="text-muted">File saat ini: 
                                    <a href="{{ route('surat-masuk.unduh', $surat_masuk->id) }}" target="_blank">
                                        {{ basename($surat_masuk->file_surat) }}
                                    </a>
                                </small>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('file_surat') is-invalid @enderror" 
                               id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah file. File yang diizinkan: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 5MB.</div>
                        @error('file_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $surat_masuk->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Perbarui Surat Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Informasi Surat</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Dibuat Pada:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($surat_masuk->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($surat_masuk->updated_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($surat_masuk->pengguna)
                    <tr>
                        <td><strong>Dibuat Oleh:</strong></td>
                        <td>{{ $surat_masuk->pengguna->nama }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
