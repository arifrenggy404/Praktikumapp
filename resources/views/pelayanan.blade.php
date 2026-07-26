@extends('layouts.app')

@section('title', 'Pelayan & Komisi - ' . ($setting->singkatan_gereja ?? 'GKS Kandara'))

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center py-4">
        <h1 class="serif display-4 fw-bold text-warning mb-3">Profil Pelayan & Komisi Gereja</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 750px;">
            Struktur Pelayan Firman, Majelis Jemaat, dan Penanggung Jawab Komisi Kategorial {{ $setting->nama_gereja ?? 'GKS Kandara' }}.
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- PENDETA & MAJELIS -->
    <div class="mb-5">
        <h2 class="serif section-title text-center">Pendeta & Majelis Jemaat</h2>
        <div class="row g-4 justify-content-center">
            @forelse($pelayans as $p)
                <div class="col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-center p-4 bg-white border-top border-4 border-warning">
                        <div class="mx-auto mb-3 rounded-circle overflow-hidden shadow" style="width: 100px; height: 100px;">
                            <img src="{{ asset('images/foto-salib.jpg') }}" class="w-100 h-100" style="object-fit: cover;" alt="Pelayan">
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $p->jemaat->nama_lengkap ?? 'Pelayan Jemaat' }}</h5>
                        <span class="badge bg-warning text-dark px-3 py-1 fw-bold rounded-pill mb-2">{{ $p->jabatan }}</span>
                        <p class="small text-muted mb-0">Mulai Pelayanan: {{ $p->tanggal_mulai }}</p>
                    </div>
                </div>
            @empty
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                        <h5 class="fw-bold mb-1">{{ $setting->sambutan_nama ?? 'Pdt. Andreas, S.Th' }}</h5>
                        <span class="badge bg-warning text-dark px-3 py-1 fw-bold rounded-pill mb-2">{{ $setting->sambutan_jabatan ?? 'Pendeta Jemaat' }}</span>
                        <p class="small text-muted">Penanggung Jawab Pelayanan Gembala</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- KOMISI & KELOMPOK KATEGORIAL -->
    <div class="pt-4">
        <div class="text-center mb-4">
            <span class="text-uppercase text-warning fw-bold small">Kategori Komisi</span>
            <h2 class="serif section-title">Komisi / Kelompok Kategorial</h2>
            <p class="text-muted">Pelayanan kategorial beserta Penanggung Jawab di {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}.</p>
        </div>

        <div class="row g-4">
            <!-- Komisi Anak -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border-start border-4 border-danger">
                    <div class="mb-3 text-danger"><i class="fas fa-child fa-3x"></i></div>
                    <h4 class="serif fw-bold text-dark mb-2">Komisi Anak (PAR)</h4>
                    <p class="small text-muted mb-3">Pembinaan iman dan karakter anak-anak Sekolah Minggu.</p>
                    <div class="bg-light p-3 rounded-3 mt-auto">
                        <small class="text-muted d-block fw-bold mb-1">Penanggung Jawab:</small>
                        <strong class="text-dark small"><i class="fas fa-user-check text-success me-1"></i> {{ $setting->pj_komisi_anak ?? 'Ibu Maria & Tim Guru SM' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Komisi Pemuda -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border-start border-4 border-primary">
                    <div class="mb-3 text-primary"><i class="fas fa-user-ninja fa-3x"></i></div>
                    <h4 class="serif fw-bold text-dark mb-2">Komisi Pemuda (PERMATA)</h4>
                    <p class="small text-muted mb-3">Wadah kreativitas, ibadah, dan persekutuan pemuda-pemudi.</p>
                    <div class="bg-light p-3 rounded-3 mt-auto">
                        <small class="text-muted d-block fw-bold mb-1">Penanggung Jawab:</small>
                        <strong class="text-dark small"><i class="fas fa-user-check text-success me-1"></i> {{ $setting->pj_komisi_pemuda ?? 'Bpk. Yohanes & Pengurus Pemuda' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Komisi Wanita -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border-start border-4 border-success">
                    <div class="mb-3 text-success"><i class="fas fa-female fa-3x"></i></div>
                    <h4 class="serif fw-bold text-dark mb-2">Komisi Perempuan (PW)</h4>
                    <p class="small text-muted mb-3">Persekutuan doa dan aksi sosial wanita gereja.</p>
                    <div class="bg-light p-3 rounded-3 mt-auto">
                        <small class="text-muted d-block fw-bold mb-1">Penanggung Jawab:</small>
                        <strong class="text-dark small"><i class="fas fa-user-check text-success me-1"></i> {{ $setting->pj_komisi_wanita ?? 'Ibu Martha & Pengurus PW' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Komisi Lansia -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border-start border-4 border-warning">
                    <div class="mb-3 text-warning"><i class="fas fa-blind fa-3x"></i></div>
                    <h4 class="serif fw-bold text-dark mb-2">Komisi Lansia (Usia Lanjut)</h4>
                    <p class="small text-muted mb-3">Pelayanan kasih dan persekutuan doa bagi kaum usia lanjut.</p>
                    <div class="bg-light p-3 rounded-3 mt-auto">
                        <small class="text-muted d-block fw-bold mb-1">Penanggung Jawab:</small>
                        <strong class="text-dark small"><i class="fas fa-user-check text-success me-1"></i> {{ $setting->pj_komisi_lansia ?? 'Penatua Pendamping Lansia' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
