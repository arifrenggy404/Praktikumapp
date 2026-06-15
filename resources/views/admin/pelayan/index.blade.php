@extends('layouts.admin')

@section('title', 'Manajemen Pelayanan')
@section('header', 'Manajemen Pelayanan Gereja')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pelayan.index') }}" class="text-decoration-none text-muted small">Pelayan</a></li>
    <li class="breadcrumb-item active small" aria-current="page">Daftar</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-800 text-dark mb-1">Daftar Pelayan Gereja</h4>
                <p class="text-muted small mb-0">Pendeta, Penatua, Diaken, Vikaris, dan Majelis Jemaat</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pelayan.pdf', ['search' => request('search')]) }}" class="btn btn-outline-danger shadow-sm">
                    <i class="fas fa-file-pdf me-2"></i> Cetak PDF
                </a>
                <a href="{{ route('pelayan.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Pelayan
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <form action="{{ route('pelayan.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 rounded-start-4 ps-3">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 py-2" 
                    placeholder="Cari nama pelayan..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-4">Cari</button>
            @if(request('search'))
                <a href="{{ route('pelayan.index') }}" class="btn btn-light fw-bold px-4 rounded-4 border">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nama Pelayan</th>
                        <th>Jabatan</th>
                        <th>Masa Bakti</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelayans as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-soft-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; min-width: 40px;">
                                        <i class="fas fa-user-tie text-primary small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $p->jemaat->nama_lengkap }}</div>
                                        <div class="text-muted small">ID Jemaat: #{{ $p->jemaat_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ in_array($p->jabatan, ['Pendeta', 'Vikaris']) ? 'bg-soft-primary' : 'bg-soft-success' }}">
                                    {{ $p->jabatan }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-dark fw-medium">
                                    {{ $p->tanggal_mulai ? $p->tanggal_mulai->translatedFormat('d M Y') : '-' }} 
                                </div>
                                <div class="text-muted small">
                                    s/d {{ $p->tanggal_selesai ? $p->tanggal_selesai->translatedFormat('d M Y') : 'Sekarang' }}
                                </div>
                            </td>
                            <td class="text-center">
                                @if($p->is_aktif)
                                    <span class="badge bg-soft-success text-success border-0 rounded-pill px-3">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-soft-danger text-danger border-0 rounded-pill px-3">
                                        <i class="fas fa-times-circle me-1"></i> Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('pelayan.edit', $p->id) }}" class="btn btn-sm btn-light text-warning" data-bs-toggle="tooltip" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pelayan.destroy', $p->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger" data-bs-toggle="tooltip" title="Hapus Data">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-user-tie fa-3x mb-3 opacity-25"></i>
                                    <h5 class="fw-bold">Tidak Ada Data</h5>
                                    <p class="mb-0">Belum ada data pelayan yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection