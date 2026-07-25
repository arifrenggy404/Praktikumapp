@extends('layouts.app')

@section('title', 'Renungan & Khotbah - ' . ($setting->singkatan_gereja ?? 'GKS Kandara'))

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center py-4">
        <h1 class="serif display-4 fw-bold text-warning mb-3">Renungan & Khotbah Minggu</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 700px;">
            Sajian Firman Tuhan, renungan harian, dan tayangan video khotbah Minggu {{ $setting->nama_gereja ?? 'GKS Kandara' }}.
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- PENCARIAN & FILTER -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <form action="{{ route('public.renungan') }}" method="GET" class="row g-2">
                <div class="col-md-7">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-lg" placeholder="Cari kata kunci, pengkhotbah, atau topik...">
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-select form-select-lg">
                        <option value="">Semua Kategori</option>
                        <option value="Renungan Harian" {{ request('kategori') == 'Renungan Harian' ? 'selected' : '' }}>Renungan Harian</option>
                        <option value="Khotbah Minggu" {{ request('kategori') == 'Khotbah Minggu' ? 'selected' : '' }}>Khotbah Minggu</option>
                        <option value="Artikel" {{ request('kategori') == 'Artikel' ? 'selected' : '' }}>Artikel</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold text-dark">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- LIST RENUNGAN -->
    <div class="row g-4">
        @forelse($renungans as $r)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100 d-flex flex-column">
                    @if($r->video_url)
                        <div class="ratio ratio-16x9">
                            @php
                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $r->video_url, $matches);
                                $youtubeId = $matches[1] ?? null;
                            @endphp
                            @if($youtubeId)
                                <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" allowfullscreen></iframe>
                            @else
                                <div class="bg-dark text-white d-flex align-items-center justify-content-center">
                                    <i class="fas fa-play-circle fa-3x text-warning"></i>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-primary text-white p-4 text-center border-bottom border-4 border-warning">
                            <i class="fas fa-book-open fa-3x text-warning mb-2 opacity-75"></i>
                            <span class="badge bg-warning text-dark d-block mx-auto w-auto px-3 py-1 fw-bold">{{ $r->kategori }}</span>
                        </div>
                    @endif

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-warning fw-bold"><i class="far fa-calendar-alt me-1"></i> {{ $r->tanggal }}</small>
                            @if($r->ayat_alkitab)
                                <span class="badge bg-light text-secondary border">{{ $r->ayat_alkitab }}</span>
                            @endif
                        </div>
                        <h5 class="serif fw-bold text-dark mb-2">{{ $r->judul }}</h5>
                        <p class="text-secondary small mb-3 flex-grow-1" style="line-height: 1.6;">
                            {{ Str::limit(strip_tags($r->isi), 150) }}
                        </p>
                        <div class="border-top pt-3 text-muted small d-flex align-items-center mt-auto">
                            <i class="fas fa-user-edit text-primary me-2"></i> Oleh: <strong>{{ $r->pengkhotbah_penulis }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-bible fa-3x text-muted mb-3 opacity-50"></i>
                <h5 class="text-muted">Belum ada renungan atau khotbah untuk pencarian ini.</h5>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $renungans->links() }}
    </div>
</div>
@endsection
