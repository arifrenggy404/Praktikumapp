@extends('layouts.app')

@section('title', 'Jadwal Pelayanan - GKS Kandara')

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

        .jadwal-card {
            border: 1px solid #e2e8f0;
            border-radius: 0;
            background: white;
            margin-bottom: 25px;
            border-left: 5px solid var(--church-navy);
            transition: all 0.3s;
        }

        .jadwal-card:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            border-left-color: var(--church-gold);
        }

        .date-box {
            background-color: var(--church-cream);
            padding: 20px;
            text-align: center;
            border-right: 1px solid #e2e8f0;
        }

        .sidebar-card {
            border: 1px solid #e2e8f0;
            border-radius: 0;
            background: white;
            border-top: 4px solid var(--church-gold);
            position: relative;
            z-index: 10;
        }

        .warta-item-sidebar {
            transition: all 0.2s;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .warta-item-sidebar:hover {
            background-color: var(--church-cream);
            padding-left: 5px;
        }

        .warta-link {
            text-decoration: none;
            color: var(--church-navy);
            font-weight: 700;
            display: block;
        }

        .badge-peran {
            background: #f1f5f9;
            color: var(--church-navy);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 5px 12px;
            border: 1px solid #e2e8f0;
        }
    </style>
@endsection

@section('content')
<header class="page-header text-center">
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="display-4 fw-bold mb-3">Agenda Pelayanan</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 600px;">Informasi waktu dan petugas pelayanan ibadah Jemaat Kandara.</p>
    </div>
</header>

<main class="container my-5 py-4">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <h3 class="serif mb-0">Ibadah Mendatang</h3>
                <div style="max-width: 300px;">
                    <form action="{{ route('public.jadwal') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Cari jadwal..." value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>
            
            @if(request('search'))
                <div class="mb-4">
                    <span class="text-muted">Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong></span>
                    <a href="{{ route('public.jadwal') }}" class="ms-2 text-decoration-none small">Lihat Semua</a>
                </div>
            @endif

            @forelse($jadwalTerbaru as $jadwal)
                <div class="jadwal-card">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-3">
                            <div class="date-box">
                                <div class="h2 fw-bold mb-0 text-primary" style="color: var(--church-navy) !important;">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_waktu)->format('d') }}
                                </div>
                                <div class="small text-uppercase fw-bold text-muted">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_waktu)->translatedFormat('M Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h4 class="fw-bold mb-0 serif">{{ $jadwal->nama_ibadah }}</h4>
                                <span class="badge bg-light text-dark border"><i class="far fa-clock me-1 text-gold"></i> {{ \Carbon\Carbon::parse($jadwal->tanggal_waktu)->format('H:i') }} WITA</span>
                            </div>
                            <div class="text-muted small mb-3">
                                <i class="fas fa-map-marker-alt me-2 text-church-gold"></i> {{ $jadwal->lokasi_ibadah }}
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                @foreach($jadwal->pelayan as $p)
                                    <span class="badge-peran">
                                        {{ $p->pivot->peran }}: {{ $p->nama_lengkap }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted opacity-20 mb-3"></i>
                    <p class="text-muted">Belum ada jadwal ibadah yang dirilis.</p>
                </div>
            @endforelse
        </div>
        
        <div class="col-lg-4">
            <div class="sidebar-card p-4 shadow-sm">
                <h5 class="fw-bold mb-4 serif border-bottom pb-2">Warta Terakhir</h5>
                @foreach($wartaList as $w)
                    <div class="warta-item-sidebar last-child-border-0">
                        <div class="small fw-bold mb-1" style="color: var(--church-gold);">
                            <i class="far fa-calendar-alt me-1"></i> {{ $w->tanggal_terbit->translatedFormat('d M Y') }}
                        </div>
                        <a href="{{ route('warta.download', $w->file_path) }}" class="warta-link">
                            <i class="fas fa-file-pdf me-2 text-danger small"></i> {{ $w->judul }}
                        </a>
                    </div>
                @endforeach
                <a href="{{ route('public.warta') }}" class="btn btn-church w-100 mt-2">
                    <i class="fas fa-list me-2"></i> Semua Warta
                </a>
            </div>
        </div>
    </div>
</main>
@endsection