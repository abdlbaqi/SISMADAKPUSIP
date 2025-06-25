@extends('layouts.app')

@section('title', 'Daftar Surat Keluar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
        
                   <form method="GET" action="{{ route('surat-masuk.index') }}" class="mb-4">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label for="cari">Pencarian</label>
                                <input type="text" class="form-control" id="cari" name="cari" 
                                       value="{{ request('cari') }}" placeholder="Masukkan Nomor surat">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Reset</a>
                            </div>
                        </div>
                    </form>

             <div class="d-flex justify-content-between mb-3">
                <div>
                    <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Surat
                    </a>
                    <a href="{{ route('surat-keluar.export') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('surat-keluar.export-pdf') }}" target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>

                </div>

                  <div class="table-responsive">
    <table class="table table-bordered table-striped" id="suratKeluarTable">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nomor Naskah</th>
                <th>Tanggal Surat</th>
                <th>Jenis Surat</th>
                <th>Sifat Surat</th>
                <th>Klasifikasi</th>
                <th>Hal</th>
                <th>Tujuan Surat</th>
                <th>Penandatangan</th>
                <th>Dikirim Melalui</th>
                <th width="12%">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($suratKeluar as $index => $surat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $surat->nomor_surat }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge bg-info">{{ $surat->kategori->nama_kategori }}</span>
                    </td>
                    <td>
                        @switch($surat->sifat_surat)
                            @case('biasa')
                                <span class="badge bg-secondary">Biasa</span>
                                @break
                            @case('penting')
                                <span class="badge bg-warning">Penting</span>
                                @break
                            @case('segera')
                                <span class="badge bg-danger">Segera</span>
                                @break
                            @case('rahasia')
                                <span class="badge bg-dark">Rahasia</span>
                                @break
                            @default
                                <span class="badge bg-light text-dark">{{ ucfirst($surat->sifat_surat) }}</span>
                        @endswitch
                    </td>
                    <td>{{ $surat->klasifikasi }}</td>
                    <td>
                        <div class="text-truncate" style="max-width: 150px;" title="{{ $surat->hal }}">
                            {{ $surat->hal }}
                        </div>
                    </td>
                    <td>
                        <div class="text-truncate" style="max-width: 150px;" title="{{ $surat->tujuan_surat }}">
                            {{ $surat->tujuan_surat }}
                        </div>
                    </td>
                    <td>{{ $surat->nama_penandatangan }}</td>
                    <td>{{ $surat->dikirimkan_melalui }}</td>

                    <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('surat-masuk.show', $surat) }}" class="btn btn-info" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('surat-masuk.edit', $surat) }}" class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($surat->file_surat)
                                                    <a href="{{ route('surat-keluar.unduh-file', $surat) }}" class="btn btn-success" title="Unduh">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('surat-masuk.destroy', $surat) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus surat ini?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">
                        <div class="py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data surat keluar</p>
                            <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Surat Keluar Pertama
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


                    <!-- Pagination -->
                    @if($suratKeluar->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $suratKeluar->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection