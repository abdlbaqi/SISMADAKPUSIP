@extends('layouts.app')

@section('content')
<div class="container-xl mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h3 class="card-title mb-0">Data Surat Masuk</h3>
                </div>

                <div class="card-body">
                    @if(session('sukses'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('sukses') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('surat-masuk.index') }}" class="mb-4">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label for="cari">Pencarian</label>
                                <input type="text" class="form-control" id="cari" name="cari" 
                                       value="{{ request('cari') }}" placeholder="Nomor surat, asal, perihal...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Reset</a>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-nowrap align-middle">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th width="3%">No</th>
                                    <th>No. Agenda</th>
                                    <th>No. Surat</th>
                                    <th>Nama Pengirim</th>
                                    <th>Jabatan</th>
                                    <th>Instansi</th>
                                    <th>Asal Surat</th>
                                    <th>Hal</th>
                                    <th>Isi Ringkas</th>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal Diterima</th>
                                    <th>Sifat Surat</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surat_masuk as $index => $surat)
                                    <tr>
                                        <td class="text-center">{{ $surat_masuk->firstItem() + $index }}</td>
                                        <td>{{ $surat->nomor_agenda }}</td>
                                        <td>{{ $surat->nomor_surat }}</td>
                                        <td>{{ $surat->nama_pengirim }}</td>
                                        <td>{{ $surat->jabatan_pengirim }}</td>
                                        <td>{{ $surat->instansi_pengirim }}</td>
                                        <td>{{ $surat->asal_surat }}</td>
                                        <td>{{ Str::limit($surat->perihal, 50) }}</td>
                                        <td>{{ Str::limit($surat->isi_ringkas, 50) }}</td>
                                        <td>
                                            <span class="badge bg-info text-dark">{{ $surat->kategori->nama_kategori ?? '-' }}</span>
                                        </td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            @switch($surat->sifat_surat)
                                                @case('biasa')
                                                    <span class="badge bg-secondary">Biasa</span>
                                                    @break
                                                @case('penting')
                                                    <span class="badge bg-warning text-dark">Penting</span>
                                                    @break
                                                @case('segera')
                                                    <span class="badge bg-danger">Segera</span>
                                                    @break
                                                @case('rahasia')
                                                    <span class="badge bg-dark">Rahasia</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ Str::limit($surat->keterangan, 50) }}</td>
                                        <td class="text-center">
                                            @if($surat->status === 'belum_dibaca')
                                                <span class="badge bg-warning text-dark">Belum Dibaca</span>
                                            @else
                                                <span class="badge bg-success">Sudah Dibaca</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('surat-masuk.show', $surat) }}" class="btn btn-info" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('surat-masuk.edit', $surat) }}" class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($surat->file_surat)
                                                    <a href="{{ route('surat-masuk.unduh-file', $surat) }}" class="btn btn-success" title="Unduh">
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
                                        <td colspan="15" class="text-center">Tidak ada data surat masuk</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $surat_masuk->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
