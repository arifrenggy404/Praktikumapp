@extends('layouts.pdf')

@section('title', 'Laporan Inventaris Aset')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th width="10%" class="text-center">No</th>
                <th>Nama Barang</th>
                <th width="20%" class="text-center">Jumlah</th>
                <th width="30%">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventaris as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td class="text-center">{{ $item->jumlah_kuantitas }}</td>
                    <td>{{ $item->kondisi->nama_kondisi ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
