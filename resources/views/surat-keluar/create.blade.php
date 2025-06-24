{{-- File: resources/views/surat-keluar/create.blade.php --}}

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
                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">
                                {{-- Dikirimkan melalui --}}
                                <div class="form-group">
                                    <label for="dikirimkan_melalui">Dikirimkan melalui <span class="text-danger">*</span></label>
                                    <select name="dikirimkan_melalui" id="dikirimkan_melalui" 
                                            class="form-control @error('dikirimkan_melalui') is-invalid @enderror" required>
                                        <option value="">Pilih Unit Kerja...</option>
                                        @foreach($unitKerjaOptions as $key => $value)
                                            <option value="{{ $key }}" {{ old('dikirimkan_melalui') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dikirimkan_melalui')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Jenis Naskah --}}
                                <div class="form-group">
                                    <label for="jenis_surat">Jenis Naskah <span class="text-danger">*</span></label>
                                    <select name="jenis_surat" id="jenis_surat" 
                                            class="form-control @error('jenis_surat') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis Naskah...</option>
                                        @foreach($jenisOptions as $key => $value)
                                            <option value="{{ $key }}" {{ old('jenis_surat') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Sifat Naskah --}}
                                <div class="form-group">
                                    <label for="sifat_surat">Sifat Naskah <span class="text-danger">*</span></label>
                                    <select name="sifat_surat" id="sifat_surat" 
                                            class="form-control @error('sifat_surat') is-invalid @enderror" required>
                                        <option value="">Pilih Sifat Naskah...</option>
                                        @foreach($sifatOptions as $key => $value)
                                            <option value="{{ $key }}" {{ old('sifat_surat') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sifat_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Klasifikasi --}}
                                <div class="form-group">
                                    <label for="klasifikasi">Klasifikasi <span class="text-danger">*</span></label>
                                    <select name="klasifikasi" id="klasifikasi" 
                                            class="form-control @error('klasifikasi') is-invalid @enderror" required>
                                        <option value="">Pilih Klasifikasi...</option>
                                        @foreach($klasifikasiOptions as $key => $value)
                                            <option value="{{ $key }}" {{ old('klasifikasi') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('klasifikasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nomor Naskah --}}
                                <div class="form-group">
                                    <label for="nomor_surat">Nomor Naskah</label>
                                    <div class="input-group">
                                        <input type="text" name="nomor_surat" id="nomor_surat" 
                                               class="form-control @error('nomor_surat') is-invalid @enderror"
                                               value="{{ old('nomor_surat') }}"
                                               placeholder="Kosongkan untuk generate otomatis">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-info" id="generateNomor">
                                                <i class="fas fa-magic"></i> Generate
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        INFO: Nomor diatas bersilat sementara, guna untuk penyesuaian file digital.
                                    </small>
                                    @error('nomor_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nomor Referensi --}}
                                <div class="form-group">
                                    <label for="nomor_referensi">Nomor Referensi</label>
                                    <input type="text" name="nomor_referensi" id="nomor_referensi" 
                                           class="form-control @error('nomor_referensi') is-invalid @enderror"
                                           value="{{ old('nomor_referensi') }}"
                                           placeholder="Pilih Nomor Naskah...">
                                    @error('nomor_referensi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">
                                {{-- Hal --}}
                                <div class="form-group">
                                    <label for="hal">Hal <span class="text-danger">*</span></label>
                                    <input type="text" name="hal" id="hal" 
                                           class="form-control @error('hal') is-invalid @enderror"
                                           value="{{ old('hal') }}"
                                           placeholder="Masukkan Hal..." required>
                                    @error('hal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Isi Ringkas --}}
                                <div class="form-group">
                                    <label for="isi_ringkas">Isi Ringkas <span class="text-danger">*</span></label>
                                    <textarea name="isi_ringkas" id="isi_ringkas" rows="8" 
                                              class="form-control @error('isi_ringkas') is-invalid @enderror"
                                              placeholder="Masukkan Isi Ringkas..." required>{{ old('isi_ringkas') }}</textarea>
                                    @error('isi_ringkas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tanggal Surat --}}
                                <div class="form-group">
                                    <label for="tanggal_surat">Tanggal Surat <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_surat" id="tanggal_surat" 
                                           class="form-control @error('tanggal_surat') is-invalid @enderror"
                                           value="{{ old('tanggal_surat', date('Y-m-d')) }}" required>
                                    @error('tanggal_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- File Naskah --}}
                                <div class="form-group">
                                    <label for="file_surat">File naskah <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="file_surat" id="file_surat" 
                                               class="custom-file-input @error('file_surat') is-invalid @enderror"
                                               accept=".pdf,.doc,.docx">
                                        <label class="custom-file-label" for="file_surat">Pilih file...</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Format: PDF, DOC, DOCX. Maksimal 5MB.
                                    </small>
                                    @error('file_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('surat-keluar.index') }}" class="btn btn-light">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Custom file input
        $('.custom-file-input').on('change', function() {
            let fileName = $(this)[0].files[0].name;
            $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
        });

        // Generate nomor surat otomatis
        $('#generateNomor').click(function() {
            const jenis = $('#jenis_surat').val();
            const klasifikasi = $('#klasifikasi').val();
            
            if (!jenis || !klasifikasi) {
                alert('Pilih jenis surat dan klasifikasi terlebih dahulu!');
                return;
            }

            // Simulate auto-generate (you can make AJAX call to backend)
            const date = new Date();
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const randomNum = Math.floor(Math.random() * 999) + 1;
            
            const nomorSurat = String(randomNum).padStart(3, '0') + '/' + 
                              jenis.toUpperCase() + '/' + 
                              klasifikasi.toUpperCase() + '/' + 
                              month + '/' + year;
            
            $('#nomor_surat').val(nomorSurat);
        });

        // Auto-generate when jenis or klasifikasi changes (optional)
        $('#jenis_surat, #klasifikasi').change(function() {
            if ($('#nomor_surat').val() === '') {
                // Auto generate if nomor surat is empty
                setTimeout(function() {
                    $('#generateNomor').click();
                }, 100);
            }
        });
    });
</script>
@endpush