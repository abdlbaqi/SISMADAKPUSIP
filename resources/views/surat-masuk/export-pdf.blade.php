<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Surat Masuk</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Surat Masuk Dinas Perpustakaan Dan Kearsipan Provinsi Lampung</h2>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 12%;">Nomor Surat</th>
                <th style="width: 15%;">Nama Pengirim</th>
                <th style="width: 20%;">Instansi</th>
                <th style="width: 10%;">Perihal</th>
                <th style="width: 15%;">Isi Ringkas</th>
                <th style="width: 10%;">Tanggal Surat</th>
                <th style="width: 10%;">Tanggal Diterima</th>
                <th style="width: 15%;">Jenis Surat</th>
                <th style="width: 10%;">Sifat Surat</th>
                <th style="width: 10%;">Nama Surat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $row->nomor_surat }}</td>
                <td>{{ $row->nama_pengirim }}</td>
                <td>{{ $row->instansi_pengirim }}</td>
                <td class="text-justify">{{ $row->perihal }}</td>
                <td class="text-justify">{{ $row->isi_ringkas }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal_surat)->format('d/m/Y') }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal_diterima)->format('d/m/Y') }}</td>
                <td class="text-center">{{ ucfirst($row->kategori->nama_kategori) }}</td>
                <td class="text-center">{{ ucfirst($row->sifat_surat) }}</td>
               <td>
                        @if ($row->file_surat)
                            {{ preg_replace('/^\d+_/', '', basename($row->file_surat)) }}
                        @else
                            -
                        @endif
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
