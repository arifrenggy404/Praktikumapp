@extends('layouts.pdf')

@section('title', 'Laporan Daftar Warta Jemaat')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Judul Warta</th>
                <th>Tanggal Terbit</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wartas as $index => $warta)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $warta->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($warta->tanggal_terbit)->translatedFormat('d F Y') }}</td>
                    <td>{{ $warta->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
