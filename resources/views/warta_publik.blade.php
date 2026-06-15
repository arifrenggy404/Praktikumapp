@extends('layouts.app')

@section('title', 'Warta Jemaat - GKS Kandara')

@section('styles')
    <style>
        .page-header {
            background-color: var(--church-navy);
            color: white;
            padding: 80px 0;
            border-bottom: 5px solid var(--church-gold);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 0 L100 50 L50 100 L0 50 Z' fill='none' stroke='rgba(217, 119, 6, 0.1)' stroke-width='1'/%3E%3C/svg%3E");
            background-size: 80px 80px;
            opacity: 0.2;
        }

        .warta-card {
            border: 1px solid #e2e8f0;
            border-radius: 0;
            background: white;
            transition: all 0.3s ease;
            height: 100%;
            border-top: 4px solid var(--church-navy);
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        .warta-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border-top-color: var(--church-gold);
            z-index: 2;
        }

        .pdf-icon-box {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--church-cream);
            color: #ef4444;
            font-size: 3.5rem;
        }

        .warta-item-content {
            padding: 25px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
@endsection

@section('content')
<header class="page-header text-center">
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="display-4 fw-bold mb-3">Warta Jemaat</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 600px;">Unduh warta mingguan terbaru GKS Kandara dalam format PDF resmi.</p>
    </div>
</header>

<main class="container my-5 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 pb-3 border-bottom">
        <h3 class="serif mb-3 mb-md-0">Arsip Warta</h3>
        <div style="width: 100%; max-width: 400px;">
            <form action="{{ route('public.warta') }}" method="GET" class="d-flex gap-2">
                <div class="input-group shadow-sm rounded overflow-hidden">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 py-2" placeholder="Cari judul warta jemaat..." value="{{ request('search') }}">
                </div>
            </form>
        </div>
    </div>

    @if(request('search'))
        <div class="mb-4">
            <span class="text-muted">Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong></span>
            <a href="{{ route('public.warta') }}" class="ms-2 text-decoration-none small">Lihat Semua</a>
        </div>
    @endif

    <div class="row g-4">
        @forelse($wartas as $w)
            <div class="col-md-4 col-lg-3">
                <div class="warta-card h-100">
                    <div class="pdf-icon-box">
                        <i class="far fa-file-pdf"></i>
                    </div>
                    <div class="warta-item-content">
                        <div>
                            <h5 class="fw-bold mb-1 serif">{{ $w->judul }}</h5>
                            <p class="text-muted small mb-4">
                                <i class="far fa-calendar-alt me-1 text-church-gold"></i> {{ $w->tanggal_terbit->translatedFormat('d F Y') }}
                            </p>
                        </div>
                        <a href="{{ route('warta.download', $w->file_path) }}" class="btn btn-church w-100" style="position: relative; z-index: 10;">
                            <i class="fas fa-download me-2"></i> Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted opacity-20 mb-3"></i>
                <h4 class="text-muted">Belum ada warta yang tersedia saat ini.</h4>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $wartas->links() }}
    </div>
</main>
@endsection