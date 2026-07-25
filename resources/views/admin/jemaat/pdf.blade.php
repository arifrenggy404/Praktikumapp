@extends('layouts.pdf')

@section('title', 'Laporan Data Keluarga Jemaat')

@section('content')
    <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN DATA KELUARGA WARGA JEMAAT</h3>

    @foreach($keluargas as $kkIndex => $kk)
        <div style="margin-bottom: 25px; page-break-inside: avoid;">
            <div style="background-color: #f1f5f9; padding: 8px 12px; font-weight: bold; border-left: 4px solid #1e3a8a; margin-bottom: 8px;">
                NO. KK GEREJA: {{ $kk->no_kk_gereja }} | KEPALA KELUARGA: {{ strtoupper($kk->kepalaKeluarga->nama_lengkap ?? 'BELUM DITENTUKAN') }}
            </div>

            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #e2e8f0;">
                        <th width="20%">Peran Keluarga</th>
                        <th>Nama Lengkap</th>
                        <th width="8%">L/P</th>
                        <th width="25%">Tempat, Tgl Lahir</th>
                        <th width="15%">No. HP</th>
                        <th width="12%">Status Baptis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kk->jemaats as $jemaat)
                        <tr>
                            <td style="font-weight: bold;">{{ $jemaat->peran_keluarga }}</td>
                            <td>{{ $jemaat->nama_lengkap }}</td>
                            <td style="text-align: center;">{{ $jemaat->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                            <td>{{ $jemaat->tempat_lahir }}, {{ \Carbon\Carbon::parse($jemaat->tanggal_lahir)->format('d-m-Y') }}</td>
                            <td>{{ $jemaat->no_hp ?? '-' }}</td>
                            <td style="text-align: center;">{{ $jemaat->status_baptis }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection
