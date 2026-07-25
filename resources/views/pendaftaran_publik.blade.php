@extends('layouts.app')

@section('title', 'Pendaftaran Online - ' . ($setting->singkatan_gereja ?? 'GKS Kandara'))

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center py-4">
        <h1 class="serif display-4 fw-bold text-warning mb-3">Formulir Pendaftaran Online</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 750px;">
            Layanan pendaftaran Sakramen Baptis Kudus, Sidi, Pernikahan, Konseling Pastoral, & Permohonan Doa di {{ $setting->nama_gereja ?? 'GKS Kandara' }}.
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 p-4 mb-4 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                        <div>
                            <h5 class="fw-bold mb-1">Berhasil Dikirim!</h5>
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                <div class="card-header bg-primary text-white p-4">
                    <h4 class="serif fw-bold mb-1 text-warning"><i class="fas fa-file-signature me-2"></i> Form Permohonan Pelayanan</h4>
                    <p class="small opacity-75 mb-0">Isi formulir dengan lengkap. Sekretariat {{ $setting->singkatan_gereja ?? 'GKS Kandara' }} akan segera menghubungi Anda.</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('public.pendaftaran.store') }}" method="POST">
                        @csrf

                        <!-- PILIH JENIS PENDAFTARAN -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark fs-5">1. Pilih Jenis Layanan Pendaftaran <span class="text-danger">*</span></label>
                            <select name="jenis_pendaftaran" class="form-select form-select-lg rounded-3 border-2" required>
                                <option value="" disabled selected>-- Pilih Layanan --</option>
                                <option value="Baptis">Pendaftaran Baptis Kudus (Anak / Dewasa)</option>
                                <option value="Sidi">Pendaftaran Peneguhan Sidi</option>
                                <option value="Pernikahan">Pemberkatan Pernikahan Kudus</option>
                                <option value="Konseling">Konseling Pastoral dengan Gembala</option>
                                <option value="Permohonan Doa">Permohonan Doa Khusus / Syafaat</option>
                            </select>
                        </div>

                        <!-- DATA PEMOHON -->
                        <h5 class="serif fw-bold text-primary mb-3 border-bottom pb-2">2. Data Diri Pemohon</h5>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control form-control-lg" placeholder="Masukkan nama lengkap sesuai KTP / Akta" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">No. HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="no_hp_wa" class="form-control form-control-lg" placeholder="Contoh: 081234567890" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Alamat Email (Opsional)</label>
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="contoh@email.com">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap Tinggal <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat rumah / lingkungan jemaat..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Catatan / Keterangan Permohonan (Opsional)</label>
                            <textarea name="catatan_keterangan" class="form-control" rows="4" placeholder="Tuliskan keterangan detail permohonan atau nama calon yang dibaptis/dinikahkan..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold rounded-3 shadow text-dark py-3 fs-5">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Permohonan Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
