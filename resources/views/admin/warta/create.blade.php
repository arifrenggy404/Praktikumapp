@extends('layouts.admin')

@section('title', 'Unggah Warta Jemaat')
@section('header', 'Unggah Warta Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-4 px-4 border-0">
                <h5 class="mb-0 fw-bold">Form Warta Jemaat</h5>
                <p class="text-muted small mb-0">Pastikan file dalam format PDF.</p>
            </div>
            <div class="card-body px-4 pb-4">
                <form action="{{ route('warta.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="judul" class="form-label small fw-bold text-muted text-uppercase">Judul Warta</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" placeholder="Contoh: Warta Jemaat Minggu 14 Juni 2026" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_terbit" class="form-label small fw-bold text-muted text-uppercase">Tanggal Terbit</label>
                        <input type="date" class="form-control @error('tanggal_terbit') is-invalid @enderror" id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit', date('Y-m-d')) }}" required>
                        @error('tanggal_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="file_warta" class="form-label small fw-bold text-muted text-uppercase">Pilih File PDF</label>
                        <input type="file" class="form-control @error('file_warta') is-invalid @enderror" id="file_warta" name="file_warta" accept="application/pdf" required>
                        <div class="form-text text-danger small mt-2">
                            <i class="fas fa-exclamation-triangle me-1"></i> File harus berformat PDF. Maksimal ukuran file adalah <strong>2MB</strong>.
                        </div>
                        @error('file_warta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('warta.index') }}" class="btn btn-light px-4 border fw-bold">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold">
                            <i class="fas fa-cloud-upload-alt me-2"></i> Publikasikan Warta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
