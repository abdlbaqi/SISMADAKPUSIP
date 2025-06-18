@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Surat Masuk</h3>
                    <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Surat Masuk
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('sukses'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('sukses') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('surat-masuk.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cari">Pencarian</label>
                                    <input type="text" class="form-control" id="cari" name="cari" 
                                           value="{{ request('cari') }}" placeholder="Nomor surat, asal, perihal...">
                                </div>
                            </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th>No. Agenda</th>
                                    <th>No. Surat</th>
                                    <th>Perihal</th>
                                    <th>Kategori Surat</th>
                                    <th>Tanggal Diterima</th>
                                    <th>Sifat</th>
                                    <th>Penerima</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surat_masuk as $index => $surat)
                                    <tr>
                                        <td>{{ $surat_masuk->firstItem() + $index }}</td>
                                        <td>{{ $surat->nomor_agenda }}</td>
                                        <td>{{ $surat->nomor_surat }}</td>
                                        <td>{{ Str::limit($surat->perihal, 50) }}</td>
                                        <td>
                                            <span class="badge badge-info text-dark">{{ $surat->kategori->nama_kategori ?? '-' }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>
                                        <td>
                                            @switch($surat->sifat_surat)
                                                @case('biasa')
                                                    <span class="badge badge-secondary text-dark">Biasa</span>
                                                    @break
                                                @case('penting')
                                                    <span class="badge badge-warning text-dark" >Penting</span>
                                                    @break
                                                @case('segera')
                                                    <span class="badge badge-danger text-dark">Segera</span>
                                                    @break
                                                @case('rahasia')
                                                    <span class="badge badge-dark text-dark">Rahasia</span>
                                                    @break
                                            @endswitch
                                        </td>

                                            <td>
                                                {{$surat->penerima->nama}}
                                           </td>

                                        <td>
                                            @if($surat->status === 'belum_dibaca')
                                                <span class="badge badge-warning text-dark">Belum Dibaca</span>
                                            @else
                                                <span class="badge badge-success text-dark">Sudah Dibaca</span>
                                            @endif
                                        </td>
                
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('surat-masuk.show', $surat) }}" 
                                                   class="btn btn-info btn-sm" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('surat-masuk.edit', $surat) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($surat->file_surat)
                                                    <a href="{{ route('surat-masuk.unduh-file', $surat) }}" 
                                                       class="btn btn-success btn-sm" title="Unduh File">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('surat-masuk.destroy', $surat) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Yakin ingin menghapus surat ini?')"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada data surat masuk</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $surat_masuk->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection