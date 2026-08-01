<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($setting->singkatan_gereja ?? 'GKS Kandara') . ' - Portal Resmi')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --church-navy: #1e3a8a;
            --church-navy-dark: #0f172a;
            --church-gold: #b45309;
            --church-gold-light: #fef3c7;
            --church-cream: #fdfbf7;
            --church-accent: #d97706;
            --primary-color: #1e3a8a;
            --secondary-color: #475569;
        }

        body { 
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; 
            color: #334155;
            line-height: 1.6;
        }

        h1, h2, h3, h4, .serif {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            border-bottom: 3px solid var(--church-gold);
            padding: 12px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            color: var(--church-navy) !important;
        }

        .nav-link {
            font-weight: 600;
            color: var(--secondary-color) !important;
            transition: all 0.2s ease;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            padding: 8px 12px !important;
            border-radius: 4px;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--church-gold) !important;
            background-color: rgba(180, 83, 9, 0.06);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 10px;
        }

        .dropdown-item {
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
        }

        .dropdown-item:hover {
            background-color: var(--church-gold-light);
            color: var(--church-gold);
        }

        .footer {
            background: linear-gradient(135deg, var(--church-navy-dark), var(--church-navy));
            color: #94a3b8;
            padding: 70px 0 30px;
            border-top: 5px solid var(--church-gold);
        }

        .footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: var(--church-gold-light);
        }

        .btn-church {
            background: linear-gradient(135deg, var(--church-gold), #d97706);
            color: white !important;
            padding: 10px 24px;
            border-radius: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 4px 12px rgba(180, 83, 9, 0.25);
        }

        .btn-church:hover {
            background: var(--church-navy);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(30, 58, 138, 0.3);
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 35px;
            color: var(--church-navy);
            font-weight: 700;
        }

        .section-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background: var(--church-gold);
            border-radius: 2px;
        }

        @yield('styles')
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-xl sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center me-4" href="{{ url('/') }}">
            <div class="me-3 bg-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 8px; border: 1.5px solid var(--church-gold); overflow: hidden; padding: 2px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <img src="{{ asset('images/logo-gks.png') }}" alt="Logo Gereja" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <div class="d-flex flex-column">
                <span style="line-height: 1; font-size: 1.2rem; text-transform: uppercase;">{{ $setting->singkatan_gereja ?? 'GKS KANDARA' }}</span>
                <span class="small opacity-75" style="font-family: 'Inter', sans-serif; font-size: 0.65rem; letter-spacing: 1px; color: var(--church-gold);">PORTAL GEREJA</span>
            </div>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('tentang-kami') ? 'active' : '' }}" href="{{ route('public.tentang') }}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('jadwal-pelayanan') ? 'active' : '' }}" href="{{ url('/jadwal-pelayanan') }}">Jadwal Ibadah</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('pelayanan-komisi') || Request::is('pendaftaran-online') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                        Pelayanan
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('public.pelayanan') }}"><i class="fas fa-users me-2 text-warning"></i>Profil Pelayan & Komisi</a></li>
                        <li><a class="dropdown-item" href="{{ route('public.pendaftaran') }}"><i class="fas fa-file-signature me-2 text-warning"></i>Pendaftaran Online (Baptis/Sidi/Nikah)</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('renungan-khotbah') || Request::is('papan-pengumuman') || Request::is('galeri-kegiatan') || Request::is('warta-jemaat') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                        Info Jemaat
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('public.renungan') }}"><i class="fas fa-book-open me-2 text-warning"></i>Renungan & Khotbah</a></li>
                        <li><a class="dropdown-item" href="{{ route('public.pengumuman') }}"><i class="fas fa-bullhorn me-2 text-warning"></i>Papan Pengumuman Digital</a></li>
                        <li><a class="dropdown-item" href="{{ route('public.galeri') }}"><i class="fas fa-images me-2 text-warning"></i>Galeri Foto Kegiatan</a></li>
                        <li><a class="dropdown-item" href="{{ route('public.warta') }}"><i class="fas fa-newspaper me-2 text-warning"></i>Warta Jemaat</a></li>
                        <li><a class="dropdown-item" href="{{ url('/statistik') }}"><i class="fas fa-chart-pie me-2 text-warning"></i>Statistik Jemaat</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('kontak-lokasi') ? 'active' : '' }}" href="{{ route('public.kontak') }}">Kontak</a>
                </li>
                <li class="nav-item ms-xl-3 mt-2 mt-xl-0">
                    @if(Auth::check())
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm"><i class="fas fa-tachometer-alt me-1"></i> Dashboard Admin</a>
                    @else
                        <a href="{{ url('/login') }}" class="btn btn-outline-secondary btn-sm px-4 rounded-pill"><i class="fas fa-lock me-1"></i> Login</a>
                    @endif
                </li>
            </ul>
        </div>
    </div> 
</nav>

<main class="flex-grow-1">
    @yield('content')
</main>

<footer class="footer mt-auto">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4 text-center text-lg-start">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-3">
                    <i class="fas fa-cross fa-2x me-3 text-warning"></i>
                    <div>
                        <h4 class="text-white mb-0 serif">{{ $setting->singkatan_gereja ?? 'GKS Kandara' }}</h4>
                        <span class="small text-muted">{{ $setting->nama_gereja ?? 'Gereja Kristen Sumba Jemaat Kandara' }}</span>
                    </div>
                </div>
                <p class="small text-white opacity-75">
                    "{{ $setting->tagline_gereja ?? 'Bertumbuh dalam Iman, Teguh dalam Pengharapan, dan Melayani dalam Kasih.' }}"
                </p>
                <div class="d-flex gap-2 justify-content-center justify-content-lg-start">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->no_wa_gereja ?? '081234567890') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;" title="WhatsApp Sekretariat"><i class="fab fa-whatsapp"></i></a>
                    @if(!empty($setting->facebook_url))
                        <a href="{{ $setting->facebook_url }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(!empty($setting->instagram_url))
                        <a href="{{ $setting->instagram_url }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;" title="Instagram"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(!empty($setting->youtube_url))
                        <a href="{{ $setting->youtube_url }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;" title="YouTube"><i class="fab fa-youtube"></i></a>
                    @endif
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <h6 class="text-white text-uppercase mb-3 fw-bold" style="letter-spacing: 1px;">Navigasi Cepat</h6>
                <div class="row g-2 small">
                    <div class="col-6"><a href="{{ url('/') }}"><i class="fas fa-chevron-right me-1 small text-warning"></i> Beranda</a></div>
                    <div class="col-6"><a href="{{ route('public.tentang') }}"><i class="fas fa-chevron-right me-1 small text-warning"></i> Tentang Kami</a></div>
                    <div class="col-6"><a href="{{ url('/jadwal-pelayanan') }}"><i class="fas fa-chevron-right me-1 small text-warning"></i> Jadwal Ibadah</a></div>
                    <div class="col-6"><a href="{{ route('public.pelayanan') }}"><i class="fas fa-chevron-right me-1 small text-warning"></i> Pelayan & Komisi</a></div>
                    <div class="col-6"><a href="{{ route('public.pendaftaran') }}"><i class="fas fa-chevron-right me-1 small text-warning"></i> Pendaftaran Online</a></div>
                    <div class="col-6"><a href="{{ route('public.renungan') }}"><i class="fas fa-chevron-right me-1 small text-warning"></i> Renungan & Khotbah</a></div>
                    <div class="col-6"><a href="{{ route('public.pengumuman') }}"><i class="fas fa-chevron-right me-1 small text-warning"></i> Pengumuman</a></div>
                    <div class="col-6"><a href="{{ route('public.galeri') }}"><i class="fas fa-chevron-right me-1 small text-warning"></i> Galeri Kegiatan</a></div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <h6 class="text-white text-uppercase mb-3 fw-bold" style="letter-spacing: 1px;">Kontak & Alamat</h6>
                <ul class="list-unstyled small opacity-75 mb-0">
                    <li class="mb-2"><i class="fas fa-map-marker-alt text-warning me-2"></i> {{ $setting->alamat_gereja ?? 'Jl. Kandara, Waingapu, Sumba Timur, NTT' }}</li>
                    <li class="mb-2"><i class="fab fa-whatsapp text-warning me-2"></i> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->no_wa_gereja ?? '081234567890') }}" target="_blank" class="text-white text-decoration-none">{{ $setting->no_wa_gereja ?? '081234567890' }} (Sekretariat)</a></li>
                    <li class="mb-2"><i class="fas fa-envelope text-warning me-2"></i> <a href="mailto:{{ $setting->email_gereja ?? 'info@gkskandara.or.id' }}" class="text-white text-decoration-none">{{ $setting->email_gereja ?? 'info@gkskandara.or.id' }}</a></li>
                    @if(!empty($setting->jam_operasional))
                        <li class="mb-2"><i class="fas fa-clock text-warning me-2"></i> {{ $setting->jam_operasional }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <hr class="border-secondary opacity-25 my-4">

        <div class="row align-items-center small opacity-75">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                &copy; {{ date('Y') }} {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}. Hak Cipta Dilindungi Undang-Undang.
            </div>
            <div class="col-md-6 text-center text-md-end">
                Sistem Informasi Manajemen Jemaat
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>