@extends('layouts.app')

@section('title', 'Kontak & Lokasi - ' . ($setting->singkatan_gereja ?? 'GKS Kandara'))

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center py-4">
        <h1 class="serif display-4 fw-bold text-warning mb-3">Kontak & Lokasi Gereja</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 700px;">
            Hubungi pengurus sekretariat gereja atau kunjungi lokasi ibadah {{ $setting->nama_gereja ?? 'GKS Kandara' }}.
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5 align-items-center">
        <!-- INFO KONTAK -->
        <div class="col-lg-5">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border-start border-5 border-warning">
                <h3 class="serif fw-bold text-primary mb-4"><i class="fas fa-church text-warning me-2"></i> Sekretariat {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}</h3>

                <div class="d-flex mb-4">
                    <div class="me-3 text-warning"><i class="fas fa-map-marker-alt fa-2x"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Alamat Gereja</h6>
                        <p class="text-secondary small mb-0">{{ $setting->alamat_gereja ?? 'Jl. Kandara, Kelurahan Kandara, Waingapu, Kab. Sumba Timur, Nusa Tenggara Timur.' }}</p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="me-3 text-success"><i class="fab fa-whatsapp fa-2x"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">WhatsApp Resmi Gereja</h6>
                        <p class="text-secondary small mb-2">{{ $setting->no_wa_gereja ?? '081234567890' }} (Sekretariat Jemaat)</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->no_wa_gereja ?? '081234567890') }}?text=Halo%20Sekretariat%20{{ urlencode($setting->singkatan_gereja ?? 'GKS Kandara') }}" target="_blank" class="btn btn-success btn-sm fw-bold rounded-pill px-3">
                            <i class="fab fa-whatsapp me-1"></i> Chat via WhatsApp
                        </a>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="me-3 text-primary"><i class="fas fa-envelope fa-2x"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Email Informasi</h6>
                        <p class="text-secondary small mb-0">{{ $setting->email_gereja ?? 'info@gkskandara.or.id' }}</p>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="me-3 text-warning"><i class="fas fa-clock fa-2x"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Jam Operasional Sekretariat</h6>
                        <p class="text-secondary small mb-0">Senin - Sabtu: 08.00 - 16.00 WITA<br>Minggu: Pelayanan Kebaktian</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- GOOGLE MAPS EMBED -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="bg-primary text-white p-3 d-flex align-items-center">
                    <i class="fas fa-map-marked-alt text-warning me-2 fs-4"></i>
                    <h5 class="mb-0 serif fw-bold">Peta Lokasi {{ $setting->nama_gereja ?? 'GKS Kandara' }}</h5>
                </div>
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $setting->maps_embed_url ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62985.34433157502!2d120.223846!3d-9.664402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4c81a70868f7b5%3A0x6b6c0e29b1399f01!2sWaingapu%2C%20East%20Sumba%20Regency%2C%20East%20Nusa%20Tenggara!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid' }}" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="p-3 bg-light text-center small text-muted">
                    <i class="fas fa-info-circle me-1 text-primary"></i> Anda dapat menavigasi rute langsung menggunakan Google Maps.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
