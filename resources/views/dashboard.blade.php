@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Dashboard Sistem Informasi Gereja</h3>
        <p class="text-muted small mb-0">Selamat Datang, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong> di SIM GKS Jemaat Kandara.</p>
    </div>
    <div>
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-primary rounded-3"><i class="fas fa-globe me-1"></i> Buka Website Publik</a>
    </div>
</div>

<!-- CARDS RINGKASAN DATA -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-primary">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle text-primary p-3 rounded-3 me-3"><i class="fas fa-users fa-2x"></i></div>
                <div>
                    <div class="text-muted small fw-bold">Total Warga Jemaat</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalJemaat) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-warning">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle text-warning p-3 rounded-3 me-3"><i class="fas fa-file-signature fa-2x"></i></div>
                <div>
                    <div class="text-muted small fw-bold">Pendaftaran Online</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalPendaftaran }} <small class="fs-6 text-danger">({{ $pendaftaranPending }} Pending)</small></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-success">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle text-success p-3 rounded-3 me-3"><i class="fas fa-calendar-alt fa-2x"></i></div>
                <div>
                    <div class="text-muted small fw-bold">Jadwal Pelayanan</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalJadwal }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-info">
            <div class="d-flex align-items-center">
                <div class="bg-info-subtle text-info p-3 rounded-3 me-3"><i class="fas fa-images fa-2x"></i></div>
                <div>
                    <div class="text-muted small fw-bold">Galeri & Renungan</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalGaleri + $totalRenungan }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RECENT PERMOHONAN PENDAFTARAN -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-clock text-warning me-2"></i> Pendaftaran Online Terbaru</h5>
        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">Kelola Semua Pendaftaran</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Layanan</th>
                        <th>Nama Pemohon</th>
                        <th>Kontak WA</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaranTerbaru as $pt)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $pt->created_at->format('d-m-Y H:i') }}</td>
                            <td><span class="badge bg-primary">{{ $pt->jenis_pendaftaran }}</span></td>
                            <td class="fw-bold text-dark">{{ $pt->nama_lengkap }}</td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pt->no_hp_wa) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill py-0">
                                    <i class="fab fa-whatsapp me-1"></i> {{ $pt->no_hp_wa }}
                                </a>
                            </td>
                            <td>
                                @if($pt->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($pt->status == 'Disetujui')
                                    <span class="badge bg-info text-dark">Disetujui</span>
                                @elseif($pt->status == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada permohonan pendaftaran baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection