@extends('layouts.pdf')

@section('title', 'Laporan Data Jemaat')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Nama Lengkap</th>
                <th width="10%">JK</th>
                <th>Alamat</th>
                <th width="15%">No. HP</th>
                <th width="10%">Status Baptis</th>
                <th width="10%">Status Sidi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jemaats as $index => $jemaat)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $jemaat->nama_lengkap }}</td>
                    <td>{{ $jemaat->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                    <td>{{ $jemaat->alamat_domisili }}</td>
                    <td>{{ $jemaat->no_hp ?? '-' }}</td>
                    <td>{{ $jemaat->status_baptis }}</td>
                    <td>{{ $jemaat->status_sidi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
