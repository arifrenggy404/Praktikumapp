@extends('layouts.pdf')

@section('title', 'Laporan Jadwal Ibadah')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Nama Ibadah</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwals as $index => $jadwal)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $jadwal->nama_ibadah }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_ibadah)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : 'Selesai' }}</td>
                    <td>{{ $jadwal->lokasi_ibadah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
