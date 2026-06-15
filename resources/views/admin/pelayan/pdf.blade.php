@extends('layouts.pdf')

@section('title', 'Laporan Data Pelayan Jemaat')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Nama Pelayan</th>
                <th>Jabatan/Peran</th>
                <th>No. HP</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelayans as $index => $pelayan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pelayan->jemaat->nama_lengkap }}</td>
                    <td>{{ $pelayan->jabatan }}</td>
                    <td>{{ $pelayan->jemaat->no_hp ?? '-' }}</td>
                    <td>{{ $pelayan->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
