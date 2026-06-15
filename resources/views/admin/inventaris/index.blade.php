@extends('layouts.admin')

@section('title', 'Kelola Inventaris')
@section('header', 'Manajemen Aset & Inventaris')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Daftar Aset Gereja</h4>
        <p class="text-muted small mb-0">Kelola inventaris sarana dan prasarana jemaat.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('inventaris.pdf', ['search' => request('search')]) }}" class="btn btn-outline-danger fw-bold px-3">
            <i class="fas fa-file-pdf me-2"></i> Cetak PDF
        </a>
        <a href="{{ route('inventaris.create') }}" class="btn btn-primary fw-bold px-4">
            <i class="fas fa-plus me-2"></i> Tambah Inventaris
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="row mb-4">
    <div class="col-md-6">
        <form action="{{ route('inventaris.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 rounded-start-4 ps-3">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 py-2" 
                    placeholder="Cari nama barang..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-4">Cari</button>
            @if(request('search'))
                <a href="{{ route('inventaris.index') }}" class="btn btn-light fw-bold px-4 rounded-4 border">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Nama Barang / Aset</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Jumlah Volume</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Kondisi Fisik</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Log Pencatatan</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $asset->nama_barang }}</div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-soft-primary text-primary border-0 px-3 py-2">
                                    {{ $asset->jumlah_kuantitas }} Unit
                                </span>
                            </td>
                            <td class="py-3">
                                @php
                                    $kondisi = $asset->kondisi->nama_kondisi ?? 'Unknown';
                                    $badgeClass = 'bg-secondary';
                                    if ($kondisi == 'Bagus' || $kondisi == 'Baik') $badgeClass = 'bg-success';
                                    if ($kondisi == 'Rusak') $badgeClass = 'bg-warning text-dark';
                                    if ($kondisi == 'Dibuang' || $kondisi == 'Rusak Berat') $badgeClass = 'bg-danger';
                                @endphp
                                <span class="badge {{ $badgeClass }} rounded-pill px-3">
                                    {{ $kondisi }}
                                </span>
                            </td>
                            <td class="py-3 text-muted small">
                                {{ \Carbon\Carbon::parse($asset->created_at)->translatedFormat('d M Y, H:i') }} WITA
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('inventaris.edit', $asset->id) }}" class="btn btn-sm btn-light text-warning border">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('inventaris.destroy', $asset->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-boxes fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">Belum ada aset sarana prasarana gereja yang terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #eff6ff; color: #2563eb; }
</style>
@endsection