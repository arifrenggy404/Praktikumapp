@extends('layouts.app')

@section('title', 'Jadwal Ibadah - ' . ($setting->singkatan_gereja ?? 'GKS Kandara'))

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center py-4">
        <h1 class="serif display-4 fw-bold text-warning mb-3">Jadwal Pelayanan Ibadah</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 750px;">
            Jadwal Kebaktian Minggu, Sekolah Minggu, Persekutuan Doa, dan Ibadah Kategorial {{ $setting->nama_gereja ?? 'GKS Kandara' }}.
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-7">
            <form action="{{ route('public.jadwal') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-lg" placeholder="Cari nama ibadah atau lokasi...">
                <button type="submit" class="btn btn-warning fw-bold text-dark px-4">Cari</button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($jadwalTerbaru as $j)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100 border-start border-5 border-warning">
                    <div class="p-4 d-flex flex-column h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary px-3 py-2"><i class="fas fa-church me-1"></i> IBADAH</span>
                            <small class="text-muted"><i class="far fa-clock me-1 text-warning"></i> {{ $j->jam_selesai ? \Carbon\Carbon::parse($j->tanggal_waktu)->format('H:i') . ' - ' . \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') : \Carbon\Carbon::parse($j->tanggal_waktu)->format('H:i') }} WITA</small>
                        </div>
                        <h4 class="serif fw-bold text-dark mb-2">{{ $j->nama_ibadah }}</h4>
                        <p class="text-secondary small mb-3">
                            <i class="far fa-calendar-alt text-warning me-1"></i> {{ \Carbon\Carbon::parse($j->tanggal_waktu)->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i> Lokasi: <strong>{{ $j->lokasi_ibadah }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3 opacity-50"></i>
                <h5 class="text-muted">Belum ada jadwal ibadah yang dipublikasikan.</h5>
            </div>
        @endforelse
    </div>
</div>
@endsection