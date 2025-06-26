@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Pengguna</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Peran</th>
                <th>Unit Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengguna as $pengguna)
            <tr>
                <td>{{ $pengguna->nama }}</td>
                <td>{{ $pengguna->email }}</td>
                <td>{{ $pengguna->peran }}</td>
                <td>{{ $pengguna->unit_kerja }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
