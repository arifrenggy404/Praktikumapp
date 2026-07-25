@extends('layouts.admin')

@section('title', 'Data Jemaat Berdasarkan Keluarga')
@section('header', 'Manajemen Data Keluarga Jemaat')

@section('content')
<div class="card border-0 shadow-sm mb-4 rounded-4">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-bold text-dark mb-1"><i class="fas fa-users-between-lines text-primary me-2"></i> Data Jemaat Berbasis Keluarga</h4>
                <p class="text-muted small mb-0">Terdiri dari <span class="fw-bold text-primary">{{ $totalKK }}</span> Kartu Keluarga & <span class="fw-bold text-success">{{ $totalJemaat }}</span> Jiwa Anggota Jemaat.</p>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-2">
                <a href="{{ route('jemaat.pdf', ['search' => request('search')]) }}" class="btn btn-outline-danger shadow-sm rounded-3">
                    <i class="fas fa-file-pdf me-2"></i> Cetak Laporan KK (PDF)
                </a>
                <a href="{{ route('jemaat.create') }}" class="btn btn-primary shadow-sm rounded-3">
                    <i class="fas fa-user-plus me-2"></i> Tambah Anggota / Keluarga
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <form action="{{ route('jemaat.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                <span class="input-group-text bg-white border-end-0 ps-3">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 py-2" 
                    placeholder="Cari No. KK, nama kepala keluarga, atau anggota..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3">Cari</button>
            @if(request('search'))
                <a href="{{ route('jemaat.index') }}" class="btn btn-light fw-bold px-4 rounded-3 border">Reset</a>
            @endif
        </form>
    </div>
</div>

<!-- TAMPILAN PER KELUARGA (KARTU KELUARGA) -->
<div class="d-flex flex-column gap-4">
    @forelse($keluargas as $kk)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white border-start border-5 border-primary">
            <div class="card-header bg-light py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary fs-6 px-3 py-2 me-3 rounded-pill"><i class="fas fa-id-card me-1"></i> {{ $kk->no_kk_gereja }}</span>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">
                            Keluarga {{ $kk->kepalaKeluarga->nama_lengkap ?? 'Belum ada Kepala Keluarga' }}
                        </h5>
                        <small class="text-muted"><i class="fas fa-home me-1"></i> Alamat: {{ $kk->jemaats->first()->alamat_domisili ?? '-' }}</small>
                    </div>
                </div>
                <div>
                    <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fas fa-users me-1"></i> {{ $kk->jemaats->count() }} Anggota</span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th class="ps-4">Peran Dalam Keluarga</th>
                                <th>Nama Lengkap</th>
                                <th>L/P</th>
                                <th>Tempat, Tgl Lahir</th>
                                <th>Kontak (HP)</th>
                                <th>Status Gerejawi</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kk->jemaats as $member)
                                <tr>
                                    <td class="ps-4">
                                        @if($member->peran_keluarga == 'Kepala Keluarga (Ayah)')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill"><i class="fas fa-user-shield me-1"></i> Ayah (Kepala KK)</span>
                                        @elseif($member->peran_keluarga == 'Istri (Ibu)')
                                            <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-user-nurse me-1"></i> Ibu (Istri)</span>
                                        @elseif($member->peran_keluarga == 'Anak')
                                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill"><i class="fas fa-child me-1"></i> Anak</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $member->peran_keluarga }}</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">{{ $member->nama_lengkap }}</td>
                                    <td>
                                        <span class="badge {{ $member->jenis_kelamin == 'Laki-laki' ? 'bg-soft-primary' : 'bg-soft-danger' }}">
                                            {{ $member->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}
                                        </span>
                                    </td>
                                    <td class="small">
                                        {{ $member->tempat_lahir }}, {{ \Carbon\Carbon::parse($member->tanggal_lahir)->translatedFormat('d F Y') }}
                                        <div class="text-muted" style="font-size: 11px;">Usia: {{ \Carbon\Carbon::parse($member->tanggal_lahir)->age }} thn</div>
                                    </td>
                                    <td class="small">{{ $member->no_hp ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $member->status_baptis == 'Sudah' ? 'bg-primary' : 'bg-light text-muted border' }}">
                                            Baptis: {{ $member->status_baptis }}
                                        </span>
                                        <span class="badge {{ $member->status_sidi == 'Sudah' ? 'bg-success' : 'bg-light text-muted border' }}">
                                            Sidi: {{ $member->status_sidi }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('jemaat.edit', $member->id) }}" class="btn btn-sm btn-outline-warning rounded-3 me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('jemaat.destroy', $member->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus anggota jemaat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white text-muted">
            <i class="fas fa-users-slash fa-3x mb-3 opacity-50"></i>
            <h5>Belum ada data keluarga jemaat yang terdaftar.</h5>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $keluargas->links() }}
</div>
@endsection