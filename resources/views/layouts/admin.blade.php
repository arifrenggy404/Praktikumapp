<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SIM GKS Kandara</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-main: #334155;
            --text-muted: #64748b;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-bg); 
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar { 
            min-height: 100vh; 
            background-color: var(--sidebar-bg); 
            color: white;
            box-shadow: 10px 0 30px rgba(0,0,0,0.05);
            position: fixed;
            width: 260px;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 25px 25px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar-nav {
            padding: 20px 15px;
        }

        .sidebar-label {
            color: var(--text-muted);
            font-size: 0.7rem;
            text-uppercase;
            font-weight: 700;
            letter-spacing: 1.5px;
            margin-bottom: 10px;
            margin-top: 20px;
            padding-left: 10px;
        }

        .sidebar a { 
            color: #94a3b8; 
            text-decoration: none; 
            display: flex;
            align-items: center;
            padding: 12px 15px; 
            margin-bottom: 4px;
            border-radius: 12px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .sidebar a i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
            transition: all 0.2s;
        }

        .sidebar a:hover { 
            color: white; 
            background-color: var(--sidebar-hover); 
        }

        .sidebar a.active { 
            color: white; 
            background-color: var(--primary-color); 
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .sidebar a.active i {
            color: white;
        }

        /* Main Content Styling */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .navbar-top {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 15px 30px;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .content-padding {
            padding: 30px;
        }

        /* Card Customization */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card.hover-elevate:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }

        /* Button Styling */
        .btn {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.3);
        }

        /* Table Styling */
        .table thead th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
            padding: 15px 20px;
        }

        .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .bg-soft-primary { background-color: #eff6ff; color: #2563eb; }
        .bg-soft-success { background-color: #f0fdf4; color: #16a34a; }
        .bg-soft-warning { background-color: #fffbeb; color: #d97706; }
        .bg-soft-danger { background-color: #fef2f2; color: #dc2626; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            
            /* Sidebar Overlay/Backdrop */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(2px);
                z-index: 999;
                display: none;
                transition: opacity 0.3s ease;
            }
            .sidebar-overlay.active {
                display: block;
            }
        }
        
        @yield('styles')
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/dashboard') }}" class="sidebar-brand">
            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px; padding: 5px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                <img src="{{ asset('images/logo-gks.png') }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <div class="d-flex flex-column">
                <span class="text-white fw-bold" style="line-height: 1.1; font-size: 1.1rem; letter-spacing: 0.5px;">{{ $setting->singkatan_gereja ?? 'SIM GKS' }}</span>
                <span class="text-white-50" style="font-size: 9px; letter-spacing: 1px; font-weight: 700; text-transform: uppercase;">Sekretariat Jemaat</span>
            </div>
        </a>
    </div>
    
    <div class="sidebar-nav">
        <div class="sidebar-label">Utama</div>
        <a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        
        <div class="sidebar-label">Manajemen Data</div>
        <a href="{{ route('jemaat.index') }}" class="{{ Request::is('jemaat*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Data Jemaat
        </a>
        <a href="{{ route('pelayan.index') }}" class="{{ Request::is('pelayan*') ? 'active' : '' }}">
            <i class="fas fa-user-tie"></i> Pelayan Jemaat
        </a>
        
        <div class="sidebar-label">Operasional</div>
        <a href="{{ route('jadwal.index') }}" class="{{ Request::is('dashboard/jadwal*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Jadwal Ibadah
        </a>
        <a href="{{ route('warta.index') }}" class="{{ Request::is('dashboard/warta*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i> Warta Jemaat
        </a>
        <a href="{{ route('inventaris.index') }}" class="{{ Request::is('dashboard/inventaris*') ? 'active' : '' }}">
            <i class="fas fa-boxes"></i> Inventaris Aset
        </a>

        <div class="sidebar-label">Layanan & Konten Web</div>
        <a href="{{ route('admin.pendaftaran.index') }}" class="{{ Request::is('dashboard/pendaftaran*') ? 'active' : '' }}">
            <i class="fas fa-file-signature"></i> Pendaftaran Online
        </a>
        <a href="{{ route('admin.renungan.index') }}" class="{{ Request::is('dashboard/renungan*') ? 'active' : '' }}">
            <i class="fas fa-book-open"></i> Renungan & Khotbah
        </a>
        <a href="{{ route('admin.pengumuman.index') }}" class="{{ Request::is('dashboard/pengumuman*') ? 'active' : '' }}">
            <i class="fas fa-bullhorn"></i> Pengumuman Digital
        </a>
        <a href="{{ route('admin.galeri.index') }}" class="{{ Request::is('dashboard/galeri*') ? 'active' : '' }}">
            <i class="fas fa-images"></i> Galeri Foto
        </a>
        <a href="{{ route('admin.pengaturan.index') }}" class="{{ Request::is('dashboard/pengaturan*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Pengaturan Konten Web
        </a>

        <div class="mt-5 pt-4">
            <div class="px-3 mb-3">
                <div class="bg-dark rounded-4 p-3 d-flex align-items-center shadow-sm">
                    <div class="bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; min-width: 35px;">
                        <i class="fas fa-user-shield text-white small"></i>
                    </div>
                    <div class="overflow-hidden">
                        <div class="fw-bold text-white text-truncate small">{{ Auth::user()->jemaat->nama_lengkap ?? 'Admin' }}</div>
                        <div class="text-muted" style="font-size: 10px;">Administrator</div>
                    </div>
                </div>
            </div>
            <div class="px-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-bold border-0" style="background: rgba(220, 38, 38, 0.1);">
                        <i class="fas fa-sign-out-alt me-2"></i> KELUAR
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="main-wrapper">
    <nav class="navbar-top d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn btn-light d-lg-none me-3" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h5 class="mb-0 fw-bold text-dark">@yield('header', 'Ringkasan Sistem')</h5>
        </div>

        <div class="d-flex align-items-center">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text-end me-3 d-none d-md-block">
                        <div class="small fw-bold text-dark">{{ Auth::user()->jemaat->nama_lengkap ?? 'Admin' }}</div>
                        <div class="text-muted" style="font-size: 11px;">Administrator</div>
                    </div>
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                        <i class="fas fa-user"></i>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2 mt-3">
                    <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="fas fa-user-cog me-2 text-muted"></i> Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-padding">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" class="text-decoration-none text-muted small">Admin</a></li>
                @yield('breadcrumb')
            </ol>
        </nav>

        @yield('content')
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Sidebar Toggle for Mobile
        $('#sidebarToggle').click(function() {
            $('#sidebar').addClass('active');
            $('#sidebarOverlay').addClass('active');
        });

        // Sidebar Close and Overlay Click
        $('#sidebarOverlay').click(function() {
            $('#sidebar').removeClass('active');
            $('#sidebarOverlay').removeClass('active');
        });

        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap-5'
        });

        // Global SweetAlert2 for Delete Confirmation
        $(document).on('submit', '.delete-form', function (e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: 'Hapus Data?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#f8fafc',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4 border-0 shadow',
                    confirmButton: 'btn btn-primary px-4 py-2 rounded-pill fw-bold ms-2',
                    cancelButton: 'btn btn-light px-4 py-2 rounded-pill fw-bold text-muted'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Global SweetAlert2 for Success Messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-4 border-0 shadow'
                }
            });
        @endif
    });
</script>

@yield('scripts')
</body>
</html>
