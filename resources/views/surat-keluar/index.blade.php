{{-- File: resources/views/surat-keluar/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Daftar Surat Keluar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Surat Keluar</h3>
                    <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Surat Keluar
                    </a>
                </div>

                <div class="card-body">
                    {{-- Filter Section --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <form method="GET" action="{{ route('surat-keluar.index') }}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="">Semua Status</option>
                                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="terkirim" {{ request('status') == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                                            <option value="arsip" {{ request('status') == 'arsip' ? 'selected' : '' }}>Arsip</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="jenis" class="form-control form-control-sm">
                                            <option value="">Semua Jenis</option>
                                            <option value="undangan" {{ request('jenis') == 'undangan' ? 'selected' : '' }}>Undangan</option>
                                            <option value="pemberitahuan" {{ request('jenis') == 'pemberitahuan' ? 'selected' : '' }}>Pemberitahuan</option>
                                            <option value="permohonan" {{ request('jenis') == 'permohonan' ? 'selected' : '' }}>Permohonan</option>
                                            <option value="laporan" {{ request('jenis') == 'laporan' ? 'selected' : '' }}>Laporan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="tahun" class="form-control form-control-sm">
                                            <option value="">Semua Tahun</option>
                                            @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control form-control-sm" 
                                               placeholder="Cari nomor surat, hal, atau isi..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-sm btn-info">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('surat-keluar.index') }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-times"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nomor Surat</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Naskah</th>
                                    <th>Hal</th>
                                    <th>Sifat Naskah</th>
                                    <th>Status</th>
                                    <th>File</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suratKeluar as $index => $surat)
                                <tr>
                                    <td>{{ $suratKeluar->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $surat->nomor_surat }}</strong>
                                        @if($surat->nomor_referensi)
                                            <br><small class="text-muted">Ref: {{ $surat->nomor_referensi }}</small>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge badge-secondary text-black">{{ ucfirst($surat->jenis_surat) }}</span>
                                    </td>
                                    <td>
                                        {{ Str::limit($surat->hal, 50) }}
                                        @if(strlen($surat->hal) > 50)
                                            <br><small class="text-black">{{ Str::limit($surat->isi_ringkas, 30) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($surat->sifat_surat)
                                            @case('rahasia')
                                                <span class="badge bg-danger text-black">{{ ucfirst($surat->sifat_surat) }}</span>
                                                @break
                                            @case('penting')
                                                <span class="badge bg-warning text-black">{{ ucfirst($surat->sifat_surat) }}</span>
                                                @break
                                            @case('segera')
                                                <span class="badge bg-succes text-black">{{ ucfirst($surat->sifat_surat) }}</span>
                                                @break
                                            @default
                                                <span class="badge bg-info text-black">{{ ucfirst($surat->sifat_surat) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($surat->status)
                                            @case('draft')
                                                <span class="badge badge-secondary text-black">Draft</span>
                                                @break
                                            @case('terkirim')
                                                <span class="badge badge-success text-black">Terkirim</span>
                                                @break
                                            @case('arsip')
                                                <span class="badge badge-primary text-black">Arsip</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        @if($surat->file_surat)
                                            <a href="{{ route('surat-keluar.download', $surat) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Download File">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('surat-keluar.show', $surat) }}" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('surat-keluar.edit', $surat) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('surat-keluar.destroy', $surat) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus surat ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data surat keluar</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            Menampilkan {{ $suratKeluar->firstItem() ?? 0 }} sampai {{ $suratKeluar->lastItem() ?? 0 }} 
                            dari {{ $suratKeluar->total() }} data
                        </div>
                        <div>
                            {{ $suratKeluar->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Success/Error Messages --}}
@if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div class="toast align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div class="toast align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Auto show toast messages
    document.addEventListener('DOMContentLoaded', function() {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function(toastEl) {
            var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
            toast.show();
            return toast;
        });
    });
</script>
@endpush