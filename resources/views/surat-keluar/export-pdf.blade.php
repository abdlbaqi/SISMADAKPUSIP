<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Surat Keluar PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">DAFTAR SURAT KELUAR</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Sifat</th>
                <th>Klasifikasi</th>
                <th>Hal</th>
                <th>Tujuan</th>
                <th>Penandatangan</th>
                <th>Dikirim Melalui</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $surat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $surat->nomor_surat }}</td>
                <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                <td>{{ $surat->kategori->nama_kategori }}</td>
                <td>{{ ucfirst($surat->sifat_surat) }}</td>
                <td>{{ $surat->klasifikasi }}</td>
                <td>{{ $surat->hal }}</td>
                <td>{{ $surat->tujuan_surat }}</td>
                <td>{{ $surat->nama_penandatangan }}</td>
                <td>{{ $surat->dikirimkan_melalui }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
