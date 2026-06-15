@extends('layouts.admin')

@section('title', 'Dashboard Utama')
@section('header', 'Ringkasan Sistem')

@section('breadcrumb')
    <li class="breadcrumb-item active small" aria-current="page">Dashboard</li>
@endsection

@section('styles')
    <style>
        .icon-shape {
            width: 48px;
            height: 48px;
            background-position: center;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 24px;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
    </style>
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner shadow-sm">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="fw-800 mb-2">Selamat Datang Kembali, {{ Auth::user()->jemaat->nama_lengkap ?? 'Admin' }}! 👋</h2>
            <p class="mb-0 opacity-75">Sistem Informasi Manajemen GKS Kandara siap membantu tugas pelayanan Anda hari ini.</p>
        </div>
        <div class="col-md-4 text-md-end d-none d-md-block">
            <img src="https://img.icons8.com/fluency/96/church.png" alt="Church icon">
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card hover-elevate border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="icon-shape bg-soft-primary me-3">
                    <i class="fas fa-users fs-5 text-primary"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Total Jemaat</h6>
                    <h3 class="fw-800 mb-0">{{ number_format($totalJemaat, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top">
                <span class="text-success small fw-bold"><i class="fas fa-arrow-up me-1"></i> Jiwa</span>
                <span class="text-muted small ms-1">Terdaftar aktif</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card hover-elevate border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="icon-shape bg-soft-success me-3">
                    <i class="fas fa-calendar-check fs-5 text-success"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Jadwal Minggu Ini</h6>
                    <h3 class="fw-800 mb-0">{{ $totalJadwal }}</h3>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top">
                <span class="text-primary small fw-bold"><i class="fas fa-clock me-1"></i> Ibadah</span>
                <span class="text-muted small ms-1">Agenda terdekat</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card hover-elevate border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="icon-shape bg-soft-warning me-3">
                    <i class="fas fa-box-open fs-5 text-warning"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Inventaris Aset</h6>
                    <h3 class="fw-800 mb-0">{{ number_format($totalInventaris, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top">
                <span class="text-warning small fw-bold"><i class="fas fa-tag me-1"></i> Unit</span>
                <span class="text-muted small ms-1">Aset gereja</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card hover-elevate border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="icon-shape bg-soft-danger me-3">
                    <i class="fas fa-file-invoice fs-5 text-danger"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Warta Terbaru</h6>
                    <h3 class="fw-800 mb-0">{{ \App\Models\Warta::count() }}</h3>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top">
                <span class="text-danger small fw-bold"><i class="fas fa-bullhorn me-1"></i> Publikasi</span>
                <span class="text-muted small ms-1">Informasi jemaat</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Jemaat Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Jemaat Terbaru</h5>
                <a href="{{ route('jemaat.index') }}" class="btn btn-light btn-sm text-primary fw-bold">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nama Jemaat</th>
                                <th>Status</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recentJemaat = \App\Models\Jemaat::latest()->take(5)->get();
                            @endphp
                            @forelse($recentJemaat as $j)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $j->nama_lengkap }}</div>
                                        <div class="text-muted small">ID: {{ str_pad($j->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-primary">Baptis: {{ $j->status_baptis }}</span>
                                    </td>
                                    <td><span class="text-muted small">{{ $j->alamat_domisili }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted small">Belum ada data jemaat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links / Info -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body pt-0">
                <div class="d-grid gap-2">
                    <a href="{{ route('jemaat.create') }}" class="btn btn-outline-primary text-start">
                        <i class="fas fa-user-plus me-2"></i> Tambah Jemaat Baru
                    </a>
                    <a href="{{ route('jadwal.create') }}" class="btn btn-outline-success text-start">
                        <i class="fas fa-calendar-plus me-2"></i> Buat Jadwal Ibadah
                    </a>
                    <a href="{{ route('warta.index') }}" class="btn btn-outline-info text-start">
                        <i class="fas fa-upload me-2"></i> Unggah Warta Jemaat
                    </a>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection