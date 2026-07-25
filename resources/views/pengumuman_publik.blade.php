@extends('layouts.app')

@section('title', 'Papan Pengumuman Digital - ' . ($setting->singkatan_gereja ?? 'GKS Kandara'))

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center py-4">
        <h1 class="serif display-4 fw-bold text-warning mb-3">Papan Pengumuman Digital</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 700px;">
            Informasi resmi persekutuan, rapat majelis, kegiatan pelayanan, dan pengumuman jemaat {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}.
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-7">
            <form action="{{ route('public.pengumuman') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-lg" placeholder="Cari judul pengumuman...">
                <button type="submit" class="btn btn-warning fw-bold text-dark px-4">Cari</button>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            @forelse($pengumumen as $p)
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border-start border-5 border-warning">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary px-3 py-2"><i class="fas fa-bullhorn me-1"></i> PENGUMUMAN</span>
                        <small class="text-muted"><i class="far fa-clock me-1"></i> Dibuat: {{ $p->tanggal_dibuat }}</small>
                    </div>
                    <h4 class="serif fw-bold text-dark mb-3">{{ $p->judul }}</h4>
                    <p class="text-secondary fs-5 mb-3" style="line-height: 1.7;">
                        {!! nl2br(e($p->isi)) !!}
                    </p>
                    <div class="border-top pt-3 text-muted small d-flex align-items-center">
                        <i class="fas fa-user-edit text-warning me-2"></i> Diterbitkan oleh: <strong>{{ $p->dibuat_oleh }}</strong>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                    <i class="fas fa-bullhorn fa-3x text-muted mb-3 opacity-50"></i>
                    <h5 class="text-muted">Belum ada pengumuman digital saat ini.</h5>
                </div>
            @endforelse

            <div class="d-flex justify-content-center mt-4">
                {{ $pengumumen->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
