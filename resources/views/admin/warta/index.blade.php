@extends('layouts.admin')

@section('title', 'Kelola Warta Jemaat')
@section('header', 'Manajemen Warta Jemaat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('warta.index') }}" class="text-decoration-none text-muted small">Warta</a></li>
    <li class="breadcrumb-item active small" aria-current="page">Daftar</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-800 text-dark mb-1">Daftar Warta Jemaat</h4>
                <p class="text-muted small mb-0">Kelola file warta mingguan untuk diakses oleh jemaat.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('warta.pdf', ['search' => request('search')]) }}" class="btn btn-outline-danger shadow-sm">
                    <i class="fas fa-file-pdf me-2"></i> Cetak PDF
                </a>
                <a href="{{ route('warta.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-file-upload me-2"></i> Unggah Warta
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <form action="{{ route('warta.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 rounded-start-4 ps-3">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 py-2" 
                    placeholder="Cari judul warta..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-4">Cari</button>
            @if(request('search'))
                <a href="{{ route('warta.index') }}" class="btn btn-light fw-bold px-4 rounded-4 border">Reset</a>
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
                        <th class="ps-4">Judul Warta</th>
                        <th>Tanggal Terbit</th>
                        <th>Dokumen</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wartas as $w)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-soft-danger rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-file-pdf text-danger fs-5"></i>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $w->judul }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">
                                    <i class="far fa-calendar-alt me-1 text-primary"></i> {{ $w->tanggal_terbit->translatedFormat('d F Y') }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-muted border px-2 py-1 small fw-medium">
                                    {{ $w->file_path }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('warta.download', $w->file_path) }}" class="btn btn-sm btn-light text-primary" data-bs-toggle="tooltip" title="Download PDF">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form action="{{ route('warta.destroy', $w->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger" data-bs-toggle="tooltip" title="Hapus Warta">
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
                                    <i class="fas fa-file-invoice fa-3x mb-3 opacity-25"></i>
                                    <h5 class="fw-bold">Tidak Ada Warta</h5>
                                    <p class="mb-0">Belum ada warta jemaat yang diunggah.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($wartas->hasPages())
    <div class="card-footer bg-white border-0 py-4 px-4">
        {{ $wartas->links() }}
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