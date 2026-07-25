@extends('layouts.admin')

@section('title', 'Tambah Anggota Keluarga Jemaat')
@section('header', 'Manajemen Warga Jemaat')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-user-plus text-primary me-2"></i> Tambah Anggota Keluarga Jemaat</h5>
                        <p class="text-muted small mb-0">Daftarkan anggota keluarga ke dalam No. Kartu Keluarga (KK) Gereja.</p>
                    </div>
                    <a href="{{ route('jemaat.index') }}" class="btn btn-outline-secondary btn-sm fw-bold rounded-3">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
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
                        <!-- DATA KELUARGA & KEPALA KK -->
                        <div class="col-12">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-id-card me-2 text-warning"></i> Data Kartu Keluarga (KK)</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NOMOR KK GEREJA <span class="text-danger">*</span></label>
                            <input type="text" name="no_kk_gereja" class="form-control" value="{{ old('no_kk_gereja', 'KK-00' . rand(4, 99)) }}" required placeholder="Contoh: KK-001">
                            <small class="text-muted">Gunakan No. KK yang sama untuk menggabungkan anggota keluarga dalam 1 KK.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">PERAN DALAM KELUARGA <span class="text-danger">*</span></label>
                            <select name="peran_keluarga" class="form-select" required>
                                <option value="Kepala Keluarga (Ayah)" {{ old('peran_keluarga') == 'Kepala Keluarga (Ayah)' ? 'selected' : '' }}>Kepala Keluarga (Ayah)</option>
                                <option value="Istri (Ibu)" {{ old('peran_keluarga') == 'Istri (Ibu)' ? 'selected' : '' }}>Istri (Ibu)</option>
                                <option value="Anak" {{ old('peran_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                <option value="Anggota Keluarga Lain" {{ old('peran_keluarga') == 'Anggota Keluarga Lain' ? 'selected' : '' }}>Anggota Keluarga Lain</option>
                            </select>
                        </div>

                        <!-- INFORMASI PRIBADI ANGGOTA -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-user me-2 text-warning"></i> Data Pribadi Anggota Keluarga</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NAMA LENGKAP <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap sesuai KTP/Akta">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">JENIS KELAMIN <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">TEMPAT LAHIR <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required placeholder="Contoh: Waingapu">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">TANGGAL LAHIR <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">ALAMAT DOMISILI <span class="text-danger">*</span></label>
                            <input type="text" name="alamat_domisili" class="form-control" value="{{ old('alamat_domisili') }}" required placeholder="Contoh: Kandara RT 01">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NO. HP / WHATSAPP (OPSIONAL)</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890">
                        </div>

                        <!-- STATUS GEREJAWI -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-church me-2 text-warning"></i> Status Gerejawi</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">STATUS BAPTIS <span class="text-danger">*</span></label>
                            <select name="status_baptis" class="form-select" required>
                                <option value="Sudah" {{ old('status_baptis') == 'Sudah' ? 'selected' : '' }}>Sudah Baptis</option>
                                <option value="Belum" {{ old('status_baptis') == 'Belum' ? 'selected' : '' }}>Belum Baptis</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">STATUS SIDI <span class="text-danger">*</span></label>
                            <select name="status_sidi" class="form-select" required>
                                <option value="Sudah" {{ old('status_sidi') == 'Sudah' ? 'selected' : '' }}>Sudah Sidi</option>
                                <option value="Belum" {{ old('status_sidi') == 'Belum' ? 'selected' : '' }}>Belum Sidi</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('jemaat.index') }}" class="btn btn-light px-4 fw-bold rounded-3">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold rounded-3 shadow-sm">Simpan Anggota Keluarga</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection