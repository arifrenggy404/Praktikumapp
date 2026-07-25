@extends('layouts.app')

@section('title', 'Galeri Foto Kegiatan - ' . ($setting->singkatan_gereja ?? 'GKS Kandara'))

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center py-4">
        <h1 class="serif display-4 fw-bold text-warning mb-3">Galeri Foto Kegiatan Gereja</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 700px;">
            Dokumentasi sukacita ibadah perayaan Natal, Paskah, Bakti Sosial, dan persekutuan warga jemaat {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}.
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- CATEGORY FILTER BUTTONS -->
    <div class="d-flex justify-content-center gap-2 flex-wrap mb-5">
        <a href="{{ route('public.galeri') }}" class="btn {{ !request('kategori') ? 'btn-warning fw-bold text-dark' : 'btn-outline-secondary' }} rounded-pill px-4">Semua Foto</a>
        <a href="{{ route('public.galeri', ['kategori' => 'Natal']) }}" class="btn {{ request('kategori') == 'Natal' ? 'btn-warning fw-bold text-dark' : 'btn-outline-secondary' }} rounded-pill px-4">Natal</a>
        <a href="{{ route('public.galeri', ['kategori' => 'Paskah']) }}" class="btn {{ request('kategori') == 'Paskah' ? 'btn-warning fw-bold text-dark' : 'btn-outline-secondary' }} rounded-pill px-4">Paskah</a>
        <a href="{{ route('public.galeri', ['kategori' => 'Bakti Sosial']) }}" class="btn {{ request('kategori') == 'Bakti Sosial' ? 'btn-warning fw-bold text-dark' : 'btn-outline-secondary' }} rounded-pill px-4">Bakti Sosial</a>
        <a href="{{ route('public.galeri', ['kategori' => 'Ibadah']) }}" class="btn {{ request('kategori') == 'Ibadah' ? 'btn-warning fw-bold text-dark' : 'btn-outline-secondary' }} rounded-pill px-4">Ibadah</a>
        <a href="{{ route('public.galeri', ['kategori' => 'Pemuda']) }}" class="btn {{ request('kategori') == 'Pemuda' ? 'btn-warning fw-bold text-dark' : 'btn-outline-secondary' }} rounded-pill px-4">Pemuda</a>
    </div>

    <!-- GALLERY GRID -->
    <div class="row g-4">
        @forelse($galeris as $g)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100">
                    <div style="height: 250px; overflow: hidden; position: relative;">
                        <img src="{{ Str::startsWith($g->gambar, 'http') ? $g->gambar : asset('storage/' . $g->gambar) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $g->judul }}">
                        <span class="badge bg-warning text-dark fw-bold position-absolute top-0 end-0 m-3 px-3 py-2 shadow-sm">{{ $g->kategori }}</span>
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h5 class="serif fw-bold text-dark mb-2">{{ $g->judul }}</h5>
                        <p class="text-secondary small mb-3 flex-grow-1">{{ $g->deskripsi }}</p>
                        <div class="text-muted small border-top pt-2">
                            <i class="far fa-calendar-alt me-1 text-warning"></i> Tanggal: {{ $g->tanggal_kegiatan }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-images fa-3x text-muted mb-3 opacity-50"></i>
                <h5 class="text-muted">Belum ada foto galeri untuk kategori ini.</h5>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $galeris->links() }}
    </div>
</div>
@endsection
