@extends('layouts.admin')

@section('title', 'Tambah Jemaat')
@section('header', 'Manajemen Warga Jemaat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('jemaat.index') }}" class="text-decoration-none text-muted small">Jemaat</a></li>
    <li class="breadcrumb-item active small" aria-current="page">Tambah Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-800 text-dark">Tambah Data Warga Jemaat Baru</h5>
                        <p class="text-muted small mb-0">Lengkapi formulir di bawah untuk mendaftarkan jemaat ke sistem.</p>
                    </div>
                    <a href="{{ route('jemaat.index') }}" class="btn btn-light btn-sm fw-bold">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body p-4 pt-0">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fs-4 me-3"></i>
                        <ul class="mb-0 small fw-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('jemaat.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="sidebar-label mt-0 mb-3 px-0">Informasi Pribadi</div>
                        </div>

                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label small fw-bold text-muted">NAMA LENGKAP</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: John Doe">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label small fw-bold text-muted">JENIS KELAMIN</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-venus-mars text-muted"></i></span>
                                <select class="form-select bg-light border-start-0 @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label small fw-bold text-muted">TEMPAT LAHIR</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Contoh: Waingapu">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label small fw-bold text-muted">TANGGAL LAHIR</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-day text-muted"></i></span>
                                <input type="date" class="form-control bg-light border-start-0 @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="alamat_domisili" class="form-label small fw-bold text-muted">ALAMAT DOMISILI</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-home text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 @error('alamat_domisili') is-invalid @enderror" id="alamat_domisili" name="alamat_domisili" value="{{ old('alamat_domisili') }}" required placeholder="Sumba Timur">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="sidebar-label mt-4 mb-3 px-0">Status Gerejawi</div>
                        </div>

                        <div class="col-md-6">
                            <label for="status_baptis" class="form-label small fw-bold text-muted">STATUS BAPTIS</label>
                            <select class="form-select bg-light @error('status_baptis') is-invalid @enderror" id="status_baptis" name="status_baptis" required>
                                <option value="Sudah" {{ old('status_baptis') == 'Sudah' ? 'selected' : '' }}>Sudah Baptis</option>
                                <option value="Belum" {{ old('status_baptis') == 'Belum' ? 'selected' : '' }}>Belum Baptis</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="status_sidi" class="form-label small fw-bold text-muted">STATUS SIDI</label>
                            <select class="form-select bg-light @error('status_sidi') is-invalid @enderror" id="status_sidi" name="status_sidi" required>
                                <option value="Sudah" {{ old('status_sidi') == 'Sudah' ? 'selected' : '' }}>Sudah Sidi</option>
                                <option value="Belum" {{ old('status_sidi') == 'Belum' ? 'selected' : '' }}>Belum Sidi</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light px-4 fw-bold text-muted">Reset</button>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">Simpan Data Jemaat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection