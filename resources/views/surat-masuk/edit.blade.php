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
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <!-- Kiri -->
                                    <div class="col-md-6">
                                       
                                        <div class="mb-3">
                                            <label for="nomor_surat">Nomor Surat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" name="nomor_surat" value="{{ old('nomor_surat', $suratMasuk->nomor_surat) }}" required>
                                            @error('nomor_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_surat">Tanggal Surat <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" name="tanggal_surat" value="{{ old('tanggal_surat', $suratMasuk->tanggal_surat) }}" required>
                                            @error('tanggal_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_diterima">Tanggal Diterima <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('tanggal_diterima') is-invalid @enderror" name="tanggal_diterima" value="{{ old('tanggal_diterima', $suratMasuk->tanggal_diterima) }}" required>
                                            @error('tanggal_diterima') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="nama_pengirim">Nama Pengirim <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nama_pengirim') is-invalid @enderror" name="nama_pengirim" value="{{ old('nama_pengirim', $suratMasuk->nama_pengirim) }}" required>
                                            @error('nama_pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="jabatan_pengirim">Jabatan Pengirim</label>
                                            <input type="text" class="form-control @error('jabatan_pengirim') is-invalid @enderror" name="jabatan_pengirim" value="{{ old('jabatan_pengirim', $suratMasuk->jabatan_pengirim) }}">
                                            @error('jabatan_pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="instansi_pengirim">Instansi Pengirim</label>
                                            <input type="text" class="form-control @error('instansi_pengirim') is-invalid @enderror" name="instansi_pengirim" value="{{ old('instansi_pengirim', $suratMasuk->instansi_pengirim) }}">
                                            @error('instansi_pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <!-- Kanan -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="isi_ringkas">Isi Ringkas</label>
                                            <textarea class="form-control @error('isi_ringkas') is-invalid @enderror" name="isi_ringkas" rows="3">{{ old('isi_ringkas', $suratMasuk->isi_ringkas) }}</textarea>
                                            @error('isi_ringkas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="perihal">Perihal <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('perihal') is-invalid @enderror" name="perihal" rows="2" required>{{ old('perihal', $suratMasuk->perihal) }}</textarea>
                                            @error('perihal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="kategori_id">Jenis Surat <span class="text-danger">*</span></label>
                                            <select class="form-select @error('kategori_id') is-invalid @enderror" name="kategori_id" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach($kategori as $item)
                                                    <option value="{{ $item->id }}" {{ old('kategori_id', $suratMasuk->kategori_id) == $item->id ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                            @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="sifat_surat">Sifat Surat <span class="text-danger">*</span></label>
                                            <select class="form-select @error('sifat_surat') is-invalid @enderror" name="sifat_surat" required>
                                                <option value="">-- Pilih Sifat --</option>
                                                @foreach(['biasa', 'penting', 'segera', 'rahasia'] as $sifat)
                                                    <option value="{{ $sifat }}" {{ old('sifat_surat', $suratMasuk->sifat_surat) == $sifat ? 'selected' : '' }}>{{ ucfirst($sifat) }}</option>
                                                @endforeach
                                            </select>
                                            @error('sifat_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                          <div class="mb-3">
                                            <label for="unit_disposisi" class="form-label">Unit Kerja Tujuan Disposisi <span class="text-danger">*</span></label>
                                            <select class="form-select @error('unit_disposisi') is-invalid @enderror" 
                                                id="unit_disposisi" name="unit_disposisi">
                                                <option value="">Pilih Unit Kerja</option>
                                                <option value="sekretaris" {{ old('unit_disposisi') == 'sekretaris' ? 'selected' : '' }}>
                                                    Sekretaris
                                                </option>
                                                <option value="kabid_deposit" {{ old('unit_disposisi') == 'kabid_deposit' ? 'selected' : '' }}>
                                                    Bid Deposit, Akuisisi dan Pengelolaan Bahan Pustaka
                                                </option>
                                                <option value="kabid_pengembangan" {{ old('unit_disposisi') == 'kabid_pengembangan' ? 'selected' : '' }}>
                                                    Bid Pengembangan Sumberdaya Perpustakaan
                                                </option>
                                                <option value="kabid_layanan" {{ old('unit_disposisi') == 'kabid_layanan' ? 'selected' : '' }}>
                                                    Bid Layanan, TI, Pelestarian dan Kerjasama
                                                </option>
                                                <option value="kabid_pembinaan" {{ old('unit_disposisi') == 'kabid_pembinaan' ? 'selected' : '' }}>
                                                    Bid Pembinaan dan Pengawasan Kearsipan
                                                </option>
                                                <option value="kabid_pengelolaan_arsip" {{ old('unit_disposisi') == 'kabid_pengelolaan_arsip' ? 'selected' : '' }}>
                                                    Bid Pengelolaan Arsip
                                                </option>
                                            </select>
                                            @error('unit_disposisi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                        <div class="mb-3">
                                            <label for="file_surat">Ganti File Surat</label>
                                            <input type="file" class="form-control @error('file_surat') is-invalid @enderror" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            @error('file_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file. Maks 5MB.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                                <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
 