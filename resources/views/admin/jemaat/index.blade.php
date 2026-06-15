@extends('layouts.admin')

@section('title', 'Kelola Data Jemaat')
@section('header', 'Manajemen Warga Jemaat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('jemaat.index') }}" class="text-decoration-none text-muted small">Jemaat</a></li>
    <li class="breadcrumb-item active small" aria-current="page">Daftar</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-800 text-dark mb-1">Daftar Warga Jemaat</h4>
                <p class="text-muted small mb-0">Total terdata: <span class="fw-bold text-primary">{{ $jemaats->total() }}</span> Jiwa</p>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-2">
                <a href="{{ route('jemaat.pdf', ['search' => request('search')]) }}" class="btn btn-outline-danger shadow-sm">
                    <i class="fas fa-file-pdf me-2"></i> Cetak PDF
                </a>
                <a href="{{ route('jemaat.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Baru
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <form action="{{ route('jemaat.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 rounded-start-4 ps-3">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 py-2" 
                    placeholder="Cari nama atau alamat..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-4">Cari</button>
            @if(request('search'))
                <a href="{{ route('jemaat.index') }}" class="btn btn-light fw-bold px-4 rounded-4 border">Reset</a>
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
                        <th class="ps-4">Nama Lengkap</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Status Gerejawi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jemaats as $jemaat)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-soft-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; min-width: 40px;">
                                        <span class="fw-bold text-primary small">{{ strtoupper(substr($jemaat->nama_lengkap, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $jemaat->nama_lengkap }}</div>
                                        <div class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> {{ $jemaat->alamat_domisili }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small text-dark fw-medium">{{ $jemaat->tempat_lahir }}</div>
                                <div class="text-muted small">{{ \Carbon\Carbon::parse($jemaat->tanggal_lahir)->translatedFormat('d F Y') }}</div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge {{ $jemaat->status_baptis == 'Sudah' ? 'bg-soft-primary' : 'bg-light text-muted' }}">
                                        Baptis: {{ $jemaat->status_baptis }}
                                    </span>
                                    <span class="badge {{ $jemaat->status_sidi == 'Sudah' ? 'bg-soft-success' : 'bg-light text-muted' }}">
                                        Sidi: {{ $jemaat->status_sidi }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('jemaat.edit', $jemaat->id) }}" class="btn btn-sm btn-light text-warning" data-bs-toggle="tooltip" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('jemaat.destroy', $jemaat->id) }}" method="POST" class="delete-form">
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
                            <td colspan="4" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-user-slash fa-3x mb-3 opacity-25"></i>
                                    <h5 class="fw-bold">Tidak Ada Data</h5>
                                    <p class="mb-0">Belum ada data jemaat yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($jemaats->hasPages())
    <div class="card-footer bg-white border-0 py-4 px-4">
        {{ $jemaats->links() }}
    </div>
    @endif
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