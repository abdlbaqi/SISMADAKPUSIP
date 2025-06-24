@extends('layouts.app')

@section('content')
<div class="container-xl mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h3 class="card-title mb-0">Data Naskah Masuk</h3>
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
                    <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Surat
                    </a>
                    <a href="{{ route('surat-masuk.export') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('surat-masuk.export-pdf') }}" target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>

                </div>


                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-nowrap align-middle">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th width="3%">No</th>
                           
                                    <th>No. Naskah</th>
                                    <th>Nama Pengirim</th>
                                    <th>Jabatan</th>
                                    <th>Instansi Pengirim</th>
                                    <th>Hal</th>
                                    <th>Isi Ringkas</th>
                                    <th>Jenis Surat</th>
                                    <th>Sifat Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Tanggal Surat Diterima</th>
                                    <th>Unit Disposisi</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surat_masuk as $index => $surat)
                                    <tr>
                                        <td class="text-center">{{ $surat_masuk->firstItem() + $index }}</td>
                                        <td>{{ $surat->nomor_surat }}</td>
                                        <td>{{ $surat->nama_pengirim }}</td>
                                        <td>{{ $surat->jabatan_pengirim }}</td>
                                        <td>{{ $surat->instansi_pengirim }}</td>
                                        <td class="text-wrap" style="max-width: 200px;">{{ $surat->perihal }}</td>
                                        <td class="text-wrap" style="max-width: 250px;">{{ $surat->isi_ringkas }}</td>
                                        <td>
                                            <span class="badge bg-success text-light">{{ $surat->kategori->nama_kategori ?? '-' }}</span>
                                        </td>
                                          <td class="text-center">
                                            @switch($surat->sifat_surat)
                                                @case('biasa')
                                                    <span class="badge bg-secondary text-light">Biasa</span>
                                                    @break
                                                @case('penting')
                                                    <span class="badge bg-info text-dark">Penting</span>
                                                    @break
                                                @case('segera')
                                                    <span class="badge bg-warning text-light">Segera</span>
                                                    @break
                                                @case('rahasia')
                                                    <span class="badge bg-danger">Rahasia</span>
                                                    @break
                                            @endswitch
                                        </td>

                                        <td class="text-center">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>

                                         <td>
                                                    @switch($surat->unit_disposisi)
                                                        @case('sekretaris')
                                                            <span class="badge bg-primary">Sekretaris</span>
                                                            @break
                                                        @case('kabid_deposit')
                                                            <span class="badge bg-info">Bid Deposit, Akusisi dan Pengelolaan Bahan Pustaka</span>
                                                            @break
                                                        @case('kabid_pengembangan')
                                                            <span class="badge bg-success"> Bid Pengembangan Sumberdaya Perpustakaan</span>
                                                            @break
                                                        @case('kabid_layanan')
                                                            <span class="badge bg-warning"> Bid Layanan, TI, Pelestarian dan Kerjasama</span>
                                                            @break
                                                        @case('kabid_pembinaan')
                                                            <span class="badge bg-danger">  Bid Pembinaan dan Pengawasan Kearsipan</span>
                                                            @break
                                                        @case('kabid_pengelolaan_arsip')
                                                            <span class="badge bg-dark">Bid Pengelolaan Arsip</span>
                                                            @break
                                                    @endswitch
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
                                        <td colspan="15" class="text-center">Tidak ada data naskah masuk</td>
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
