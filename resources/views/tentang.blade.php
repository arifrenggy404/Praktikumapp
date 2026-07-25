@extends('layouts.app')

@section('title', 'Tentang Kami - ' . ($setting->nama_gereja ?? 'GKS Kandara'))

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center py-4">
        <h1 class="serif display-4 fw-bold text-warning mb-3">Tentang {{ $setting->nama_gereja ?? 'GKS Kandara' }}</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 700px;">
            Mengenal lebih dekat perjalanan sejarah, visi, misi, serta sarana persekutuan jemaat.
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- VISI & MISI -->
    <div class="row g-4 mb-5 align-items-center">
        <div class="col-lg-6">
            <div class="p-5 bg-white rounded-4 shadow-sm border-start border-5 border-warning">
                <span class="badge bg-warning text-dark fw-bold px-3 py-2 mb-3">VISI GEREJA</span>
                <h2 class="serif text-primary fw-bold mb-3">{{ $setting->visi_gereja ?? 'Menjadi Jemaat yang Mandiri, Misionaris, dan Berakar dalam Kasih Kristus.' }}</h2>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="p-5 bg-white rounded-4 shadow-sm border-start border-5 border-primary">
                <span class="badge bg-primary fw-bold px-3 py-2 mb-3">MISI GEREJA</span>
                <p class="text-secondary fs-5 mb-0" style="white-space: pre-line;">
                    {!! e($setting->misi_gereja ?? "1. Koinonia: Membina persekutuan jemaat.\n2. Marturia: Menyaksikan Injil Kristus.\n3. Diakonia: Menjalankan pelayanan kasih.") !!}
                </p>
            </div>
        </div>
    </div>

    <!-- SEJARAH SINGKAT -->
    <div class="bg-white p-5 rounded-4 shadow-sm mb-5">
        <h2 class="serif section-title text-center mb-4">Sejarah Singkat {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}</h2>
        <div class="row justify-content-center">
            <div class="col-lg-10 text-secondary fs-5" style="line-height: 1.8; white-space: pre-line;">
                {!! e($setting->sejarah_gereja ?? 'Berdiri sebagai wadah persekutuan jemaat.') !!}
            </div>
        </div>
    </div>

    <!-- FOTO GEDUNG & FASILITAS GEREJA -->
    <div class="text-center mb-4">
        <h2 class="serif section-title text-center">Gedung & Fasilitas Gereja</h2>
        <p class="text-muted">Sarana pendukung ibadah dan persekutuan di {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1548625149-fc4a29cf7092?w=600&auto=format&fit=crop" class="w-100" style="height:240px; object-fit:cover;" alt="Gedung Utama">
                <div class="p-3 bg-white">
                    <h6 class="fw-bold mb-1">Gedung Utama Kebaktian</h6>
                    <small class="text-muted">Kapasitas persekutuan jemaat dengan fasilitas pendingin ruangan & audio.</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1438232992991-995b7058bbb3?w=600&auto=format&fit=crop" class="w-100" style="height:240px; object-fit:cover;" alt="Ruang Sekolah Minggu">
                <div class="p-3 bg-white">
                    <h6 class="fw-bold mb-1">Ruang Sekolah Minggu & Ruang Konseling</h6>
                    <small class="text-muted">Ruang belajar anak-anak dan pastori untuk pelayanan konseling pastoral.</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?w=600&auto=format&fit=crop" class="w-100" style="height:240px; object-fit:cover;" alt="Aula Serbaguna">
                <div class="p-3 bg-white">
                    <h6 class="fw-bold mb-1">Aula Serbaguna & Halaman</h6>
                    <small class="text-muted">Tempat kegiatan pemuda, rapat majelis, dan acara persekutuan jemaat.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
