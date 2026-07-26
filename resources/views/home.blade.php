@extends('layouts.app')

@section('title', 'Beranda - ' . ($setting->nama_gereja ?? 'GKS Kandara'))

@section('styles')
    <style>
        :root {
            --church-navy: #1e3a8a;
            --church-gold: #b45309;
            --church-cream: #fdfbf7;
            --church-accent: #d97706;
        }

        .hero-section { 
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(30, 58, 138, 0.85)), url("{{ !empty($setting->beranda_bg_foto) ? (\Illuminate\Support\Str::startsWith($setting->beranda_bg_foto, ['http://', 'https://']) ? $setting->beranda_bg_foto : asset('storage/' . $setting->beranda_bg_foto)) : asset('images/latar-beranda.jpg') }}");
            background-size: cover;
            background-position: center;
            color: white; 
            padding: 140px 0 160px; 
            position: relative;
            border-bottom: 5px solid var(--church-gold);
        }

        .church-logo-circle {
            width: 110px;
            height: 110px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: 3px solid var(--church-gold);
            overflow: hidden;
            padding: 5px;
        }

        .verse-banner {
            background: linear-gradient(135deg, #fffbee, #fef3c7);
            border-left: 5px solid var(--church-gold);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(180, 83, 9, 0.08);
        }

        .card-pastor {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            background: white;
        }

        .card-announcement {
            border: 1px solid #e2e8f0;
            border-left: 4px solid var(--church-navy);
            border-radius: 10px;
            transition: all 0.3s;
            background: white;
        }

        .card-announcement:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            border-left-color: var(--church-gold);
        }

        .gallery-thumbnail {
            height: 220px;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.3s;
        }

        .gallery-thumbnail:hover {
            transform: scale(1.03);
        }

        .btn-gold {
            background-color: var(--church-gold);
            color: white !important;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(180, 83, 9, 0.3);
        }

        .btn-gold:hover {
            background-color: var(--church-navy);
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
<!-- HERO SECTION -->
<header class="hero-section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="church-logo-circle">
                    <img src="{{ asset('images/logo-gks.png') }}" alt="Logo Gereja" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h1 class="display-4 fw-bold mb-2 serif">{{ $setting->nama_gereja ?? 'Gereja Kristen Sumba Jemaat Kandara' }}</h1>
                <h2 class="h3 mb-4 opacity-90" style="font-weight: 400; font-style: italic;">{{ $setting->singkatan_gereja ?? 'GKS Kandara' }}</h2>
                <div class="mx-auto my-4" style="width: 80px; height: 3px; background: var(--church-gold); border-radius: 2px;"></div>
                <p class="lead mb-5 fs-4 mx-auto opacity-90" style="max-width: 850px;">
                    "{{ $setting->tagline_gereja ?? 'Bertumbuh dalam Iman, Teguh dalam Pengharapan, dan Melayani dalam Kasih' }}"
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ url('/jadwal-pelayanan') }}" class="btn btn-gold">
                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Ibadah Minggu Ini
                    </a>
                    <a href="{{ route('public.pendaftaran') }}" class="btn btn-outline-light rounded-pill px-4 py-3 fw-bold">
                        <i class="fas fa-file-signature me-2"></i> Pendaftaran Online
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- AYAT EMAS BANNER -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="verse-banner">
            <div class="row align-items-center">
                <div class="col-auto text-center text-md-start mb-3 mb-md-0">
                    <i class="fas fa-quote-left fa-3x text-warning opacity-75"></i>
                </div>
                <div class="col">
                    <h5 class="serif text-dark mb-1 fw-bold fs-4">Ayat Emas Hari Ini</h5>
                    <p class="fst-italic text-secondary mb-1 fs-5">
                        "{{ $setting->ayat_emas_teks ?? 'Sebab di mana dua atau tiga orang berkumpul dalam Nama-Ku, di situ Aku ada di tengah-tengah mereka.' }}"
                    </p>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-2">{{ $setting->ayat_emas_kitab ?? 'Matius 18:20' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SAMBUTAN PENDETA & TENTANG GEREJA -->
<section class="py-5" style="background-color: var(--church-cream);">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="card card-pastor p-4 text-center">
                    <div class="mx-auto mb-3 rounded-circle overflow-hidden shadow" style="width: 140px; height: 140px; border: 4px solid var(--church-gold);">
                        <img src="{{ !empty($setting->sambutan_foto) ? (\Illuminate\Support\Str::startsWith($setting->sambutan_foto, ['http://', 'https://']) ? $setting->sambutan_foto : asset('storage/' . $setting->sambutan_foto)) : asset('images/foto-salib.jpg') }}" alt="Foto Pendeta" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h4 class="serif fw-bold text-dark mb-1">{{ $setting->sambutan_nama ?? 'Pdt. Andreas, S.Th' }}</h4>
                    <p class="text-warning fw-bold small mb-3">{{ $setting->sambutan_jabatan ?? 'Pendeta Jemaat' }}</p>
                    <p class="text-muted small fst-italic mb-0">
                        "{{ $setting->sambutan_teks ?? 'Salam sejahtera dalam kasih Tuhan kita Yesus Kristus.' }}"
                    </p>
                </div>
            </div>
            
            <div class="col-lg-7">
                <span class="text-uppercase text-warning fw-bold tracking-wide small">Sambutan Gembala & Profil</span>
                <h2 class="serif section-title text-start mb-4">Selamat Datang di {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}</h2>
                <p class="fs-5 text-secondary mb-4">
                    {{ Str::limit($setting->sejarah_gereja ?? 'Berdiri sebagai wadah persekutuan, kesaksian, dan pelayanan.', 300) }}
                </p>
                
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                            <i class="fas fa-church text-warning fa-2x me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Persekutuan Hangat</h6>
                                <small class="text-muted">Ibadah Minggu & Kelompok</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                            <i class="fas fa-hands-holding-child text-warning fa-2x me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Pelayanan Komisi</h6>
                                <small class="text-muted">Anak, Pemuda, Wanita, Lansia</small>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('public.tentang') }}" class="btn btn-outline-dark rounded-pill px-4">
                    Selengkapnya Tentang Kami <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- PENGUMUMAN PENTING & JADWAL IBADAH -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-5">
            <!-- Feed Pengumuman Digital -->
            <div class="col-lg-7">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <span class="text-uppercase text-warning fw-bold small">Digital Info Feed</span>
                        <h3 class="serif fw-bold text-dark mb-0"><i class="fas fa-bullhorn text-warning me-2"></i> Pengumuman Gereja</h3>
                    </div>
                    <a href="{{ route('public.pengumuman') }}" class="small fw-bold text-decoration-none text-primary">Lihat Semua <i class="fas fa-chevron-right"></i></a>
                </div>

                @forelse($pengumumanTerbaru as $p)
                    <div class="card card-announcement p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold text-dark mb-0">{{ $p->judul }}</h5>
                            <span class="badge bg-light text-secondary border small">{{ $p->tanggal_dibuat }}</span>
                        </div>
                        <p class="text-muted small mb-2">{{ Str::limit($p->isi, 120) }}</p>
                        <div class="small text-muted"><i class="fas fa-user-edit me-1"></i> Oleh: {{ $p->dibuat_oleh }}</div>
                    </div>
                @empty
                    <div class="alert alert-light text-center border">Belum ada pengumuman terbaru.</div>
                @endforelse
            </div>

            <!-- Agenda Pelayanan / Jadwal Ibadah -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 p-4 bg-primary text-white">
                    <h4 class="serif fw-bold text-warning mb-3"><i class="fas fa-calendar-alt me-2"></i> Agenda Ibadah Mendatang</h4>
                    <p class="small opacity-75 mb-4">Jadwal Kebaktian Minggu dan Pelayanan Jemaat {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}.</p>

                    @forelse($jadwalAkanDatang as $j)
                        <div class="bg-white text-dark rounded-3 p-3 mb-3 border-start border-4 border-warning">
                            <h6 class="fw-bold mb-1 text-primary">{{ $j->nama_ibadah }}</h6>
                            <div class="small text-muted mb-1">
                                <i class="far fa-clock me-1 text-warning"></i> {{ \Carbon\Carbon::parse($j->tanggal_waktu)->translatedFormat('l, d F Y - H:i') }} WITA
                            </div>
                            <div class="small text-secondary">
                                <i class="fas fa-map-marker-alt me-1 text-danger"></i> Lokasi: {{ $j->lokasi_ibadah }}
                            </div>
                        </div>
                    @empty
                        <div class="bg-white text-dark rounded-3 p-3 text-center small opacity-75">
                            Silakan cek jadwal pelayanan mingguan di menu Jadwal.
                        </div>
                    @endforelse

                    <a href="{{ url('/jadwal-pelayanan') }}" class="btn btn-warning w-100 fw-bold mt-2 text-dark rounded-3">
                        Lihat Seluruh Jadwal Pelayanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GALERI DOKUMENTASI KEGIATAN -->
<section class="py-5" style="background-color: var(--church-cream);">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-uppercase text-warning fw-bold small">Dokumentasi Jemaat</span>
            <h2 class="serif section-title h1">Galeri Kegiatan Gereja</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Momen kebersamaan, perayaan Paskah, Natal, dan Bakti Sosial warga jemaat.</p>
        </div>

        <div class="row g-4">
            @forelse($galeriTerbaru as $gt)
                <div class="col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="{{ Str::startsWith($gt->gambar, 'http') ? $gt->gambar : asset('storage/' . $gt->gambar) }}" class="gallery-thumbnail w-100" alt="{{ $gt->judul }}">
                        <div class="p-3 bg-white">
                            <span class="badge bg-warning text-dark small mb-1">{{ $gt->kategori }}</span>
                            <h6 class="fw-bold mb-0 text-dark">{{ $gt->judul }}</h6>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-muted">Belum ada foto galeri kegiatan.</div>
            @endforelse
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('public.galeri') }}" class="btn btn-outline-dark rounded-pill px-4">
                Lihat Seluruh Galeri Foto <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- QUICK ACTION PENDAFTARAN ONLINE -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-4">
        <h2 class="serif display-6 fw-bold text-warning mb-3">Layanan Pendaftaran Online Jemaat</h2>
        <p class="fs-5 mx-auto mb-4 opacity-90" style="max-width: 700px;">
            Daftarkan anggota keluarga Anda untuk Sakramen Baptis Kudus, Peneguhan Sidi, Pernikahan, Konseling Gembala, atau Permohonan Doa secara praktis.
        </p>
        <a href="{{ route('public.pendaftaran') }}" class="btn btn-warning btn-lg fw-bold rounded-pill px-5 shadow text-dark">
            Buka Form Pendaftaran Online
        </a>
    </div>
</section>
@endsection