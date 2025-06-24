@extends('layouts.app')

@section('judul', 'Tambah Surat Masuk')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Surat Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('surat-masuk.index') }}">Surat Masuk</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Form Tambah Surat Masuk</h3>
                            <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>

                        <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
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

                                {{-- Identitas Pengirim --}}
                                <div class="row mb-4">
                                    <div class="col-12">
                                       <h5 class="text-primary border-bottom pb-2 mb-3" style="text-transform: none;">
                                            <i class="fas fa-user-edit"></i> Identitas Pengirim Naskah
                                      </h5>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="nama_pengirim" class="form-label">Nama Pengirim <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nama_pengirim') is-invalid @enderror" 
                                                id="nama_pengirim" name="nama_pengirim" 
                                                value="{{ old('nama_pengirim') }}" required
                                                placeholder="Masukkan nama lengkap pengirim">
                                            @error('nama_pengirim')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="jabatan_pengirim" class="form-label">Jabatan Pengirim <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('jabatan_pengirim') is-invalid @enderror" 
                                                id="jabatan_pengirim" name="jabatan_pengirim" 
                                                value="{{ old('jabatan_pengirim') }}" required
                                                placeholder="Contoh: Kepala Dinas, Sekretaris, dll">
                                            @error('jabatan_pengirim')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="instansi_pengirim" class="form-label">Instansi Pengirim <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('instansi_pengirim') is-invalid @enderror" 
                                                id="instansi_pengirim" name="instansi_pengirim" 
                                                value="{{ old('instansi_pengirim') }}" required
                                                placeholder="Nama instansi/organisasi pengirim">
                                            @error('instansi_pengirim')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Detil Isi Naskah --}}
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="text-primary border-bottom pb-2 mb-3">
                                            <i class="fas fa-envelope"></i> Detil Isi Naskah
                                        </h5>
                                    </div>

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


                                        <div class="mb-3">
                                            <label for="nomor_surat" class="form-label">Nomor Naskah <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" 
                                                id="nomor_surat" name="nomor_surat" 
                                                value="{{ old('nomor_surat') }}" required>
                                            @error('nomor_surat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" 
                                                id="tanggal_surat" name="tanggal_surat" 
                                                value="{{ old('tanggal_surat') }}" required>
                                            @error('tanggal_surat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_diterima" class="form-label">Tanggal Diterima <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('tanggal_diterima') is-invalid @enderror" 
                                                id="tanggal_diterima" name="tanggal_diterima" 
                                                value="{{ old('tanggal_diterima', date('Y-m-d')) }}" required>
                                            @error('tanggal_diterima')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="perihal" class="form-label">Hal <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('perihal') is-invalid @enderror" 
                                                id="perihal" name="perihal" rows="3" required>{{ old('perihal') }}</textarea>
                                            @error('perihal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="isi_ringkas" class="form-label">Isi Ringkas <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('isi_ringkas') is-invalid @enderror" 
                                                id="isi_ringkas" name="isi_ringkas" rows="3" required>{{ old('isi_ringkas') }}</textarea>
                                            @error('isi_ringkas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                          <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="unit_disposisi" class="form-label">Unit Kerja Tujuan Disposisi <span class="text-danger">*</span></label>
                                            <select class="form-select @error('unit_disposisi') is-invalid @enderror" 
                                                id="unit_disposisi" name="unit_disposisi" required>
                                                <option value="">Pilih Unit Kerja</option>
                                                <option value="sekretaris" {{ old('unit_disposisi') == 'sekretaris' ? 'selected' : '' }}>
                                                    Sekretaris
                                                </option>
                                                <option value="kabid_deposit" {{ old('unit_disposisi') == 'kabid_deposit' ? 'selected' : '' }}>
                                                    Kabid Deposit, Akuisisi dan Pengelolaan Bahan Pustaka
                                                </option>
                                                <option value="kabid_pengembangan" {{ old('unit_disposisi') == 'kabid_pengembangan' ? 'selected' : '' }}>
                                                    Kabid Pengembangan Sumberdaya Perpustakaan
                                                </option>
                                                <option value="kabid_layanan" {{ old('unit_disposisi') == 'kabid_layanan' ? 'selected' : '' }}>
                                                    Kabid Layanan, TI, Pelestarian dan Kerjasama
                                                </option>
                                                <option value="kabid_pembinaan" {{ old('unit_disposisi') == 'kabid_pembinaan' ? 'selected' : '' }}>
                                                    Kabid Pembinaan dan Pengawasan Kearsipan
                                                </option>
                                                <option value="kabid_pengelolaan_arsip" {{ old('unit_disposisi') == 'kabid_pengelolaan_arsip' ? 'selected' : '' }}>
                                                    Kabid Pengelolaan Arsip
                                                </option>
                                            </select>
                                            @error('unit_disposisi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                        <div class="mb-3">
                                            <label for="file_surat" class="form-label">File Surat</label>
                                            <input type="file" class="form-control @error('file_surat') is-invalid @enderror" 
                                                id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            <small class="form-text text-muted">Format: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 5MB.</small>
                                            @error('file_surat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
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

{{-- JavaScript --}}
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
